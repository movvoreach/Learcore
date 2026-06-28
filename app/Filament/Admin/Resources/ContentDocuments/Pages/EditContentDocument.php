<?php

namespace App\Filament\Admin\Resources\ContentDocuments\Pages;

use App\Filament\Admin\Resources\ContentDocuments\ContentDocumentResource;
use Filament\Resources\Pages\EditRecord;

class EditContentDocument extends EditRecord
{
    protected static string $resource = ContentDocumentResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}