<?php

namespace App\Filament\Admin\Resources\QuestionBanks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionBankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('ចំណងជើង')->required()->maxLength(180),
            Select::make('course_id')->label('វគ្គសិក្សា')->relationship('course', 'course_name')->searchable()->preload(false),
            Select::make('subject_id')->label('មុខវិជ្ជា')->relationship('subject', 'subject_name')->searchable()->preload(false),
            Textarea::make('description')->label('ពិពណ៌នា')->rows(4)->columnSpanFull(),
            Toggle::make('is_active')->label('សកម្ម')->default(true),
        ]);
    }
}
