<?php

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Resources\Roles\RoleResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected static ?string $title = 'កែសម្រួលតួនាទី';

    protected static ?string $breadcrumb = 'កែសម្រួល';

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('លុប')
                ->successNotificationTitle('តួនាទីត្រូវបានលុបដោយជោគជ័យ!'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'តួនាទីត្រូវបានកែសម្រួលដោយជោគជ័យ!';
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label('រក្សាទុកការផ្លាស់ប្តូរ');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }

    protected function afterSave(): void
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
