<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\IconPosition;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'បញ្ចូលអ្នកប្រើប្រាស់';

    protected static ?string $breadcrumb = 'បញ្ចូល';

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'អ្នកប្រើប្រាស់បញ្ចូលបានដោយជោគជ័យ!';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Create Button
     */
    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('បញ្ចូល')
            ->iconPosition(IconPosition::Before)
            ->color('primary');
    }

    /**
     * Save & Create Another Button
     */
    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('បញ្ចូលឡើងវិញ')
            ->iconPosition(IconPosition::Before)
            ->color('primary');
    }

    /**
     * Cancel Button
     */
    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់')
            ->iconPosition(IconPosition::Before)
            ->color('gray');
    }
}