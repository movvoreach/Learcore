<?php

namespace App\Filament\Admin\Resources\Faculties\Pages;

use App\Filament\Admin\Resources\Faculties\FacultyResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFaculty extends EditRecord
{
    protected static string $resource = FacultyResource::class;

    protected static ?string $title = 'កែសម្រួលមហាវិទ្យាល័យ';

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
                ->successNotificationTitle('មហាវិទ្យាល័យត្រូវបានលុបដោយជោគជ័យ!'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'មហាវិទ្យាល័យត្រូវបានកែសម្រួលដោយជោគជ័យ!';
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
}
