<?php

namespace App\Filament\Admin\Resources\FrontendSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FrontendSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('group')
                ->label('Group')
                ->options([
                    'general' => 'General',
                    'branding' => 'Branding',
                    'navigation' => 'Navigation',
                    'about_menu' => 'About Menu',
                    'contact' => 'Contact',
                    'social_links' => 'Social Links',
                    'footer' => 'Footer',
                ])
                ->required(),
            TextInput::make('key')->label('Key')->required()->unique(ignoreRecord: true)->maxLength(120),
            Select::make('type')
                ->label('Type')
                ->options([
                    'text' => 'Text',
                    'textarea' => 'Long Text',
                    'image' => 'Image',
                    'color' => 'Color',
                    'url' => 'URL',
                ])
                ->default('text')
                ->live()
                ->required(),
            TextInput::make('value')
                ->label('Value')
                ->visible(fn ($get): bool => in_array($get('type'), ['text', 'color', 'url'], true))
                ->maxLength(1000),
            Textarea::make('value')
                ->label('Value')
                ->visible(fn ($get): bool => $get('type') === 'textarea')
                ->columnSpanFull(),
            FileUpload::make('value')
                ->label('Image')
                ->visible(fn ($get): bool => $get('type') === 'image')
                ->disk('public')
                ->directory('frontend/settings')
                ->image()
                ->imageEditor()
                ->downloadable()
                ->openable(),
        ]);
    }
}
