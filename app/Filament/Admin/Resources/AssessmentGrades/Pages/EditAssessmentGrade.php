<?php

namespace App\Filament\Admin\Resources\AssessmentGrades\Pages;

use App\Filament\Admin\Resources\AssessmentGrades\AssessmentGradeResource;
use Filament\Resources\Pages\EditRecord;

class EditAssessmentGrade extends EditRecord
{
    protected static string $resource = AssessmentGradeResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}