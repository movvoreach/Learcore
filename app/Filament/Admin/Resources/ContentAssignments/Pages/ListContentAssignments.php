<?php

namespace App\Filament\Admin\Resources\ContentAssignments\Pages;

use App\Filament\Admin\Resources\ContentAssignments\ContentAssignmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContentAssignments extends ListRecords
{
    protected static string $resource = ContentAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
