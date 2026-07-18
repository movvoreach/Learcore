<?php

namespace App\Filament\Admin\Resources\CourseModules\Pages;

use App\Filament\Admin\Resources\CourseModules\CourseModuleResource;
use Filament\Resources\Pages\EditRecord;

class EditCourseModule extends EditRecord
{
    protected static string $resource = CourseModuleResource::class;
}
