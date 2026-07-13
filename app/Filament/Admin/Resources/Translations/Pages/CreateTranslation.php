<?php

namespace App\Filament\Admin\Resources\Translations\Pages;

use App\Filament\Admin\Resources\Translations\TranslationResource;
use App\Services\Localization\LocalizationService;
use Filament\Resources\Pages\CreateRecord;

class CreateTranslation extends CreateRecord
{
    protected static string $resource = TranslationResource::class;

    protected function afterCreate(): void
    {
        app(LocalizationService::class)->clearCache();
    }
}
