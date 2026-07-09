<?php

namespace App\Filament\Admin\Pages;

use App\Models\AssessmentGrade;
use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\ContentAssignment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\Quiz;
use App\Models\StudentProgress;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CourseStudents extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'course/{course}/students';

    protected static ?string $title = 'និស្សិតក្នុងវគ្គសិក្សា';

    protected string $view = 'filament.admin.pages.course-students';

    public Course $courseRecord;

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $scores = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    public function mount(mixed $course): void
    {
        $user = auth()->user();
        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin', 'teacher']), 403);

        $courseId = $course instanceof Course ? (int) $course->getKey() : (int) $course;

        $courseQuery = Course::query()
            ->with(['department', 'academicYear', 'semester', 'category', 'courseAssignments.teacher'])
            ->whereKey($courseId);

        if ($user->hasRole('teacher') && ! $user->hasAnyRole(['super_admin', 'admin'])) {
            abort_unless($user->teacher, 403);

            $courseQuery->whereHas('courseAssignments', fn (Builder $query): Builder => $query
                ->where('teacher_id', $user->teacher->teacher_id));
        }

        $this->courseRecord = $courseQuery->firstOrFail();

        $this->initializeScores();
    }

    public function getTitle(): string
    {
        return 'និស្សិត: '.$this->courseRecord->course_name;
    }

    public function saveGrade(int $studentId): void
    {
        $user = auth()->user();
        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin', 'teacher']), 403);

        foreach ($this->scoreCategories() as $category) {
            $score = trim((string) ($this->scores[$studentId][$category] ?? ''));

            if ($score === '') {
                continue;
            }

            $scoreValue = max(0, min(100, (float) $score));

            AssessmentGrade::query()->updateOrCreate(
                [
                    'student_id' => $studentId,
                    'remarks' => $this->summaryRemark($category),
                ],
                [
                    'exam_id' => null,
                    'quiz_id' => null,
                    'content_assignment_id' => null,
                    'score' => $scoreValue,
                    'max_score' => 100,
                    'grade' => $this->letterGrade($scoreValue),
                    'graded_by' => $user->id,
                    'graded_at' => now(),
                ],
            );

            $this->scores[$studentId][$category] = $scoreValue;
        }

        $this->dispatch('notify', type: 'success', message: 'បានរក្សាទុកពិន្ទុដោយជោគជ័យ។');
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $enrollments = $this->getEnrollments();
        $assignments = $this->getAssignments();
        $quizzes = $this->getQuizzes();
        $exams = $this->getExams();
        $teacher = $this->courseRecord->courseAssignments->first()?->teacher;

        return [
            'course' => $this->courseRecord,
            'enrollments' => $enrollments,
            'studentSummaries' => $this->studentSummaries($enrollments),
            'assignments' => $assignments,
            'quizzes' => $quizzes,
            'exams' => $exams,
            'teacherName' => $teacher ? trim($teacher->first_name.' '.$teacher->last_name) : 'មិនទាន់កំណត់',
            'totalStudents' => $enrollments->count(),
            'scoreLabels' => [
                'assignments' => 'កិច្ចការ',
                'quizzes' => 'តេស្តខ្លី',
                'midterm' => 'ប្រឡងពាក់កណ្តាល',
                'final' => 'ប្រឡងចុងក្រោយ',
                'project' => 'គម្រោង',
            ],
        ];
    }

    private function initializeScores(): void
    {
        $summaryGrades = $this->getExistingSummaryGrades();
        $itemGrades = $this->getExistingGrades();
        $this->scores = [];

        foreach ($this->getEnrollments() as $enrollment) {
            $studentId = (int) $enrollment->student_id;
            $studentItemGrades = $itemGrades->where('student_id', $studentId);

            $this->scores[$studentId] = [
                'assignments' => $this->summaryScore($summaryGrades, $studentId, 'assignments')
                    ?? $this->averageScore($studentItemGrades->whereNotNull('content_assignment_id')),
                'quizzes' => $this->summaryScore($summaryGrades, $studentId, 'quizzes')
                    ?? $this->averageScore($studentItemGrades->whereNotNull('quiz_id')),
                'midterm' => $this->summaryScore($summaryGrades, $studentId, 'midterm')
                    ?? $this->examScoreByTitle($studentItemGrades, ['midterm', 'ពាក់កណ្តាល']),
                'final' => $this->summaryScore($summaryGrades, $studentId, 'final')
                    ?? $this->examScoreByTitle($studentItemGrades, ['final', 'ចុងក្រោយ']),
                'project' => $this->summaryScore($summaryGrades, $studentId, 'project')
                    ?? $this->examScoreByTitle($studentItemGrades, ['project', 'គម្រោង']),
            ];
        }
    }

    private function getEnrollments(): Collection
    {
        return Enrollment::query()
            ->where('course_id', $this->courseRecord->course_id)
            ->with(['student', 'course'])
            ->orderBy('enrollment_date')
            ->get();
    }

    private function getAssignments(): Collection
    {
        return ContentAssignment::query()
            ->whereHas('lesson', fn (Builder $query): Builder => $query->where('course_id', $this->courseRecord->course_id))
            ->with('lesson')
            ->orderBy('due_at')
            ->get();
    }

    private function getQuizzes(): Collection
    {
        return Quiz::query()
            ->whereHas('lesson', fn (Builder $query): Builder => $query->where('course_id', $this->courseRecord->course_id))
            ->with('lesson')
            ->orderBy('available_from')
            ->get();
    }

    private function getExams(): Collection
    {
        return Exam::query()
            ->where('course_id', $this->courseRecord->course_id)
            ->orderBy('exam_date')
            ->get();
    }

    private function getExistingGrades(): Collection
    {
        $studentIds = Enrollment::query()
            ->where('course_id', $this->courseRecord->course_id)
            ->pluck('student_id');

        return AssessmentGrade::query()
            ->whereIn('student_id', $studentIds)
            ->where(function (Builder $query): void {
                $query
                    ->whereHas('exam', fn (Builder $q): Builder => $q->where('course_id', $this->courseRecord->course_id))
                    ->orWhereHas('quiz.lesson', fn (Builder $q): Builder => $q->where('course_id', $this->courseRecord->course_id))
                    ->orWhereHas('assignment.lesson', fn (Builder $q): Builder => $q->where('course_id', $this->courseRecord->course_id));
            })
            ->with(['exam'])
            ->get();
    }

    private function getExistingSummaryGrades(): Collection
    {
        $studentIds = Enrollment::query()
            ->where('course_id', $this->courseRecord->course_id)
            ->pluck('student_id');

        return AssessmentGrade::query()
            ->whereIn('student_id', $studentIds)
            ->whereIn('remarks', collect($this->scoreCategories())->map(fn (string $category): string => $this->summaryRemark($category)))
            ->get();
    }

    private function studentSummaries(Collection $enrollments): Collection
    {
        $studentIds = $enrollments->pluck('student_id')->filter()->values();
        $classRoomIds = $enrollments->pluck('class_room_id')->filter()->values();

        $progresses = StudentProgress::query()
            ->where('course_id', $this->courseRecord->course_id)
            ->whereIn('student_id', $studentIds)
            ->latest('updated_at')
            ->get()
            ->keyBy('student_id');

        $certificates = Certificate::query()
            ->where('course_id', $this->courseRecord->course_id)
            ->whereIn('student_id', $studentIds)
            ->latest('issued_date')
            ->get()
            ->keyBy('student_id');

        $attendances = Attendance::query()
            ->whereIn('student_id', $studentIds)
            ->when($classRoomIds->isNotEmpty(), fn (Builder $query): Builder => $query->whereIn('class_room_id', $classRoomIds))
            ->get()
            ->groupBy('student_id');

        $gradeActivity = AssessmentGrade::query()
            ->whereIn('student_id', $studentIds)
            ->where(function (Builder $query): void {
                $query
                    ->where('remarks', 'like', 'course_students_summary:'.$this->courseRecord->course_id.':%')
                    ->orWhereHas('exam', fn (Builder $q): Builder => $q->where('course_id', $this->courseRecord->course_id))
                    ->orWhereHas('quiz.lesson', fn (Builder $q): Builder => $q->where('course_id', $this->courseRecord->course_id))
                    ->orWhereHas('assignment.lesson', fn (Builder $q): Builder => $q->where('course_id', $this->courseRecord->course_id));
            })
            ->latest('updated_at')
            ->get()
            ->keyBy('student_id');

        return $enrollments->mapWithKeys(function (Enrollment $enrollment) use ($progresses, $certificates, $attendances, $gradeActivity): array {
            $studentId = (int) $enrollment->student_id;
            $studentAttendances = $attendances->get($studentId, collect());
            $progress = $progresses->get($studentId);
            $certificate = $certificates->get($studentId);
            $grade = $gradeActivity->get($studentId);
            $latestAttendance = $studentAttendances->sortByDesc('updated_at')->first();
            $lastActivity = collect([
                $enrollment->updated_at,
                $progress?->updated_at,
                $certificate?->updated_at,
                $grade?->updated_at,
                $latestAttendance?->updated_at,
            ])->filter()->sortDesc()->first();
            $totalScore = $this->totalScore($studentId);

            return [
                $studentId => [
                    'progress' => $progress ? number_format((float) $progress->progress_percent, 0).'%' : '-',
                    'attendance' => $this->attendancePercent($studentAttendances),
                    'total_score' => $totalScore,
                    'grade' => $this->letterGrade($totalScore),
                    'score_status' => $this->scoreStatusLabel($totalScore),
                    'enrollment_status' => $this->enrollmentStatusLabel($enrollment->status),
                    'certificate' => $certificate?->certificate_no ?? 'មិនទាន់មាន',
                    'last_activity' => $lastActivity ? $lastActivity->format('Y-m-d H:i') : '-',
                ],
            ];
        });
    }

    /**
     * @return array<int, string>
     */
    private function scoreCategories(): array
    {
        return ['assignments', 'quizzes', 'midterm', 'final', 'project'];
    }

    private function summaryRemark(string $category): string
    {
        return 'course_students_summary:'.$this->courseRecord->course_id.':'.$category;
    }

    private function summaryScore(Collection $grades, int $studentId, string $category): float|string|null
    {
        $grade = $grades
            ->where('student_id', $studentId)
            ->where('remarks', $this->summaryRemark($category))
            ->first();

        return $grade ? (float) $grade->score : null;
    }

    private function averageScore(Collection $grades): float|string
    {
        if ($grades->isEmpty()) {
            return '';
        }

        return round((float) $grades->avg(fn (AssessmentGrade $grade): float => $this->percentageScore($grade)), 2);
    }

    /**
     * @param  array<int, string>  $needles
     */
    private function examScoreByTitle(Collection $grades, array $needles): float|string
    {
        $grade = $grades
            ->whereNotNull('exam_id')
            ->first(function (AssessmentGrade $grade) use ($needles): bool {
                $title = mb_strtolower((string) $grade->exam?->title);

                foreach ($needles as $needle) {
                    if (str_contains($title, mb_strtolower($needle))) {
                        return true;
                    }
                }

                return false;
            });

        return $grade ? round($this->percentageScore($grade), 2) : '';
    }

    private function percentageScore(AssessmentGrade $grade): float
    {
        $maxScore = (float) ($grade->max_score ?: 100);

        return $maxScore > 0 ? ((float) $grade->score / $maxScore) * 100 : 0;
    }

    private function totalScore(int $studentId): float
    {
        return round(collect($this->scores[$studentId] ?? [])
            ->map(fn (mixed $score): float => is_numeric($score) ? (float) $score : 0)
            ->sum(), 2);
    }

    private function letterGrade(float $score): string
    {
        return match (true) {
            $score >= 90 => 'A',
            $score >= 80 => 'B',
            $score >= 70 => 'C',
            $score >= 60 => 'D',
            $score >= 50 => 'E',
            default => 'F',
        };
    }

    private function scoreStatusLabel(float $score): string
    {
        return $score >= 50 ? 'ជាប់' : 'ធ្លាក់';
    }

    private function enrollmentStatusLabel(?string $status): string
    {
        return match ($status) {
            'studying' => 'កំពុងសិក្សា',
            'completed' => 'បានបញ្ចប់',
            'cancelled' => 'បានបោះបង់',
            default => $status ?: '-',
        };
    }

    private function attendancePercent(Collection $attendances): string
    {
        if ($attendances->isEmpty()) {
            return '-';
        }

        $present = $attendances
            ->filter(fn (Attendance $attendance): bool => in_array($attendance->status, ['present', 'late'], true))
            ->count();

        return number_format(($present / max($attendances->count(), 1)) * 100, 0).'%';
    }
}
