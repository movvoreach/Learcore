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
                Select::make('teacher_id')
                    ->label('គ្រូបង្រៀន (Teacher)')
                    ->relationship('teacher', 'first_name')
                    ->searchable(['teacher_code', 'first_name', 'last_name'])
                    ->preload(false)
                    ->required(),
                Select::make('class_id')
                    ->label('ថ្នាក់រៀន (Class)')
                    ->relationship('classRoom', 'class_name')
                    ->searchable()
                    ->preload(false)
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
                Select::make('students')
                    ->label('សិស្ស / និស្សិត (Students)')
                    ->relationship('students', 'first_name')
                    ->multiple()
                    ->searchable(['student_code', 'first_name', 'last_name'])
                    ->preload(false),
            ]);
    }
}
