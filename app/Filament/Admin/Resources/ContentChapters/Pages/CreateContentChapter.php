<?php

namespace App\Filament\Admin\Resources\ContentChapters\Pages;

use App\Filament\Admin\Resources\ContentChapters\ContentChapterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContentChapter extends CreateRecord
{
    protected static string $resource = ContentChapterResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}