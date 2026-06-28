<?php

namespace App\Filament\Admin\Resources\AssessmentGrades\Pages;

use App\Filament\Admin\Resources\AssessmentGrades\AssessmentGradeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAssessmentGrade extends CreateRecord
{
    protected static string $resource = AssessmentGradeResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}