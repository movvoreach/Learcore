<?php

namespace App\Filament\Admin\Resources\Schedules\Pages;

use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use App\Models\Schedule;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

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
        return auth()->user()?->hasAnyRole(['super_admin', 'admin'])
            ? [
                Action::make('createSchedule')
                    ->label(new HtmlString('<i class="fa-solid fas fa-plus"></i> <span>បញ្ចូល</span>'))
                    ->color('primary')
                    ->modalHeading('បញ្ចូលកាលវិភាគ')
                    ->modalWidth(Width::SevenExtraLarge)
                    ->modalSubmitActionLabel('រក្សាទុក')
                    ->modalCancelActionLabel('ត្រឡប់')
                    ->form($this->scheduleModalForm())
                    ->action(function (array $data): void {
                        Schedule::query()->create([
                            'teacher_id' => $data['teacher_id'],
                            'class_id' => $data['class_id'],
                            'day' => $data['day'],
                            'start_time' => $data['start_time'],
                            'end_time' => $data['end_time'],
                        ]);

                        Notification::make()
                            ->title('បានបញ្ចូលកាលវិភាគដោយជោគជ័យ')
                            ->success()
                            ->send();
                    }),
            ]
            : [];
    }

    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    private function scheduleModalForm(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    Select::make('department_id')
                        ->label('ដេប៉ាតឺម៉ង់ (Department)')
                        ->options(\App\Models\Department::pluck('department_name', 'department_id'))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->dehydrated(false),
                    Select::make('academic_year_id')
                        ->label('ឆ្នាំសិក្សា (Academic Year)')
                        ->options(\App\Models\AcademicYear::pluck('year_name', 'academic_year_id'))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->dehydrated(false),
                    Select::make('semester_id')
                        ->label('ឆមាស (Semester)')
                        ->options(\App\Models\Semester::pluck('semester_name', 'semester_id'))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->dehydrated(false),
                    Select::make('teacher_id')
                        ->label('គ្រូបង្រៀន (Teacher)')
                        ->relationship('teacher', 'first_name', function (Builder $query, $get) {
                            if ($get('department_id')) {
                                $query->where('department_id', $get('department_id'));
                            }
                        })
                        ->searchable(['teacher_code', 'first_name', 'last_name'])
                        ->preload()
                        ->required(),
                    Select::make('class_id')
                        ->label('ថ្នាក់រៀន (Class)')
                        ->relationship('classRoom', 'class_name', function (Builder $query, $get) {
                            if ($get('academic_year_id')) {
                                $query->where('academic_year_id', $get('academic_year_id'));
                            }

                            if ($get('department_id') || $get('semester_id')) {
                                $query->whereHas('course', function (Builder $query) use ($get): void {
                                    if ($get('department_id')) {
                                        $query->where('department_id', $get('department_id'));
                                    }

                                    if ($get('semester_id')) {
                                        $query->where('semester_id', $get('semester_id'));
                                    }
                                });
                            }
                        })
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('day')
                        ->label('ថ្ងៃ (Day)')
                        ->options([
                            'monday' => 'ចន្ទ (Monday)',
                            'tuesday' => 'អង្គារ (Tuesday)',
                            'wednesday' => 'ពុធ (Wednesday)',
                            'thursday' => 'ព្រហស្បតិ៍ (Thursday)',
                            'friday' => 'សុក្រ (Friday)',
                            'saturday' => 'សៅរ៍ (Saturday)',
                            'sunday' => 'អាទិត្យ (Sunday)',
                        ])
                        ->required(),
                    TimePicker::make('start_time')
                        ->label('ម៉ោងចាប់ផ្តើម (Start Time)')
                        ->seconds(false)
                        ->required(),
                    TimePicker::make('end_time')
                        ->label('ម៉ោងបញ្ចប់ (End Time)')
                        ->seconds(false)
                        ->required(),
                ]),
        ];
    }

    protected function getViewData(): array
    {
        $query = \App\Models\Schedule::with(['teacher', 'classRoom', 'classRoom.course', 'classRoom.academicYear']);
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

                $query->where(function (Builder $query) use ($student, $classRoomIds): void {
                    $query
                        ->whereHas('students', fn (Builder $query): Builder => $query
                            ->where('students.student_id', $student->student_id))
                        ->when($classRoomIds->isNotEmpty(), fn (Builder $query): Builder => $query
                            ->orWhereIn('class_id', $classRoomIds));
                });
            }
        } elseif ($isTeacher && $user->teacher) {
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
            'isStudent' => $isStudent,
        ];
    }
}
