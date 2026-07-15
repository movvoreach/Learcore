<?php

namespace App\Filament\Admin\Resources\AssignmentSubmissions\Pages;

use App\Filament\Admin\Resources\AssignmentSubmissions\AssignmentSubmissionResource;
use Filament\Resources\Pages\EditRecord;

class EditAssignmentSubmission extends EditRecord
{
    protected static string $resource = AssignmentSubmissionResource::class;

    protected function afterSave(): void
    {
        if (filled($this->record->score)) {
            $this->record->update(['status' => 'graded']);
            $this->record->refresh()->loadMissing('assignment');
            $this->record->publishGradeToStudent(auth()->id());
        }
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}
