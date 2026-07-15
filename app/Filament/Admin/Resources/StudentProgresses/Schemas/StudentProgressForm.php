<?php

namespace App\Filament\Admin\Resources\StudentProgresses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StudentProgressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->label('និស្សិត')
                    ->relationship('student', 'first_name')
                    ->searchable(['student_code', 'first_name', 'last_name'])
                    ->preload()
                    ->required(),
                Select::make('course_id')
                    ->label('វគ្គសិក្សា')
                    ->relationship('course', 'course_name')
                    ->searchable()
                    ->preload(),
                Select::make('class_room_id')
                    ->label('ថ្នាក់រៀន')
                    ->relationship('classRoom', 'class_name')
                    ->searchable()
                    ->preload(),
                DatePicker::make('progress_date')
                    ->label('កាលបរិច្ឆេទ'),
                TextInput::make('progress_percent')
                    ->label('ភាគរយវឌ្ឍនភាព')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(0)
                    ->suffix('%')
                    ->required(),
                TextInput::make('score')
                    ->label('ពិន្ទុ')
                    ->numeric()
                    ->minValue(0),
                TextInput::make('attendance_score')
                    ->label('Attendance 10%')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10)
                    ->default(0),
                TextInput::make('attribute_score')
                    ->label('Attribute 10%')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10)
                    ->default(0),
                TextInput::make('midterm_score')
                    ->label('Midterm 20%')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(20)
                    ->default(0),
                TextInput::make('assignment_score')
                    ->label('Homework/Assignment 20%')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(20)
                    ->default(0),
                TextInput::make('final_score')
                    ->label('Final 40%')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(40)
                    ->default(0),
                Select::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'in_progress' => 'កំពុងដំណើរការ',
                        'completed' => 'បានបញ្ចប់',
                        'needs_support' => 'ត្រូវការជំនួយ',
                    ])
                    ->default('in_progress')
                    ->required(),
                Textarea::make('note')
                    ->label('កំណត់សម្គាល់')
                    ->columnSpanFull(),
            ]);
    }
}
