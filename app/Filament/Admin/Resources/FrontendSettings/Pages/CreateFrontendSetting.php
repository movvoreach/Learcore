<?php

namespace App\Filament\Admin\Resources\FrontendSettings\Pages;

use App\Filament\Admin\Resources\FrontendSettings\FrontendSettingResource;
use App\Services\SettingService;
use Filament\Resources\Pages\CreateRecord;

class CreateFrontendSetting extends CreateRecord
{
    protected static string $resource = FrontendSettingResource::class;

    protected function afterCreate(): void
    {
        SettingService::forgetCache();
    }
}
