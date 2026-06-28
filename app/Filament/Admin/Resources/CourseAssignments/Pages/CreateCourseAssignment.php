<?php

namespace App\Filament\Admin\Resources\CourseAssignments\Pages;

use App\Filament\Admin\Resources\CourseAssignments\CourseAssignmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourseAssignment extends CreateRecord
{
    protected static string $resource = CourseAssignmentResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}