<?php

namespace App\Filament\Admin\Resources\ContentResources\Pages;

use App\Filament\Admin\Resources\ContentResources\ContentResourceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContentResource extends CreateRecord
{
    protected static string $resource = ContentResourceResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}