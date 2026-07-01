<?php

namespace App\Filament\Admin\Resources\ContentChapters\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContentChapterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('content_lesson_id')
                    ->label('មេរៀន')
                    ->relationship('lesson', 'title')
                    ->searchable()
                    ->preload()
                    ->default(fn (): ?int => request()->integer('content_lesson_id') ?: null)
                    ->required(),
                TextInput::make('title')
                    ->label('ចំណងជើងជំពូក')
                    ->required()
                    ->maxLength(180),
                Textarea::make('summary')
                    ->label('សង្ខេប')
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->label('មាតិកា')
                    ->rows(8)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->label('លំដាប់')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Toggle::make('is_published')
                    ->label('បង្ហាញសម្រាប់សិស្ស')
                    ->default(false),
            ]);
    }
}
