<?php

namespace App\Filament\Admin\Resources\NavigationGroups\Pages;

use App\Filament\Admin\Resources\NavigationGroups\NavigationGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNavigationGroups extends ListRecords
{
    protected static string $resource = NavigationGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
