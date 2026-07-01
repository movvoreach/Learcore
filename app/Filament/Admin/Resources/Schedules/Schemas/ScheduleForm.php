<?php

namespace App\Filament\Admin\Resources\Schedules\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->relationship('teacher', 'first_name', function (\Illuminate\Database\Eloquent\Builder $query, $get) {
                        if ($get('department_id')) {
                            $query->where('department_id', $get('department_id'));
                        }
                    })
                    ->searchable(['teacher_code', 'first_name', 'last_name'])
                    ->preload()
                    ->required(),
                Select::make('class_id')
                    ->label('ថ្នាក់រៀន (Class)')
                    ->relationship('classRoom', 'class_name', function (\Illuminate\Database\Eloquent\Builder $query, $get) {
                        if ($get('academic_year_id')) {
                            $query->where('academic_year_id', $get('academic_year_id'));
                        }
                        if ($get('department_id') || $get('semester_id')) {
                            $query->whereHas('course', function ($q) use ($get) {
                                if ($get('department_id')) {
                                    $q->where('department_id', $get('department_id'));
                                }
                                if ($get('semester_id')) {
                                    $q->where('semester_id', $get('semester_id'));
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
            ]);
    }
}
