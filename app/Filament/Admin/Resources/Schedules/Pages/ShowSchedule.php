<?php

namespace App\Filament\Admin\Resources\Schedules\Pages;

use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Schedule;
use App\Models\Student;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Carbon;

class ShowSchedule extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ScheduleResource::class;

    protected static ?string $title = 'ប្រវត្តិនិស្សិតក្នុងកាលវិភាគ';

    protected static ?string $breadcrumb = 'បញ្ជីនិស្សិត';

    protected string $view = 'filament.admin.resources.schedules.pages.show';

    public ?int $studentId = null;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $user = auth()->user();

        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin', 'teacher', 'student']), 403);

        if ($user->hasRole('teacher') && ! $user->hasAnyRole(['super_admin', 'admin'])) {
            abort_unless($user->teacher && (int) $this->getRecord()->teacher_id === (int) $user->teacher->teacher_id, 403);
        }

        if ($user->hasRole('student') && ! $user->hasAnyRole(['super_admin', 'admin', 'teacher'])) {
            abort_unless($user->student, 403);

            $studentId = $user->student->student_id;
            $classRoomId = $this->getRecord()->class_id;

            abort_unless(
                $user->student->enrollments()->where('class_room_id', $classRoomId)->exists(),
                403,
            );
        }
    }

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    public function getTitle(): string
    {
        return 'ប្រវត្តិនិស្សិតក្នុងកាលវិភាគ';
    }

    public function removeStudent(int $studentId): void
    {
        $user = auth()->user();

        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin', 'teacher']), 403);

        Enrollment::query()
            ->where('student_id', $studentId)
            ->where('class_room_id', $this->getRecord()->class_id)
            ->delete();

        Notification::make()
            ->title('បានដកនិស្សិតចេញពីកាលវិភាគ')
            ->success()
            ->send();
    }

    public function addStudentByCode(): void
    {
        $user = auth()->user();

        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin', 'teacher']), 403);

        $this->validate([
            'studentId' => ['required', 'integer', 'exists:students,student_id'],
        ], [
            'studentId.required' => 'សូមជ្រើសរើសនិស្សិត។',
        ]);

        $student = Student::query()
            ->where('student_id', $this->studentId)
            ->first();

        if (! $student) {
            $this->addError('studentId', 'រកមិនឃើញនិស្សិតដែលបានជ្រើសរើសទេ។');

            return;
        }

        /** @var Schedule $schedule */
        $schedule = $this->getRecord()->loadMissing(['classRoom.course']);
        $classRoom = $schedule->classRoom;
        $course = $classRoom?->course;

        if (! $classRoom || ! $course) {
            $this->addError('studentId', 'This schedule does not have a valid class/course.');

            return;
        }

        Enrollment::query()->updateOrCreate(
            [
                'student_id' => $student->student_id,
                'class_room_id' => $classRoom->class_room_id,
            ],
            [
                'course_id' => $classRoom->course_id,
                'academic_year_id' => $classRoom->academic_year_id ?? $course->academic_year_id,
                'semester_id' => $course->semester_id,
                'enrollment_date' => now()->toDateString(),
                'status' => 'studying',
                'note' => 'Registered from schedule.',
            ],
        );

        $this->studentId = null;

        $this->dispatch('close-add-student-modal');

        Notification::make()
            ->title('បានបញ្ចូលនិស្សិតដោយជោគជ័យ')
            ->success()
            ->send();
    }

    public function setMonthAttendance(int $studentId, string $date, bool $present): void
    {
        $user = auth()->user();

        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin', 'teacher']), 403);

        /** @var Schedule $schedule */
        $schedule = $this->getRecord();
        $attendanceDate = Carbon::parse($date)->toDateString();

        $isClassStudent = Enrollment::query()
            ->where('student_id', $studentId)
            ->where('class_room_id', $schedule->class_id)
            ->exists();

        abort_unless($isClassStudent, 403);

        Attendance::query()->updateOrCreate(
            [
                'student_id' => $studentId,
                'class_room_id' => $schedule->class_id,
                'attendance_date' => $attendanceDate,
            ],
            [
                'status' => $present ? 'present' : 'absent',
            ],
        );
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        /** @var Schedule $schedule */
        $schedule = $this->getRecord()->loadMissing([
            'teacher.department',
            'classRoom.course.department',
            'classRoom.course.semester',
            'classRoom.academicYear',
        ]);

        $enrollments = Enrollment::query()
            ->where('class_room_id', $schedule->class_id)
            ->with(['student.department', 'student.academicYear', 'student.semester'])
            ->orderBy('enrollment_date')
            ->get();

        $students = $enrollments
            ->pluck('student')
            ->filter()
            ->unique('student_id')
            ->values();

        if (auth()->user()?->hasRole('student') && ! auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher'])) {
            $students = $students
                ->filter(fn ($student): bool => (int) $student->student_id === (int) auth()->user()->student->student_id)
                ->values();
        }

        $studentIdsAttachedToSchedule = $students->pluck('student_id')->map(fn ($id): int => (int) $id);
        $monthDates = $this->monthDatesForScheduleDay($schedule->day);
        $monthAttendances = Attendance::query()
            ->where('class_room_id', $schedule->class_id)
            ->whereIn('student_id', $students->pluck('student_id'))
            ->whereBetween('attendance_date', [
                $monthDates->first()?->toDateString() ?? now()->startOfMonth()->toDateString(),
                $monthDates->last()?->toDateString() ?? now()->endOfMonth()->toDateString(),
            ])
            ->get()
            ->keyBy(fn (Attendance $attendance): string => $attendance->student_id.'|'.Carbon::parse($attendance->attendance_date)->toDateString());

        return [
            'schedule' => $schedule,
            'students' => $students,
            'enrollmentsByStudent' => $enrollments->keyBy('student_id'),
            'studentIdsAttachedToSchedule' => $studentIdsAttachedToSchedule,
            'monthDates' => $monthDates,
            'monthAttendances' => $monthAttendances,
            'studentOptions' => Student::query()
                ->whereDoesntHave('enrollments', fn ($query) => $query
                    ->where('class_room_id', $schedule->class_id))
                ->orderBy('student_code')
                ->get(['student_id', 'student_code', 'first_name', 'last_name']),
            'canManageScheduleStudents' => auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false,
            'totalStudents' => $students->count(),
        ];
    }

    private function monthDatesForScheduleDay(?string $day): \Illuminate\Support\Collection
    {
        $targetDay = strtolower((string) $day);
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        $dates = collect();

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if (strtolower($date->format('l')) === $targetDay) {
                $dates->push($date->copy());
            }
        }

        return $dates;
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher', 'student']) ?? false;
    }
}
