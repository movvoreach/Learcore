<?php

namespace App\Filament\Admin\Resources\AssessmentResults\Pages;

use App\Filament\Admin\Resources\AssessmentResults\AssessmentResultResource;
use Filament\Resources\Pages\EditRecord;

class EditAssessmentResult extends EditRecord
{
    protected static string $resource = AssessmentResultResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}