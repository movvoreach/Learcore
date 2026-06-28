<?php

namespace App\Filament\Admin\Resources\ExamCandidates\Pages;

use App\Filament\Admin\Resources\ExamCandidates\ExamCandidateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExamCandidate extends CreateRecord
{
    protected static string $resource = ExamCandidateResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}