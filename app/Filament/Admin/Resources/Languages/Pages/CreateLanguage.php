<?php

namespace App\Filament\Admin\Resources\Languages\Pages;

use App\Filament\Admin\Resources\Languages\LanguageResource;
use App\Services\Localization\LocalizationService;
use Filament\Resources\Pages\CreateRecord;

class CreateLanguage extends CreateRecord
{
    protected static string $resource = LanguageResource::class;

    protected function afterCreate(): void
    {
        app(LocalizationService::class)->clearCache();
    }
}
