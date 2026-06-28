<?php

namespace App\Filament\Admin\Resources\ContentResources;

use App\Filament\Admin\Resources\ContentResources\Pages\CreateContentResource;
use App\Filament\Admin\Resources\ContentResources\Pages\EditContentResource;
use App\Filament\Admin\Resources\ContentResources\Pages\ListContentResources;
use App\Filament\Admin\Resources\ContentResources\Schemas\ContentResourceForm;
use App\Filament\Admin\Resources\ContentResources\Tables\ContentResourcesTable;
use App\Models\ContentResource;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContentResourceResource extends Resource
{
    protected static ?string $model = ContentResource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolderOpen;

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    protected static ?string $modelLabel = 'ធនធាន';

    protected static ?string $pluralModelLabel = 'ធនធាន';

    public static function form(Schema $schema): Schema
    {
        return ContentResourceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentResourcesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContentResources::route('/'),
            'create' => CreateContentResource::route('/create'),
            'edit' => EditContentResource::route('/{record}/edit'),
        ];
    }
}
