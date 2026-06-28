<?php

namespace App\Filament\Admin\Resources\ExamSubmissions\Pages;

use App\Filament\Admin\Resources\ExamSubmissions\ExamSubmissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExamSubmission extends CreateRecord
{
    protected static string $resource = ExamSubmissionResource::class;
}
