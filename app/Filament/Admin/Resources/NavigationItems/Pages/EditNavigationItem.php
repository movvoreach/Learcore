<?php

namespace App\Filament\Admin\Resources\NavigationItems\Pages;

use App\Filament\Admin\Resources\NavigationItems\NavigationItemResource;
use Filament\Resources\Pages\EditRecord;

class EditNavigationItem extends EditRecord
{
    protected static string $resource = NavigationItemResource::class;
}
