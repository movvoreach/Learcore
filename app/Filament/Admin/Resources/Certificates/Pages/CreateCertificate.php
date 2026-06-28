<?php

namespace App\Filament\Admin\Resources\Certificates\Pages;

use App\Filament\Admin\Resources\Certificates\CertificateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCertificate extends CreateRecord
{
    protected static string $resource = CertificateResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}