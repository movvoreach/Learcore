<?php

namespace App\Filament\Admin\Resources\FrontendSettings;

use App\Filament\Admin\Resources\FrontendSettings\Pages\CreateFrontendSetting;
use App\Filament\Admin\Resources\FrontendSettings\Pages\EditFrontendSetting;
use App\Filament\Admin\Resources\FrontendSettings\Pages\ListFrontendSettings;
use App\Filament\Admin\Resources\FrontendSettings\Schemas\FrontendSettingForm;
use App\Filament\Admin\Resources\FrontendSettings\Tables\FrontendSettingsTable;
use App\Models\Setting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FrontendSettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Frontend Setting';

    protected static ?string $pluralModelLabel = 'Frontend Settings';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return FrontendSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FrontendSettingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFrontendSettings::route('/'),
            'create' => CreateFrontendSetting::route('/create'),
            'edit' => EditFrontendSetting::route('/{record}/edit'),
        ];
    }
}
