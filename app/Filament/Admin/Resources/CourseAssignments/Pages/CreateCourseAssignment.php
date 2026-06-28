<?php

namespace App\Filament\Admin\Resources\CourseAssignments\Pages;

use App\Filament\Admin\Resources\CourseAssignments\CourseAssignmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourseAssignment extends CreateRecord
{
    protected static string $resource = CourseAssignmentResource::class;
}
