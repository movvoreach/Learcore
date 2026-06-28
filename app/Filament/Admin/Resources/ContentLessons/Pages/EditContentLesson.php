<?php

namespace App\Filament\Admin\Resources\ContentLessons\Pages;

use App\Filament\Admin\Resources\ContentLessons\ContentLessonResource;
use Filament\Resources\Pages\EditRecord;

class EditContentLesson extends EditRecord
{
    protected static string $resource = ContentLessonResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}