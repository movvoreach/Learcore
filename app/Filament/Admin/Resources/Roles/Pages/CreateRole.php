<?php

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Resources\Roles\RoleResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected static ?string $title = 'បញ្ចូលតួនាទី';

    protected static ?string $breadcrumb = 'បញ្ចូល';

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'តួនាទីត្រូវបានបង្កើតដោយជោគជ័យ!';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('បញ្ចូលតួនាទី');
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

    protected function afterCreate(): void
    {
        $this->syncPermissions();
    }

    private function syncPermissions(): void
    {
        $data = $this->form->getRawState();

        $permissionIds = array_merge(
            $data['users_permissions'] ?? [],
            $data['roles_permissions'] ?? [],
            $data['academic_permissions'] ?? [],
            $data['students_permissions'] ?? [],
            $data['courses_permissions'] ?? [],
            $data['lessons_permissions'] ?? [],
            $data['assessments_permissions'] ?? [],
            $data['promotions_permissions'] ?? [],
            $data['teacher_permissions'] ?? [],
            $data['student_permissions'] ?? [],
            $data['settings_permissions'] ?? [],
            $data['other_permissions'] ?? []
        );

        $this->record->syncPermissions($permissionIds);
    }
}
