<?php

namespace App\Filament\Admin\Resources\FrontendSettings\Pages;

use App\Filament\Admin\Resources\FrontendSettings\FrontendSettingResource;
use App\Services\SettingService;
use Filament\Resources\Pages\EditRecord;

class EditFrontendSetting extends EditRecord
{
    protected static string $resource = FrontendSettingResource::class;

    protected function afterSave(): void
    {
        SettingService::forgetCache();
    }
}
