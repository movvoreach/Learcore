<?php

namespace App\Filament\Admin\Resources\Quizzes\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuizForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('content_lesson_id')->label('មេរៀន')->relationship('lesson', 'title')->searchable()->preload()->default(fn (): ?int => request()->integer('content_lesson_id') ?: null),
            TextInput::make('title')->label('ចំណងជើង')->required()->maxLength(180),
            Textarea::make('instructions')->label('សេចក្តីណែនាំ')->rows(5)->columnSpanFull(),
            DateTimePicker::make('available_from')->label('ចាប់ផ្តើម'),
            DateTimePicker::make('available_until')->label('បញ្ចប់'),
            TextInput::make('time_limit_minutes')->label('រយៈពេល (នាទី)')->numeric()->minValue(1),
            TextInput::make('max_attempts')->label('ចំនួនដង')->numeric()->default(1)->required(),
            TextInput::make('passing_score')->label('ពិន្ទុជាប់')->numeric()->default(50)->required(),
            Toggle::make('is_published')->label('ផ្សាយ')->default(false),
        ]);
    }
}
