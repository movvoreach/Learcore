<?php

namespace App\Filament\Admin\Resources\TeacherSchedules\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class TeacherScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('teacher_id')
                    ->label('គ្រូបង្រៀន')
                    ->relationship('teacher', 'first_name')
                    ->searchable(['teacher_code', 'first_name', 'last_name'])
                    ->preload(false)
                    ->required(),
                Select::make('course_id')
                    ->label('វគ្គសិក្សា')
                    ->relationship('course', 'course_name')
                    ->searchable()
                    ->preload(false),
                Select::make('class_room_id')
                    ->label('ថ្នាក់រៀន')
                    ->relationship('classRoom', 'class_name')
                    ->searchable()
                    ->preload(false),
                Select::make('day_of_week')
                    ->label('ថ្ងៃ')
                    ->options([
                        'monday' => 'ចន្ទ',
                        'tuesday' => 'អង្គារ',
                        'wednesday' => 'ពុធ',
                        'thursday' => 'ព្រហស្បតិ៍',
                        'friday' => 'សុក្រ',
                        'saturday' => 'សៅរ៍',
                        'sunday' => 'អាទិត្យ',
                    ])
                    ->required(),
                TimePicker::make('start_time')
                    ->label('ម៉ោងចាប់ផ្តើម')
                    ->seconds(false)
                    ->required(),
                TimePicker::make('end_time')
                    ->label('ម៉ោងបញ្ចប់')
                    ->seconds(false)
                    ->required(),
                TextInput::make('room')
                    ->label('បន្ទប់')
                    ->maxLength(100),
                Select::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'active' => 'កំពុងប្រើ',
                        'inactive' => 'ផ្អាក',
                    ])
                    ->default('active')
                    ->required(),
                Textarea::make('note')
                    ->label('កំណត់សម្គាល់')
                    ->columnSpanFull(),
            ]);
    }
}
