<?php

namespace App\Filament\Admin\Resources\Schedules\Pages;

use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use App\Models\Enrollment;
use App\Models\Schedule;
use App\Models\Student;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

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
                $this->getRecord()->students()->where('students.student_id', $studentId)->exists()
                    || $user->student->enrollments()->where('class_room_id', $classRoomId)->exists(),
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

        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin']), 403);

        $this->getRecord()->students()->detach($studentId);

        Notification::make()
            ->title('បានដកនិស្សិតចេញពីកាលវិភាគ')
            ->success()
            ->send();
    }

    public function addStudentByCode(): void
    {
        $user = auth()->user();

        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin']), 403);

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

        $this->getRecord()->students()->syncWithoutDetaching([$student->student_id]);

        $this->studentId = null;

        $this->dispatch('close-add-student-modal');

        Notification::make()
            ->title('បានបញ្ចូលនិស្សិតដោយជោគជ័យ')
            ->success()
            ->send();
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
            'students.department',
            'students.academicYear',
            'students.semester',
        ]);

        $directStudents = $schedule->students()
            ->with(['department', 'academicYear', 'semester'])
            ->orderBy('student_code')
            ->get();

        $enrollments = Enrollment::query()
            ->where('class_room_id', $schedule->class_id)
            ->with(['student.department', 'student.academicYear', 'student.semester'])
            ->orderBy('enrollment_date')
            ->get();

        $students = $directStudents
            ->merge($enrollments->pluck('student')->filter())
            ->unique('student_id')
            ->values();

        if (auth()->user()?->hasRole('student') && ! auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher'])) {
            $students = $students
                ->filter(fn ($student): bool => (int) $student->student_id === (int) auth()->user()->student->student_id)
                ->values();
        }

        $studentIdsAttachedToSchedule = $directStudents->pluck('student_id')->map(fn ($id): int => (int) $id);

        return [
            'schedule' => $schedule,
            'students' => $students,
            'enrollmentsByStudent' => $enrollments->keyBy('student_id'),
            'studentIdsAttachedToSchedule' => $studentIdsAttachedToSchedule,
            'studentOptions' => Student::query()
                ->orderBy('student_code')
                ->get(['student_id', 'student_code', 'first_name', 'last_name']),
            'canManageScheduleStudents' => auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false,
            'totalStudents' => $students->count(),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher', 'student']) ?? false;
    }
}
