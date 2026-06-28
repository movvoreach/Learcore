<?php

namespace App\Filament\Admin\Resources\ContentDocuments\Pages;

use App\Filament\Admin\Resources\ContentDocuments\ContentDocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContentDocument extends CreateRecord
{
    protected static string $resource = ContentDocumentResource::class;
}
