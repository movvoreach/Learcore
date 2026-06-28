<?php

namespace App\Filament\Admin\Resources\ContentChapters;

use App\Filament\Admin\Resources\ContentChapters\Pages\CreateContentChapter;
use App\Filament\Admin\Resources\ContentChapters\Pages\EditContentChapter;
use App\Filament\Admin\Resources\ContentChapters\Pages\ListContentChapters;
use App\Filament\Admin\Resources\ContentChapters\Schemas\ContentChapterForm;
use App\Filament\Admin\Resources\ContentChapters\Tables\ContentChaptersTable;
use App\Models\ContentChapter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class ContentChapterResource extends Resource
{
    protected static ?string $model = ContentChapter::class;

    protected static string|BackedEnum|null $navigationIcon = null;

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return new HtmlString('<img src="'.e(asset('Icons/content-chapters.png')).'" alt="" class="fi-sidebar-item-icon" />');
    }

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    protected static ?string $modelLabel = 'ជំពូក';

    protected static ?string $pluralModelLabel = 'ជំពូក';

    public static function form(Schema $schema): Schema
    {
        return ContentChapterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentChaptersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContentChapters::route('/'),
            'create' => CreateContentChapter::route('/create'),
            'edit' => EditContentChapter::route('/{record}/edit'),
        ];
    }
}
