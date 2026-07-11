<?php

namespace App\Filament\Admin\Resources\ContentChapters\Pages;

use App\Filament\Admin\Resources\ContentChapters\ContentChapterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContentChapters extends ListRecords
{
    protected static string $resource = ContentChapterResource::class;

    protected string $view = 'filament.admin.resources.content-chapters.pages.list-content-chapters';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-m-plus')
                ->hiddenLabel()
                ->tooltip('បញ្ចូលជំពូកមេរៀន'),
        ];
    }
}
