<?php

namespace App\Filament\Admin\Resources\Exams\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class ExamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('ចំណងជើង')->required()->maxLength(180),
            Select::make('course_id')->label('វគ្គសិក្សា')->relationship('course', 'course_name')->searchable()->preload(false),
            Select::make('subject_id')->label('មុខវិជ្ជា')->relationship('subject', 'subject_name')->searchable()->preload(false),
            DatePicker::make('exam_date')->label('កាលបរិច្ឆេទ'),
            TimePicker::make('start_time')->label('ម៉ោងចាប់ផ្តើម')->seconds(false),
            TimePicker::make('end_time')->label('ម៉ោងបញ្ចប់')->seconds(false),
            TextInput::make('duration_minutes')->label('រយៈពេល (នាទី)')->numeric(),
            TextInput::make('total_score')->label('ពិន្ទុសរុប')->numeric()->default(100)->required(),
            TextInput::make('passing_score')->label('ពិន្ទុជាប់')->numeric()->default(50)->required(),
            Select::make('status')
                ->label('ស្ថានភាព')
                ->options([
                    'draft' => 'ព្រាង',
                    'scheduled' => 'បានកំណត់ពេល',
                    'open' => 'កំពុងបើក',
                    'closed' => 'បានបិទ',
                    'published' => 'បានផ្សាយលទ្ធផល',
                ])
                ->default('draft')
                ->required(),
            Textarea::make('description')->label('ពិពណ៌នា')->rows(4)->columnSpanFull(),
        ]);
    }
}
