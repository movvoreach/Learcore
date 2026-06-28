<?php

namespace App\Filament\Admin\Resources\ExamCandidates\Pages;

use App\Filament\Admin\Resources\ExamCandidates\ExamCandidateResource;
use Filament\Resources\Pages\EditRecord;

class EditExamCandidate extends EditRecord
{
    protected static string $resource = ExamCandidateResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}