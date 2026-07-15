<?php

namespace App\Filament\Admin\Resources\CmsPages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CmsPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->label('Title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set): mixed => $set('slug', Str::slug((string) $state))),
            TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
            FileUpload::make('thumbnail')
                ->label('Thumbnail')
                ->disk('public')
                ->directory('frontend/pages')
                ->image()
                ->imageEditor()
                ->downloadable()
                ->openable(),
            Select::make('status')
                ->label('Status')
                ->options(['draft' => 'Draft', 'published' => 'Published'])
                ->default('draft')
                ->required(),
            DateTimePicker::make('published_at')->label('Published At'),
            RichEditor::make('content')->label('Content')->columnSpanFull(),
            TextInput::make('seo_title')->label('SEO Title')->maxLength(255),
            Textarea::make('seo_description')->label('SEO Description')->columnSpanFull(),
        ]);
    }
}
