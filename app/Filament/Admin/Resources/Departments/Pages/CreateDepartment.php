<?php

namespace App\Filament\Admin\Resources\Departments\Pages;

use App\Filament\Admin\Resources\Departments\DepartmentResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;

    protected static ?string $title = 'បញ្ចូលដេប៉ាតឺម៉ង់';

    protected static ?string $breadcrumb = 'បញ្ចូល';

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'ដេប៉ាតឺម៉ង់ត្រូវបានបង្កើតដោយជោគជ័យ!';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
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
            ->label('បោះបង់');
    }
}
