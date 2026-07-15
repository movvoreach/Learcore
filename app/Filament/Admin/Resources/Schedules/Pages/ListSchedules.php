<?php

namespace App\Filament\Admin\Resources\Schedules\Pages;

use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use App\Models\ClassRoom;
use App\Models\Schedule;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class ListSchedules extends Page
{
    protected static string $resource = ScheduleResource::class;

    protected string $view = 'filament.admin.resources.schedules.pages.timetable';

    public $teacher_id = null;
    public $academic_year_id = null;
    public $semester_id = null;
    public $department_id = null;

    public ?int $scheduleDepartmentId = null;
    public ?int $scheduleAcademicYearId = null;
    public ?int $scheduleSemesterId = null;
    public ?int $scheduleTeacherId = null;
    public ?int $scheduleClassId = null;
    public ?string $scheduleDay = null;
    public ?string $scheduleStartTime = null;
    public ?string $scheduleEndTime = null;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function createSchedule(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['super_admin', 'admin']), 403);

        $data = $this->validate([
            'scheduleDepartmentId' => ['nullable', 'integer', 'exists:departments,department_id'],
            'scheduleAcademicYearId' => ['nullable', 'integer', 'exists:academic_years,academic_year_id'],
            'scheduleSemesterId' => ['nullable', 'integer', 'exists:semesters,semester_id'],
            'scheduleTeacherId' => ['required', 'integer', 'exists:teachers,teacher_id'],
            'scheduleClassId' => ['required', 'integer', 'exists:class_rooms,class_room_id'],
            'scheduleDay' => ['required', Rule::in(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])],
            'scheduleStartTime' => ['required', 'date_format:H:i'],
            'scheduleEndTime' => ['required', 'date_format:H:i', 'after:scheduleStartTime'],
        ], [], [
            'scheduleTeacherId' => 'Teacher',
            'scheduleClassId' => 'Class',
            'scheduleDay' => 'Day',
            'scheduleStartTime' => 'Start Time',
            'scheduleEndTime' => 'End Time',
        ]);

        $classRoom = ClassRoom::query()
            ->with('course')
            ->find($data['scheduleClassId']);

        if (! $classRoom) {
            $this->addError('scheduleClassId', 'Class not found.');

            return;
        }

        $classAcademicYearId = $classRoom->academic_year_id ?? $classRoom->course?->academic_year_id;

        if ($this->scheduleAcademicYearId && (int) $classAcademicYearId !== (int) $this->scheduleAcademicYearId) {
            $this->addError('scheduleClassId', 'Class does not match selected academic year.');

            return;
        }

        if ($this->scheduleDepartmentId && (int) $classRoom->course?->department_id !== (int) $this->scheduleDepartmentId) {
            $this->addError('scheduleClassId', 'Class does not match selected department.');

            return;
        }

        if ($this->scheduleSemesterId && (int) $classRoom->course?->semester_id !== (int) $this->scheduleSemesterId) {
            $this->addError('scheduleClassId', 'Class does not match selected semester.');

            return;
        }

        Schedule::query()->create([
            'teacher_id' => $data['scheduleTeacherId'],
            'class_id' => $data['scheduleClassId'],
            'day' => $data['scheduleDay'],
            'start_time' => $data['scheduleStartTime'],
            'end_time' => $data['scheduleEndTime'],
        ]);

        $this->resetCreateScheduleForm();
        $this->dispatch('close-create-schedule-modal');

        Notification::make()
            ->title('Schedule created successfully')
            ->success()
            ->send();
    }

    public function resetCreateScheduleForm(): void
    {
        $this->scheduleDepartmentId = null;
        $this->scheduleAcademicYearId = null;
        $this->scheduleSemesterId = null;
        $this->scheduleTeacherId = null;
        $this->scheduleClassId = null;
        $this->scheduleDay = null;
        $this->scheduleStartTime = null;
        $this->scheduleEndTime = null;
        $this->resetValidation();
    }

    protected function getViewData(): array
    {
        $query = Schedule::with(['teacher', 'classRoom', 'classRoom.course', 'classRoom.academicYear']);
        $user = auth()->user();
        $isTeacher = $user->hasRole('teacher');
        $isStudent = $user->hasRole('student');
        $student = $user->student;

        if ($isStudent) {
            if (! $student) {
                $query->whereRaw('1 = 0');
            } else {
                $classRoomIds = $student->enrollments()
                    ->whereNotNull('class_room_id')
                    ->pluck('class_room_id');

                $query->whereIn('class_id', $classRoomIds);
            }
        } elseif ($isTeacher && $user->teacher) {
            $this->teacher_id = $user->teacher->teacher_id;
            $query->where('teacher_id', $this->teacher_id);
        } elseif ($this->teacher_id) {
            $query->where('teacher_id', $this->teacher_id);
        }

        if ($this->academic_year_id) {
            $query->whereHas('classRoom', function (Builder $query): void {
                $query->where('academic_year_id', $this->academic_year_id);
            });
        }

        if ($this->semester_id) {
            $query->whereHas('classRoom.course', function (Builder $query): void {
                $query->where('semester_id', $this->semester_id);
            });
        }

        if ($this->department_id) {
            $query->whereHas('classRoom.course', function (Builder $query): void {
                $query->where('department_id', $this->department_id);
            });
        }

        $schedules = $query->get();
        $timeSlots = [];

        foreach ($schedules as $schedule) {
            $start = \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
            $end = \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
            $timeKey = "{$start} - {$end}";

            if (! isset($timeSlots[$timeKey])) {
                $timeSlots[$timeKey] = [
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'days' => [],
                ];
            }

            $timeSlots[$timeKey]['days'][$schedule->day][] = $schedule;
        }

        uasort($timeSlots, fn (array $a, array $b): int => strtotime($a['start_time']) <=> strtotime($b['start_time']));

        return [
            'timeSlots' => $timeSlots,
            'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
            'teachers' => \App\Models\Teacher::query()->orderBy('first_name')->get(),
            'academicYears' => \App\Models\AcademicYear::query()->orderBy('year_name')->get(),
            'semesters' => \App\Models\Semester::query()->orderBy('start_date')->get(),
            'departments' => \App\Models\Department::query()->orderBy('department_name')->get(),
            'classRooms' => ClassRoom::query()->with('course')->orderBy('class_name')->get(),
            'isTeacher' => $isTeacher,
            'isStudent' => $isStudent,
        ];
    }
}
