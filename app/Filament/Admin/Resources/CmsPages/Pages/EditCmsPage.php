<?php

namespace App\Filament\Admin\Resources\CmsPages\Pages;

use App\Filament\Admin\Resources\CmsPages\CmsPageResource;
use Filament\Resources\Pages\EditRecord;

class EditCmsPage extends EditRecord
{
    protected static string $resource = CmsPageResource::class;
}
