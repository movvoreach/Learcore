<?php

namespace App\Filament\Admin\Resources\Courses\Pages;

use App\Filament\Admin\Resources\Courses\CourseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    protected string $view = 'filament.admin.resources.courses.pages.list-courses';

    protected function getHeaderActions(): array
    {
        if (auth()->user()?->isStudent()) {
            return [];
        }

        return [
            CreateAction::make()
                ->icon('heroicon-m-plus')
                ->hiddenLabel()
                ->tooltip('បញ្ចូលវគ្គសិក្សា'),
        ];
    }
}
