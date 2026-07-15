<?php

namespace App\Filament\Admin\Resources\NavigationGroups\Pages;

use App\Filament\Admin\Resources\NavigationGroups\NavigationGroupResource;
use Filament\Resources\Pages\EditRecord;

class EditNavigationGroup extends EditRecord
{
    protected static string $resource = NavigationGroupResource::class;
}
