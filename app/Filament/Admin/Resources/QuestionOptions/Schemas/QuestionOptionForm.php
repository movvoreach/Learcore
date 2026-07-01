<?php

namespace App\Filament\Admin\Resources\QuestionOptions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('assessment_question_id')->label('សំណួរ')->relationship('question', 'question_text')->searchable()->preload()->required(),
            TextInput::make('option_text')->label('ជម្រើសចម្លើយ')->required()->maxLength(500)->columnSpanFull(),
            TextInput::make('sort_order')->label('លំដាប់')->numeric()->default(0)->required(),
            Toggle::make('is_correct')->label('ចម្លើយត្រឹមត្រូវ')->default(false),
        ]);
    }
}
