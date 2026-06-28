<?php

namespace App\Filament\Admin\Resources\ContentDocuments\Pages;

use App\Filament\Admin\Resources\ContentDocuments\ContentDocumentResource;
use Filament\Resources\Pages\EditRecord;

class EditContentDocument extends EditRecord
{
    protected static string $resource = ContentDocumentResource::class;
}
