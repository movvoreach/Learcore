<?php

namespace App\Filament\Admin\Resources\NavigationGroups;

use App\Filament\Admin\Resources\NavigationGroups\Pages\CreateNavigationGroup;
use App\Filament\Admin\Resources\NavigationGroups\Pages\EditNavigationGroup;
use App\Filament\Admin\Resources\NavigationGroups\Pages\ListNavigationGroups;
use App\Filament\Admin\Resources\NavigationGroups\Schemas\NavigationGroupForm;
use App\Filament\Admin\Resources\NavigationGroups\Tables\NavigationGroupsTable;
use App\Models\NavigationGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NavigationGroupResource extends Resource
{
    protected static ?string $model = NavigationGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Navigation Group';

    protected static ?string $pluralModelLabel = 'Navigation Groups';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return NavigationGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NavigationGroupsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNavigationGroups::route('/'),
            'create' => CreateNavigationGroup::route('/create'),
            'edit' => EditNavigationGroup::route('/{record}/edit'),
        ];
    }
}
