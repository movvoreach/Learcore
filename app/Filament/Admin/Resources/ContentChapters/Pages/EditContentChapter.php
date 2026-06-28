<?php

namespace App\Filament\Admin\Resources\ContentChapters\Pages;

use App\Filament\Admin\Resources\ContentChapters\ContentChapterResource;
use Filament\Resources\Pages\EditRecord;

class EditContentChapter extends EditRecord
{
    protected static string $resource = ContentChapterResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}