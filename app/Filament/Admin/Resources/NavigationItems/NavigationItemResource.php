<?php

namespace App\Filament\Admin\Resources\NavigationItems;

use App\Filament\Admin\Resources\NavigationItems\Pages\CreateNavigationItem;
use App\Filament\Admin\Resources\NavigationItems\Pages\EditNavigationItem;
use App\Filament\Admin\Resources\NavigationItems\Pages\ListNavigationItems;
use App\Filament\Admin\Resources\NavigationItems\Schemas\NavigationItemForm;
use App\Filament\Admin\Resources\NavigationItems\Tables\NavigationItemsTable;
use App\Models\NavigationItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NavigationItemResource extends Resource
{
    protected static ?string $model = NavigationItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBars3;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Navigation Item';

    protected static ?string $pluralModelLabel = 'Navigation Items';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return NavigationItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NavigationItemsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNavigationItems::route('/'),
            'create' => CreateNavigationItem::route('/create'),
            'edit' => EditNavigationItem::route('/{record}/edit'),
        ];
    }
}
