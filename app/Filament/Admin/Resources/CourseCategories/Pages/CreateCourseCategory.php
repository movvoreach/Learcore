<?php

namespace App\Filament\Admin\Resources\CourseCategories\Pages;

use App\Filament\Admin\Resources\CourseCategories\CourseCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourseCategory extends CreateRecord
{
    protected static string $resource = CourseCategoryResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}