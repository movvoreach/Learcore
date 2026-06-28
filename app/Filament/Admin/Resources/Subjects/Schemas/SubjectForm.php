<?php

namespace App\Filament\Admin\Resources\Subjects\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->label('វគ្គសិក្សា')
                    ->relationship('course', 'course_name')
                    ->searchable()
                    ->preload(false)
                    ->required(),
                TextInput::make('subject_code')
                    ->label('លេខកូដមុខវិជ្ជា')
                    ->required()
                    ->maxLength(30)
                    ->unique(ignoreRecord: true),
                TextInput::make('subject_name')
                    ->label('ឈ្មោះមុខវិជ្ជា')
                    ->required()
                    ->maxLength(150),
                TextInput::make('credit')
                    ->label('ក្រេឌីត')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                Textarea::make('description')
                    ->label('ការពិពណ៌នា')
                    ->columnSpanFull(),
            ]);
    }
}
