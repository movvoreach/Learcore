<?php

namespace App\Filament\Admin\Resources\ContentLessons\Pages;

use App\Filament\Admin\Resources\ContentLessons\ContentLessonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContentLesson extends CreateRecord
{
    protected static string $resource = ContentLessonResource::class;

    protected string $view = 'filament.admin.resources.content-lessons.pages.create-content-lesson';

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}
