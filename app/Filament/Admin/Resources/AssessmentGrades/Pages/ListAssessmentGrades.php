<?php

namespace App\Filament\Admin\Resources\AssessmentGrades\Pages;

use App\Filament\Admin\Resources\AssessmentGrades\AssessmentGradeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssessmentGrades extends ListRecords
{
    protected static string $resource = AssessmentGradeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
