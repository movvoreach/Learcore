<?php

namespace App\Filament\Admin\Resources\AssessmentQuestions\Pages;

use App\Filament\Admin\Resources\AssessmentQuestions\AssessmentQuestionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAssessmentQuestion extends CreateRecord
{
    protected static string $resource = AssessmentQuestionResource::class;
}
