<?php

namespace App\Filament\Admin\Resources\ContentResources\Pages;

use App\Filament\Admin\Resources\ContentResources\ContentResourceResource;
use Filament\Resources\Pages\EditRecord;

class EditContentResource extends EditRecord
{
    protected static string $resource = ContentResourceResource::class;
}
