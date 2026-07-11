<?php

namespace App\Filament\Admin\Resources\CourseCategories\Pages;

use App\Filament\Admin\Resources\CourseCategories\CourseCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCourseCategories extends ListRecords
{
    protected static string $resource = CourseCategoryResource::class;

    protected string $view = 'filament.admin.resources.course-categories.pages.list-course-categories';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-m-plus')
                ->hiddenLabel()
                ->tooltip('បញ្ចូលប្រភេទវគ្គសិក្សា'),
        ];
    }
}
