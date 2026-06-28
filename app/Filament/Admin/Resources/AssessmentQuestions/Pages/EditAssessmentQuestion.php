<?php

namespace App\Filament\Admin\Resources\AssessmentQuestions\Pages;

use App\Filament\Admin\Resources\AssessmentQuestions\AssessmentQuestionResource;
use Filament\Resources\Pages\EditRecord;

class EditAssessmentQuestion extends EditRecord
{
    protected static string $resource = AssessmentQuestionResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}