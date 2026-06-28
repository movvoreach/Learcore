<?php

namespace App\Filament\Admin\Resources\Semesters\Pages;

use App\Filament\Admin\Resources\Semesters\SemesterResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSemester extends EditRecord
{
    protected static string $resource = SemesterResource::class;

    protected static ?string $title = 'កែសម្រួលឆមាស';

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
                ->successNotificationTitle('ឆមាសត្រូវបានលុបដោយជោគជ័យ!'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'ឆមាសត្រូវបានកែសម្រួលដោយជោគជ័យ!';
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label('រក្សាទុកការផ្លាស់ប្តូរ');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('បោះបង់');
    }
}
