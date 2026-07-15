<?php

namespace App\Filament\Admin\Resources\NavigationGroups\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NavigationGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set): mixed => $set('slug', Str::slug((string) $state))),
            TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
            TextInput::make('sort_order')->label('Order')->numeric()->default(0)->required(),
            Toggle::make('is_active')->label('Active')->default(true),
        ]);
    }
}
