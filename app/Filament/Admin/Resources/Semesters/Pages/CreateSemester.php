<?php

namespace App\Filament\Admin\Resources\Semesters\Pages;

use App\Filament\Admin\Resources\Semesters\SemesterResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateSemester extends CreateRecord
{
    protected static string $resource = SemesterResource::class;

    protected static ?string $title = 'បញ្ចូលឆមាស';

    protected static ?string $breadcrumb = 'បញ្ចូល';

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'ឆមាសត្រូវបានបង្កើតដោយជោគជ័យ!';
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('បញ្ចូល');
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('បញ្ចូលឡើងវិញ');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}
