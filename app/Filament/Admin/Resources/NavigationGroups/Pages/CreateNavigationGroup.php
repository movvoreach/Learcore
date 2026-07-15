<?php

namespace App\Filament\Admin\Resources\NavigationGroups\Pages;

use App\Filament\Admin\Resources\NavigationGroups\NavigationGroupResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNavigationGroup extends CreateRecord
{
    protected static string $resource = NavigationGroupResource::class;
}
