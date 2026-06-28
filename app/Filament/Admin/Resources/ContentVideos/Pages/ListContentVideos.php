<?php

namespace App\Filament\Admin\Resources\ContentVideos\Pages;

use App\Filament\Admin\Resources\ContentVideos\ContentVideoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContentVideos extends ListRecords
{
    protected static string $resource = ContentVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
