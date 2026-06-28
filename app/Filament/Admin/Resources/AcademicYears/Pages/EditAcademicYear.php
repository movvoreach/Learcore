<?php

namespace App\Filament\Admin\Resources\AcademicYears\Pages;

use App\Filament\Admin\Resources\AcademicYears\AcademicYearResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAcademicYear extends EditRecord
{
    protected static string $resource = AcademicYearResource::class;

    protected static ?string $title = 'កែសម្រួលឆ្នាំសិក្សា';

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
                ->successNotificationTitle('ឆ្នាំសិក្សាត្រូវបានលុបដោយជោគជ័យ!'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'ឆ្នាំសិក្សាត្រូវបានកែសម្រួលដោយជោគជ័យ!';
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
