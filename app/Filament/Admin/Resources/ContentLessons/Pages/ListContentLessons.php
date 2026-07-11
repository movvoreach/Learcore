<?php

namespace App\Filament\Admin\Resources\ContentLessons\Pages;

use App\Filament\Admin\Resources\ContentLessons\ContentLessonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContentLessons extends ListRecords
{
    protected static string $resource = ContentLessonResource::class;

    protected string $view = 'filament.admin.resources.content-lessons.pages.list-content-lessons';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-m-plus')
                ->hiddenLabel()
                ->tooltip('បញ្ចូលមេរៀន'),
        ];
    }
}
