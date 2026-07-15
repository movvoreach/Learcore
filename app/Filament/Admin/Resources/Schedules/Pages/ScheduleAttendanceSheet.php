<?php

namespace App\Filament\Admin\Resources\Schedules\Pages;

use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Schedule;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Carbon;

class ScheduleAttendanceSheet extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ScheduleResource::class;

    protected static ?string $title = 'បញ្ជីវត្តមាន';

    protected static ?string $breadcrumb = 'បញ្ជីវត្តមាន';

    protected string $view = 'filament.admin.resources.schedules.pages.attendance-sheet';

    public int $daysCount = 31;

    public string $startDate = '';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $user = auth()->user();

        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin', 'teacher']), 403);

        if ($user->hasRole('teacher') && ! $user->hasAnyRole(['super_admin', 'admin'])) {
            abort_unless($user->teacher && (int) $this->getRecord()->teacher_id === (int) $user->teacher->teacher_id, 403);
        }

        $this->startDate = now()->startOfMonth()->toDateString();
    }

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    public function getTitle(): string
    {
        return 'បញ្ជីវត្តមាន';
    }

    public function toggleAttendance(int $studentId, string $date): void
    {
        $this->setAttendance($studentId, $date, ! $this->hasAttendance($studentId, $date));
    }

    public function setAttendance(int $studentId, string $date, bool $present): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']), 403);

        /** @var Schedule $schedule */
        $schedule = $this->getRecord();
        $attendanceDate = Carbon::parse($date)->toDateString();

        if ($present) {
            Attendance::query()->updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_room_id' => $schedule->class_id,
                    'attendance_date' => $attendanceDate,
                ],
                [
                    'status' => 'present',
                ],
            );
        } else {
            Attendance::query()
                ->where('student_id', $studentId)
                ->where('class_room_id', $schedule->class_id)
                ->whereDate('attendance_date', $attendanceDate)
                ->delete();
        }

        Notification::make()
            ->title('បានរក្សាទុកវត្តមាន')
            ->success()
            ->send();
    }

    private function hasAttendance(int $studentId, string $date): bool
    {
        /** @var Schedule $schedule */
        $schedule = $this->getRecord();

        return Attendance::query()
            ->where('student_id', $studentId)
            ->where('class_room_id', $schedule->class_id)
            ->whereDate('attendance_date', Carbon::parse($date)->toDateString())
            ->where('status', 'present')
            ->exists();
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        /** @var Schedule $schedule */
        $schedule = $this->getRecord()->loadMissing([
            'teacher',
            'classRoom.course.semester',
            'classRoom.academicYear',
        ]);

        $startDate = Carbon::parse($this->startDate ?: now()->startOfMonth()->toDateString());
        $daysCount = max(1, min(62, (int) $this->daysCount));

        $dates = collect(range(0, $daysCount - 1))
            ->map(fn (int $offset): Carbon => $startDate->copy()->addDays($offset));

        $enrollments = Enrollment::query()
            ->where('class_room_id', $schedule->class_id)
            ->with('student')
            ->orderBy('enrollment_date')
            ->get();

        $students = $enrollments
            ->pluck('student')
            ->filter()
            ->unique('student_id')
            ->values();

        $attendances = Attendance::query()
            ->where('class_room_id', $schedule->class_id)
            ->whereIn('student_id', $students->pluck('student_id'))
            ->where('status', 'present')
            ->whereBetween('attendance_date', [
                $dates->first()?->toDateString(),
                $dates->last()?->toDateString(),
            ])
            ->get()
            ->keyBy(fn (Attendance $attendance): string => $attendance->student_id.'|'.Carbon::parse($attendance->attendance_date)->toDateString());

        return [
            'schedule' => $schedule,
            'students' => $students,
            'dates' => $dates,
            'attendances' => $attendances,
            'monthLabel' => $startDate->format('F-Y'),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }
}
