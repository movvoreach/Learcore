<?php

namespace App\Filament\Admin\Resources\Students\Pages;

use App\Filament\Admin\Resources\Students\StudentResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected static ?string $title = 'កែសម្រួលនិស្សិត';

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
                ->successNotificationTitle('និស្សិតត្រូវបានលុបដោយជោគជ័យ!'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'និស្សិតត្រូវបានកែសម្រួលដោយជោគជ័យ!';
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
