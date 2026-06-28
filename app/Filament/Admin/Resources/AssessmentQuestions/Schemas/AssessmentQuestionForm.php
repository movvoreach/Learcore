<?php

namespace App\Filament\Admin\Resources\AssessmentQuestions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AssessmentQuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('question_bank_id')->label('ធនាគារសំណួរ')->relationship('bank', 'title')->searchable()->preload(false),
            Select::make('content_lesson_id')->label('មេរៀន')->relationship('lesson', 'title')->searchable()->preload(false),
            Select::make('question_type')
                ->label('ប្រភេទសំណួរ')
                ->options([
                    'multiple_choice' => 'ជម្រើសច្រើន',
                    'true_false' => 'ត្រូវ / ខុស',
                    'short_answer' => 'ចម្លើយខ្លី',
                    'essay' => 'សំណេរ',
                ])
                ->default('multiple_choice')
                ->required(),
            TextInput::make('points')->label('ពិន្ទុ')->numeric()->default(1)->required(),
            Textarea::make('question_text')->label('សំណួរ')->rows(5)->required()->columnSpanFull(),
            Textarea::make('correct_answer')->label('ចម្លើយត្រឹមត្រូវ')->rows(3)->columnSpanFull(),
            Textarea::make('explanation')->label('ការពន្យល់')->rows(3)->columnSpanFull(),
            Toggle::make('is_active')->label('សកម្ម')->default(true),
        ]);
    }
}
