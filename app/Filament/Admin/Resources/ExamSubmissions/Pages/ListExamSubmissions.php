<?php

namespace App\Filament\Admin\Resources\ExamSubmissions\Pages;

use App\Filament\Admin\Resources\ExamSubmissions\ExamSubmissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExamSubmissions extends ListRecords
{
    protected static string $resource = ExamSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
