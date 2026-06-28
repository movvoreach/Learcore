<?php

namespace App\Filament\Admin\Resources\ContentVideos;

use App\Filament\Admin\Resources\ContentVideos\Pages\CreateContentVideo;
use App\Filament\Admin\Resources\ContentVideos\Pages\EditContentVideo;
use App\Filament\Admin\Resources\ContentVideos\Pages\ListContentVideos;
use App\Filament\Admin\Resources\ContentVideos\Schemas\ContentVideoForm;
use App\Filament\Admin\Resources\ContentVideos\Tables\ContentVideosTable;
use App\Models\ContentVideo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContentVideoResource extends Resource
{
    protected static ?string $model = ContentVideo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    protected static ?string $modelLabel = 'វីដេអូ';

    protected static ?string $pluralModelLabel = 'វីដេអូ';

    public static function form(Schema $schema): Schema
    {
        return ContentVideoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentVideosTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContentVideos::route('/'),
            'create' => CreateContentVideo::route('/create'),
            'edit' => EditContentVideo::route('/{record}/edit'),
        ];
    }
}
