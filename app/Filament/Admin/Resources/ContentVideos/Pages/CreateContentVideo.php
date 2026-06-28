<?php

namespace App\Filament\Admin\Resources\ContentVideos\Pages;

use App\Filament\Admin\Resources\ContentVideos\ContentVideoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContentVideo extends CreateRecord
{
    protected static string $resource = ContentVideoResource::class;
}
