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
                    ->placeholder('ជ្រើសរើសដេប៉ាតឺម៉ង់ (Department)')
                    ->options(fn () => \App\Models\Department::pluck('department_name', 'department_id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->dehydrated(false)
                    ->afterStateHydrated(function (Select $component, $record) {
                        if ($record) {
                            $component->state($record->classRoom?->course?->department_id ?? $record->teacher?->department_id);
                        }
                    }),
                Select::make('academic_year_id')
                    ->label('ឆ្នាំសិក្សា (Academic Year)')
                    ->placeholder('ជ្រើសរើសឆ្នាំសិក្សា (Academic Year)')
                    ->options(fn () => \App\Models\AcademicYear::pluck('year_name', 'academic_year_id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->dehydrated(false)
                    ->afterStateHydrated(function (Select $component, $record) {
                        if ($record) {
                            $component->state($record->classRoom?->academic_year_id);
                        }
                    }),
                Select::make('semester_id')
                    ->label('ឆមាស (Semester)')
                    ->placeholder('ជ្រើសរើសឆមាស (Semester)')
                    ->options(fn () => \App\Models\Semester::pluck('semester_name', 'semester_id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->dehydrated(false)
                    ->afterStateHydrated(function (Select $component, $record) {
                        if ($record) {
                            $component->state($record->classRoom?->course?->semester_id);
                        }
                    }),
                Select::make('teacher_id')
                    ->label('គ្រូបង្រៀន (Teacher)')
                    ->placeholder('ជ្រើសរើសគ្រូបង្រៀន (Teacher)')
                    ->relationship('teacher', 'first_name', function (\Illuminate\Database\Eloquent\Builder $query, $get) {
                        if ($get('department_id')) {
                            $query->where('department_id', $get('department_id'));
                        }
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => trim("{$record->first_name} {$record->last_name}"))
                    ->searchable(['teacher_code', 'first_name', 'last_name'])
                    ->preload()
                    ->required(),
                Select::make('class_id')
                    ->label('ថ្នាក់រៀន (Class)')
                    ->placeholder('ជ្រើសរើសថ្នាក់រៀន (Class)')
                    ->options(function ($get) {
                        $query = \App\Models\ClassRoom::query();
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
                        return $query->pluck('class_name', 'class_room_id');
                    })
                    ->searchable()
                    ->required(),
                Select::make('day')
                    ->label('ថ្ងៃ (Day)')
                    ->placeholder('ជ្រើសរើសថ្ងៃ (Day)')
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
