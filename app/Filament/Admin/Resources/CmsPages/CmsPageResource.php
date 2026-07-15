<?php

namespace App\Filament\Admin\Resources\CmsPages;

use App\Filament\Admin\Resources\CmsPages\Pages\CreateCmsPage;
use App\Filament\Admin\Resources\CmsPages\Pages\EditCmsPage;
use App\Filament\Admin\Resources\CmsPages\Pages\ListCmsPages;
use App\Filament\Admin\Resources\CmsPages\Schemas\CmsPageForm;
use App\Filament\Admin\Resources\CmsPages\Tables\CmsPagesTable;
use App\Models\FrontendPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CmsPageResource extends Resource
{
    protected static ?string $model = FrontendPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'CMS Page';

    protected static ?string $pluralModelLabel = 'CMS Pages';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return CmsPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CmsPagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCmsPages::route('/'),
            'create' => CreateCmsPage::route('/create'),
            'edit' => EditCmsPage::route('/{record}/edit'),
        ];
    }
}
