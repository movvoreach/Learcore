<?php

namespace App\Filament\Admin\Resources\Schedules\Schemas;

use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\Department;
use App\Models\Semester;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('department_id')
                    ->label('Department')
                    ->placeholder('Select Department')
                    ->options(fn () => Department::pluck('department_name', 'department_id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->dehydrated(false)
                    ->afterStateHydrated(function (Select $component, $record): void {
                        if ($record) {
                            $component->state($record->course?->department_id ?? $record->classRoom?->course?->department_id ?? $record->teacher?->department_id);
                        }
                    }),
                Select::make('academic_year_id')
                    ->label('Academic Year')
                    ->placeholder('Select Academic Year')
                    ->options(fn () => AcademicYear::pluck('year_name', 'academic_year_id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->dehydrated(false)
                    ->afterStateHydrated(function (Select $component, $record): void {
                        if ($record) {
                            $component->state($record->classRoom?->academic_year_id);
                        }
                    }),
                Select::make('semester_id')
                    ->label('Semester')
                    ->placeholder('Select Semester')
                    ->options(fn () => Semester::pluck('semester_name', 'semester_id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->dehydrated(false)
                    ->afterStateHydrated(function (Select $component, $record): void {
                        if ($record) {
                            $component->state($record->course?->semester_id ?? $record->classRoom?->course?->semester_id);
                        }
                    }),
                Select::make('course_id')
                    ->label('Course')
                    ->placeholder('Select Course')
                    ->options(function ($get) {
                        $query = Course::query();

                        if ($get('department_id')) {
                            $query->where('department_id', $get('department_id'));
                        }

                        if ($get('academic_year_id')) {
                            $query->where('academic_year_id', $get('academic_year_id'));
                        }

                        if ($get('semester_id')) {
                            $query->where('semester_id', $get('semester_id'));
                        }

                        return $query
                            ->orderBy('course_name')
                            ->get()
                            ->mapWithKeys(fn (Course $course): array => [
                                $course->course_id => trim(($course->course_code ?? '').' - '.$course->course_name, ' -'),
                            ]);
                    })
                    ->searchable()
                    ->preload()
                    ->live(),
                Select::make('teacher_id')
                    ->label('Teacher')
                    ->placeholder('Select Teacher')
                    ->relationship('teacher', 'first_name', function (Builder $query, $get): void {
                        if ($get('department_id')) {
                            $query->where('department_id', $get('department_id'));
                        }
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record): string => trim("{$record->teacher_code} - {$record->first_name} {$record->last_name}", ' -'))
                    ->searchable(['teacher_code', 'first_name', 'last_name'])
                    ->preload()
                    ->required(),
                Select::make('class_id')
                    ->label('Class')
                    ->placeholder('Select Class')
                    ->options(function ($get) {
                        $query = ClassRoom::query()
                            ->where('status', 'active');

                        if ($get('academic_year_id')) {
                            $query->where(function (Builder $classQuery) use ($get): void {
                                $classQuery
                                    ->whereNull('academic_year_id')
                                    ->orWhere('academic_year_id', $get('academic_year_id'));
                            });
                        }

                        if ($get('department_id') || $get('semester_id') || $get('course_id')) {
                            $query->where(function (Builder $classQuery) use ($get): void {
                                $classQuery
                                    ->whereNull('course_id')
                                    ->orWhereHas('course', function (Builder $courseQuery) use ($get): void {
                                        if ($get('course_id')) {
                                            $courseQuery->where('course_id', $get('course_id'));
                                        }

                                        if ($get('department_id')) {
                                            $courseQuery->where('department_id', $get('department_id'));
                                        }

                                        if ($get('semester_id')) {
                                            $courseQuery->where('semester_id', $get('semester_id'));
                                        }
                                    });
                            });
                        }

                        return $query
                            ->orderBy('class_name')
                            ->pluck('class_name', 'class_room_id');
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('day')
                    ->label('Day')
                    ->placeholder('Select Day')
                    ->options([
                        'monday' => 'Monday',
                        'tuesday' => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday' => 'Thursday',
                        'friday' => 'Friday',
                        'saturday' => 'Saturday',
                        'sunday' => 'Sunday',
                    ])
                    ->required(),
                TimePicker::make('start_time')
                    ->label('Start Time')
                    ->seconds(false)
                    ->required(),
                TimePicker::make('end_time')
                    ->label('End Time')
                    ->seconds(false)
                    ->required(),
            ]);
    }
}
