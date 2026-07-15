<?php

namespace App\Filament\Admin\Resources\FrontendSettings\Pages;

use App\Filament\Admin\Resources\FrontendSettings\FrontendSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFrontendSettings extends ListRecords
{
    protected static string $resource = FrontendSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
