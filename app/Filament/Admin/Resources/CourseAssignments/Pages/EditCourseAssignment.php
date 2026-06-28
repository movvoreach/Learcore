<?php

namespace App\Filament\Admin\Resources\CourseAssignments\Pages;

use App\Filament\Admin\Resources\CourseAssignments\CourseAssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCourseAssignment extends EditRecord
{
    protected static string $resource = CourseAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
