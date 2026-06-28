<?php

namespace App\Filament\Admin\Resources\Enrollments\Pages;

use App\Filament\Admin\Resources\Enrollments\EnrollmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEnrollment extends CreateRecord
{
    protected static string $resource = EnrollmentResource::class;

    public function mount(): void
    {
        $this->redirect(static::getResource()::getUrl('index', [
            'openEnrollmentModal' => 1,
        ]));
    }
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}