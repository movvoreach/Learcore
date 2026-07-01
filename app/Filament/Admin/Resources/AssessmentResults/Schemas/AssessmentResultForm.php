<?php

namespace App\Filament\Admin\Resources\AssessmentResults\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AssessmentResultForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('student_id')->label('និស្សិត')->relationship('student', 'student_code')->searchable()->preload()->required(),
            Select::make('assessment_type')
                ->label('ប្រភេទ')
                ->options([
                    'exam' => 'ការប្រឡង',
                    'quiz' => 'តេស្តខ្លី',
                    'assignment' => 'កិច្ចការ',
                ])
                ->default('exam')
                ->required(),
            Select::make('exam_id')->label('ការប្រឡង')->relationship('exam', 'title')->searchable()->preload(),
            Select::make('quiz_id')->label('តេស្តខ្លី')->relationship('quiz', 'title')->searchable()->preload(),
            TextInput::make('total_score')->label('ពិន្ទុសរុប')->numeric()->default(0)->required(),
            TextInput::make('rank')->label('ចំណាត់ថ្នាក់')->numeric(),
            Toggle::make('passed')->label('ជាប់')->default(false),
            DateTimePicker::make('published_at')->label('ថ្ងៃផ្សាយ'),
            Textarea::make('remarks')->label('កំណត់ចំណាំ')->rows(4)->columnSpanFull(),
        ]);
    }
}
