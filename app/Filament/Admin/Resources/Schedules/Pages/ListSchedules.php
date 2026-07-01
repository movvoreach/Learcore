<?php

namespace App\Filament\Admin\Resources\Schedules\Pages;

use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\Page;

class ListSchedules extends Page
{
    protected static string $resource = ScheduleResource::class;

    protected string $view = 'filament.admin.resources.schedules.pages.timetable';

    public $teacher_id = null;
    public $academic_year_id = null;
    public $semester_id = null;
    public $department_id = null;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getViewData(): array
    {
        $query = \App\Models\Schedule::with(['teacher', 'classRoom', 'classRoom.course', 'classRoom.academicYear']);
        $user = auth()->user();
        $isTeacher = $user->hasRole('teacher');

        if ($isTeacher && $user->teacher) {
            $this->teacher_id = $user->teacher->teacher_id;
            $query->where('teacher_id', $this->teacher_id);
        } elseif ($this->teacher_id) {
            $query->where('teacher_id', $this->teacher_id);
        }

        if ($this->academic_year_id) {
            $query->whereHas('classRoom', function($q) {
                $q->where('academic_year_id', $this->academic_year_id);
            });
        }

        if ($this->semester_id) {
            $query->whereHas('classRoom.course', function($q) {
                $q->where('semester_id', $this->semester_id);
            });
        }

        if ($this->department_id) {
            $query->whereHas('classRoom.course', function($q) {
                $q->where('department_id', $this->department_id);
            });
        }

        $schedules = $query->get();

        $timeSlots = [];
        foreach ($schedules as $schedule) {
            $start = \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
            $end = \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
            $timeKey = "{$start} - {$end}";
            
            if (!isset($timeSlots[$timeKey])) {
                $timeSlots[$timeKey] = [
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'days' => []
                ];
            }
            
            $timeSlots[$timeKey]['days'][$schedule->day][] = $schedule;
        }

        uasort($timeSlots, function ($a, $b) {
            return strtotime($a['start_time']) <=> strtotime($b['start_time']);
        });

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $teachers = \App\Models\Teacher::all();
        $academicYears = \App\Models\AcademicYear::all(); 
        $semesters = \App\Models\Semester::all();
        $departments = \App\Models\Department::all();

        return [
            'timeSlots' => $timeSlots,
            'days' => $days,
            'teachers' => $teachers,
            'academicYears' => $academicYears,
            'semesters' => $semesters,
            'departments' => $departments,
            'isTeacher' => $isTeacher,
        ];
    }
}
