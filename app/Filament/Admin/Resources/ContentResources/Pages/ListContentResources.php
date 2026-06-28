<?php

namespace App\Filament\Admin\Resources\ContentResources\Pages;

use App\Filament\Admin\Resources\ContentResources\ContentResourceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContentResources extends ListRecords
{
    protected static string $resource = ContentResourceResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
