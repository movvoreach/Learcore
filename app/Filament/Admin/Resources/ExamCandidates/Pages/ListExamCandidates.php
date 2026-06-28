<?php

namespace App\Filament\Admin\Resources\ExamCandidates\Pages;

use App\Filament\Admin\Resources\ExamCandidates\ExamCandidateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExamCandidates extends ListRecords
{
    protected static string $resource = ExamCandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
