<?php

namespace App\Filament\Admin\Resources\NavigationItems\Schemas;

use App\Models\FrontendPage;
use App\Models\NavigationGroup;
use App\Models\NavigationItem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NavigationItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('navigation_group_id')
                ->label('Menu Group')
                ->options(fn (): array => NavigationGroup::query()->orderBy('sort_order')->pluck('name', 'id')->all())
                ->searchable()
                ->required()
                ->live(),
            Select::make('parent_id')
                ->label('Parent Menu')
                ->options(fn ($record, $get): array => NavigationItem::query()
                    ->when($get('navigation_group_id'), fn ($query, $groupId) => $query->where('navigation_group_id', $groupId))
                    ->when($record?->id, fn ($query, $id) => $query->whereKeyNot($id))
                    ->orderBy('sort_order')
                    ->pluck('title', 'id')
                    ->all())
                ->searchable()
                ->nullable(),
            TextInput::make('title')
                ->label('Title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set): mixed => $set('slug', Str::slug((string) $state))),
            TextInput::make('slug')->label('Slug')->maxLength(160),
            Select::make('page_id')
                ->label('Internal CMS Page')
                ->options(fn (): array => FrontendPage::query()->orderBy('title')->pluck('title', 'id')->all())
                ->searchable()
                ->nullable()
                ->helperText('If a page is selected, its URL is generated automatically.'),
            TextInput::make('url')->label('External or internal URL')->maxLength(1000),
            TextInput::make('icon')->label('Icon class')->placeholder('fas fa-info-circle')->maxLength(120),
            Select::make('target')
                ->label('Open')
                ->options(['_self' => 'Same tab', '_blank' => 'New tab'])
                ->default('_self')
                ->required(),
            TextInput::make('sort_order')->label('Order')->numeric()->default(0)->required(),
            Toggle::make('is_active')->label('Active')->default(true),
        ]);
    }
}
