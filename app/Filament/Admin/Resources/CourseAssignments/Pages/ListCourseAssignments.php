<?php

namespace App\Filament\Admin\Resources\CourseAssignments\Pages;

use App\Filament\Admin\Resources\CourseAssignments\CourseAssignmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCourseAssignments extends ListRecords
{
    protected static string $resource = CourseAssignmentResource::class;

    protected string $view = 'filament.admin.resources.course-assignments.pages.list-course-assignments';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-m-plus')
                ->hiddenLabel()
                ->tooltip('បញ្ចូលការចាត់តាំងវគ្គសិក្សា'),
        ];
    }
}
