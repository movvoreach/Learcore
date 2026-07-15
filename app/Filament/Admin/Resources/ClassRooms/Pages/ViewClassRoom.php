<?php

namespace App\Filament\Admin\Resources\ClassRooms\Pages;

use App\Filament\Admin\Resources\ClassRooms\ClassRoomResource;
use App\Filament\Admin\Resources\Certificates\CertificateResource;
use App\Filament\Admin\Resources\Enrollments\EnrollmentResource;
use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use App\Models\Attendance;
use App\Models\AssignmentSubmission;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Models\User;
use Filament\Actions\Action as NotificationAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class ViewClassRoom extends ViewRecord
{
    protected static string $resource = ClassRoomResource::class;

    protected string $view = 'filament.admin.resources.class-rooms.pages.view-class-room';

    protected static ?string $title = 'Class Students';

    protected static ?string $breadcrumb = 'View';

    public ?int $studentId = null;

    public array $scores = [];

    public array $attributeScores = [];

    public array $midtermScores = [];

    public array $finalScores = [];

    public ?int $certificateStudentId = null;

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getEnrollments(): Collection
    {
        return $this->record
            ->enrollments()
            ->with(['student.department', 'academicYear', 'semester'])
            ->orderByDesc('enrollment_date')
            ->get();
    }

    public function getStudentOptions(): Collection
    {
        return Student::query()
            ->whereDoesntHave('enrollments', fn ($query) => $query
                ->where('class_room_id', $this->record->class_room_id))
            ->orderBy('student_code')
            ->get(['student_id', 'student_code', 'first_name', 'last_name']);
    }

    public function getStudentMetrics(Collection $enrollments): Collection
    {
        $studentIds = $enrollments->pluck('student_id')->filter()->values();

        $progresses = StudentProgress::query()
            ->where('class_room_id', $this->record->class_room_id)
            ->whereIn('student_id', $studentIds)
            ->latest('progress_date')
            ->get()
            ->unique('student_id')
            ->keyBy('student_id');

        $attendances = Attendance::query()
            ->where('class_room_id', $this->record->class_room_id)
            ->whereIn('student_id', $studentIds)
            ->get()
            ->groupBy('student_id');

        return $studentIds->mapWithKeys(function (int $studentId) use ($progresses, $attendances): array {
            $progress = $progresses->get($studentId);
            $studentAttendances = $attendances->get($studentId, collect());
            $presentCount = $studentAttendances
                ->filter(fn (Attendance $attendance): bool => in_array($attendance->status, ['present', 'late'], true))
                ->count();
            $totalCount = $studentAttendances->count();
            $attendancePercent = $totalCount > 0 ? round(($presentCount / $totalCount) * 100) : 0;
            $attendanceScore = round($attendancePercent * 0.10, 2);

            $this->attributeScores[$studentId] ??= number_format((float) ($progress?->attribute_score ?? 0), 2, '.', '');
            $this->midtermScores[$studentId] ??= number_format((float) ($progress?->midterm_score ?? 0), 2, '.', '');
            $assignmentScore = $this->assignmentScoreForStudent($studentId);
            $this->finalScores[$studentId] ??= number_format((float) ($progress?->final_score ?? 0), 2, '.', '');

            $totalScore = $this->calculateTotalScore(
                $attendanceScore,
                $progress?->attribute_score,
                $progress?->midterm_score,
                $assignmentScore,
                $progress?->final_score,
            );

            $this->scores[$studentId] = number_format($totalScore, 2, '.', '');

            return [
                $studentId => [
                    'score' => $totalScore,
                    'attendance_score' => $attendanceScore,
                    'attribute_score' => $progress?->attribute_score,
                    'midterm_score' => $progress?->midterm_score,
                    'assignment_score' => $assignmentScore,
                    'final_score' => $progress?->final_score,
                    'result' => $totalScore >= 50 ? 'pass' : 'fail',
                    'attendance_present' => $presentCount,
                    'attendance_total' => $totalCount,
                    'attendance_percent' => $attendancePercent,
                ],
            ];
        });
    }

    public function getCertificates(Collection $enrollments): Collection
    {
        return Certificate::query()
            ->where('course_id', $this->record->course_id)
            ->whereIn('student_id', $enrollments->pluck('student_id')->filter())
            ->get()
            ->keyBy('student_id');
    }

    public function canManageClassStudents(): bool
    {
        return EnrollmentResource::canCreate();
    }

    public function canEditClassScores(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    public function addStudentToClass(): void
    {
        abort_unless($this->canManageClassStudents(), 403);

        $this->validate([
            'studentId' => ['required', 'integer', 'exists:students,student_id'],
        ], [
            'studentId.required' => 'Please select a student.',
        ]);

        $alreadyEnrolled = Enrollment::query()
            ->where('student_id', $this->studentId)
            ->where('class_room_id', $this->record->class_room_id)
            ->exists();

        if ($alreadyEnrolled) {
            $this->addError('studentId', 'This student is already enrolled in this class.');

            return;
        }

        $course = $this->record->course;

        Enrollment::query()->create([
            'student_id' => $this->studentId,
            'course_id' => $this->record->course_id,
            'class_room_id' => $this->record->class_room_id,
            'academic_year_id' => $this->record->academic_year_id ?? $course?->academic_year_id,
            'semester_id' => $course?->semester_id,
            'enrollment_date' => now()->toDateString(),
            'status' => 'studying',
            'note' => 'Registered for class.',
        ]);

        $this->studentId = null;
        $this->dispatch('close-add-student-modal');

        Notification::make()
            ->success()
            ->title('Student enrolled to class successfully')
            ->send();
    }

    public function removeEnrollment(int $enrollmentId): void
    {
        abort_unless($this->canManageClassStudents(), 403);

        Enrollment::query()
            ->whereKey($enrollmentId)
            ->where('class_room_id', $this->record->class_room_id)
            ->delete();

        Notification::make()
            ->success()
            ->title('Student removed from class')
            ->send();
    }

    public function saveScore(int $studentId): void
    {
        $this->saveGradeScores($studentId);
    }

    public function saveGradeScores(int $studentId): void
    {
        abort_unless($this->canEditClassScores(), 403);

        $this->validate([
            "attributeScores.{$studentId}" => ['nullable', 'numeric', 'min:0', 'max:10'],
            "midtermScores.{$studentId}" => ['nullable', 'numeric', 'min:0', 'max:20'],
            "finalScores.{$studentId}" => ['nullable', 'numeric', 'min:0', 'max:40'],
        ]);

        $attendanceScore = $this->attendanceScoreForStudent($studentId);
        $attributeScore = $this->normalizeScore($this->attributeScores[$studentId] ?? null, 10);
        $midtermScore = $this->normalizeScore($this->midtermScores[$studentId] ?? null, 20);
        $assignmentScore = $this->assignmentScoreForStudent($studentId);
        $finalScore = $this->normalizeScore($this->finalScores[$studentId] ?? null, 40);
        $totalScore = $this->calculateTotalScore($attendanceScore, $attributeScore, $midtermScore, $assignmentScore, $finalScore);

        StudentProgress::query()->updateOrCreate(
            [
                'student_id' => $studentId,
                'course_id' => $this->record->course_id,
                'class_room_id' => $this->record->class_room_id,
            ],
            [
                'progress_date' => now()->toDateString(),
                'progress_percent' => $totalScore,
                'score' => $totalScore,
                'attendance_score' => $attendanceScore,
                'attribute_score' => $attributeScore,
                'midterm_score' => $midtermScore,
                'assignment_score' => $assignmentScore,
                'final_score' => $finalScore,
                'status' => $totalScore >= 50 ? 'pass' : 'fail',
            ],
        );

        $this->scores[$studentId] = number_format($totalScore, 2, '.', '');
        $this->attributeScores[$studentId] = number_format($attributeScore, 2, '.', '');
        $this->midtermScores[$studentId] = number_format($midtermScore, 2, '.', '');
        $this->finalScores[$studentId] = number_format($finalScore, 2, '.', '');

        Notification::make()
            ->success()
            ->title('Score saved')
            ->body('Total: '.number_format($totalScore, 2).' / 100 - '.($totalScore >= 50 ? 'Pass' : 'Fail'))
            ->send();
    }

    public function requestCertificate(int $studentId): void
    {
        abort_unless($this->canEditClassScores(), 403);

        $enrollment = Enrollment::query()
            ->where('student_id', $studentId)
            ->where('class_room_id', $this->record->class_room_id)
            ->firstOrFail();

        $progress = StudentProgress::query()
            ->where('student_id', $studentId)
            ->where('course_id', $this->record->course_id)
            ->where('class_room_id', $this->record->class_room_id)
            ->latest('progress_date')
            ->first();

        if (! $this->isCertificateEligible($enrollment->status, $this->totalScoreFromProgress($studentId, $progress))) {
            $this->addError('certificateStudentId', 'Student must be completed and passed before requesting certificate.');

            return;
        }

        $certificate = $this->requestCertificateForEnrollment($enrollment);

        $this->certificateStudentId = null;
        $this->dispatch('close-certificate-request-modal');
        $this->notifyCertificateAdmins($certificate, 1);

        Notification::make()
            ->success()
            ->title('Certificate request sent to admin')
            ->send();
    }

    public function requestClassCertificates(): void
    {
        abort_unless($this->canEditClassScores(), 403);

        $enrollments = $this->record
            ->enrollments()
            ->with('student')
            ->get();

        $studentIds = $enrollments->pluck('student_id')->filter()->values();
        $progresses = StudentProgress::query()
            ->where('course_id', $this->record->course_id)
            ->where('class_room_id', $this->record->class_room_id)
            ->whereIn('student_id', $studentIds)
            ->latest('progress_date')
            ->get()
            ->unique('student_id')
            ->keyBy('student_id');

        $requested = collect();

        foreach ($enrollments as $enrollment) {
            $progress = $progresses->get($enrollment->student_id);
            $existingCertificate = Certificate::query()
                ->where('student_id', $enrollment->student_id)
                ->where('course_id', $this->record->course_id)
                ->first();

            if (! $this->isCertificateEligible($enrollment->status, $this->totalScoreFromProgress($enrollment->student_id, $progress))) {
                continue;
            }

            if ($existingCertificate && in_array($existingCertificate->status, ['pending', 'issued'], true)) {
                continue;
            }

            $certificate = $this->requestCertificateForEnrollment($enrollment);

            if ($certificate->status === 'pending') {
                $requested->push($certificate);
            }
        }

        $this->dispatch('close-certificate-overview-modal');

        if ($requested->isEmpty()) {
            Notification::make()
                ->warning()
                ->title('No students ready for certificate request')
                ->body('Students must be completed and have score 50 or higher.')
                ->send();

            return;
        }

        $this->notifyCertificateAdmins($requested->first(), $requested->count());

        Notification::make()
            ->success()
            ->title($requested->count().' certificate requests sent to admin')
            ->send();
    }

    public function isCertificateEligible(?string $status, mixed $score): bool
    {
        return in_array($status, ['completed', 'passed', 'pass'], true)
            && is_numeric($score)
            && (float) $score >= 50;
    }

    private function attendanceScoreForStudent(int $studentId): float
    {
        $attendances = Attendance::query()
            ->where('class_room_id', $this->record->class_room_id)
            ->where('student_id', $studentId)
            ->get();

        $totalCount = $attendances->count();

        if ($totalCount === 0) {
            return 0.0;
        }

        $presentCount = $attendances
            ->filter(fn (Attendance $attendance): bool => in_array($attendance->status, ['present', 'late'], true))
            ->count();

        return round(($presentCount / $totalCount) * 10, 2);
    }

    private function assignmentScoreForStudent(int $studentId): float
    {
        $submissions = AssignmentSubmission::query()
            ->where('student_id', $studentId)
            ->whereNotNull('score')
            ->whereHas('assignment.lesson', fn ($query) => $query
                ->where('course_id', $this->record->course_id))
            ->with('assignment')
            ->get();

        if ($submissions->isEmpty()) {
            return 0.0;
        }

        $percentages = $submissions
            ->map(function (AssignmentSubmission $submission): ?float {
                $maxScore = (float) ($submission->assignment?->max_score ?? 100);

                if ($maxScore <= 0) {
                    return null;
                }

                return min(max(((float) $submission->score / $maxScore) * 100, 0), 100);
            })
            ->filter(fn (?float $score): bool => $score !== null);

        if ($percentages->isEmpty()) {
            return 0.0;
        }

        return round(($percentages->avg() / 100) * 20, 2);
    }

    private function normalizeScore(mixed $score, float $max): float
    {
        if ($score === '' || $score === null || ! is_numeric($score)) {
            return 0.0;
        }

        return round(min(max((float) $score, 0), $max), 2);
    }

    private function calculateTotalScore(
        mixed $attendanceScore,
        mixed $attributeScore,
        mixed $midtermScore,
        mixed $assignmentScore,
        mixed $finalScore,
    ): float {
        return round(
            $this->normalizeScore($attendanceScore, 10)
            + $this->normalizeScore($attributeScore, 10)
            + $this->normalizeScore($midtermScore, 20)
            + $this->normalizeScore($assignmentScore, 20)
            + $this->normalizeScore($finalScore, 40),
            2,
        );
    }

    private function totalScoreFromProgress(int $studentId, ?StudentProgress $progress): float
    {
        return $this->calculateTotalScore(
            $this->attendanceScoreForStudent($studentId),
            $progress?->attribute_score,
            $progress?->midterm_score,
            $this->assignmentScoreForStudent($studentId),
            $progress?->final_score,
        );
    }

    private function nextCertificateRequestNo(): string
    {
        do {
            $number = 'REQ-'.now()->format('YmdHis').'-'.random_int(100, 999);
        } while (Certificate::query()->where('certificate_no', $number)->exists());

        return $number;
    }

    private function requestCertificateForEnrollment(Enrollment $enrollment): Certificate
    {
        $certificate = Certificate::query()
            ->where('student_id', $enrollment->student_id)
            ->where('course_id', $this->record->course_id)
            ->first();

        if ($certificate) {
            if ($certificate->status !== 'issued') {
                $certificate->update([
                    'status' => 'pending',
                    'note' => 'Certificate requested from class '.$this->record->class_name.'.',
                ]);
            }

            return $certificate;
        }

        return Certificate::query()->create([
            'student_id' => $enrollment->student_id,
            'course_id' => $this->record->course_id,
            'certificate_no' => $this->nextCertificateRequestNo(),
            'issued_date' => null,
            'status' => 'pending',
            'note' => 'Certificate requested from class '.$this->record->class_name.'.',
        ]);
    }

    private function notifyCertificateAdmins(Certificate $certificate, int $requestCount): void
    {
        if (! Schema::hasTable('notifications')) {
            return;
        }

        $admins = User::role(['super_admin', 'admin'])->get();

        if ($admins->isEmpty()) {
            return;
        }

        $student = $certificate->student;
        $studentName = trim(($student?->first_name ?? '').' '.($student?->last_name ?? '')) ?: 'Student';
        $body = $requestCount > 1
            ? $requestCount.' certificate requests were sent for '.$this->record->class_name.'.'
            : $studentName.' requested a certificate for '.$this->record->class_name.'.';

        Notification::make()
            ->success()
            ->title('New certificate request')
            ->body($body)
            ->actions([
                NotificationAction::make('view')
                    ->label('View requests')
                    ->url(CertificateResource::getUrl('index')),
            ])
            ->sendToDatabase($admins, isEventDispatched: true);
    }

    public function getTeacherName(): string
    {
        $teacher = $this->record
            ->courseAssignments()
            ->with('teacher')
            ->first()
            ?->teacher
            ?? $this->record
                ->teacherSchedules()
                ->with('teacher')
                ->first()
                ?->teacher;

        return $teacher
            ? trim(($teacher->first_name ?? '').' '.($teacher->last_name ?? ''))
            : '-';
    }

    public function getAttendanceSheetUrl(): ?string
    {
        $schedule = Schedule::query()
            ->where('class_id', $this->record->class_room_id)
            ->orderBy('day')
            ->orderBy('start_time')
            ->first();

        return $schedule
            ? ScheduleResource::getUrl('attendance-sheet', ['record' => $schedule])
            : null;
    }
}
