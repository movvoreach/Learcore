<?php

namespace App\Filament\Admin\Resources\CourseModules\Pages;

use App\Filament\Admin\Resources\CourseModules\CourseModuleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourseModule extends CreateRecord
{
    protected static string $resource = CourseModuleResource::class;
}
