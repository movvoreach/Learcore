<?php

namespace App\Filament\Admin\Resources\ContentAssignments\Pages;

use App\Filament\Admin\Resources\ContentAssignments\ContentAssignmentResource;
use Filament\Resources\Pages\EditRecord;

class EditContentAssignment extends EditRecord
{
    protected static string $resource = ContentAssignmentResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}