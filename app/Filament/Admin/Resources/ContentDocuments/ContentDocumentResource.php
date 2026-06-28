<?php

namespace App\Filament\Admin\Resources\ContentDocuments;

use App\Filament\Admin\Resources\ContentDocuments\Pages\CreateContentDocument;
use App\Filament\Admin\Resources\ContentDocuments\Pages\EditContentDocument;
use App\Filament\Admin\Resources\ContentDocuments\Pages\ListContentDocuments;
use App\Filament\Admin\Resources\ContentDocuments\Schemas\ContentDocumentForm;
use App\Filament\Admin\Resources\ContentDocuments\Tables\ContentDocumentsTable;
use App\Models\ContentDocument;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContentDocumentResource extends Resource
{
    protected static ?string $model = ContentDocument::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    protected static ?string $modelLabel = 'ឯកសារ';

    protected static ?string $pluralModelLabel = 'ឯកសារ';

    public static function form(Schema $schema): Schema
    {
        return ContentDocumentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentDocumentsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContentDocuments::route('/'),
            'create' => CreateContentDocument::route('/create'),
            'edit' => EditContentDocument::route('/{record}/edit'),
        ];
    }
}
