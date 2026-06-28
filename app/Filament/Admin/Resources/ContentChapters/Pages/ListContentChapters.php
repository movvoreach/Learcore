<?php

namespace App\Filament\Admin\Resources\ContentChapters\Pages;

use App\Filament\Admin\Resources\ContentChapters\ContentChapterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContentChapters extends ListRecords
{
    protected static string $resource = ContentChapterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
