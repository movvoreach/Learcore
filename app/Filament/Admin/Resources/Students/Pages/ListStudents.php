<?php

namespace App\Filament\Admin\Resources\Students\Pages;

use App\Filament\Admin\Resources\Students\StudentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected static ?string $title = 'បញ្ជីនិស្សិត';

    protected static ?string $breadcrumb = 'បញ្ជី';

    protected string $view = 'filament.admin.resources.students.pages.list-students';

    public ?int $department_id = null;
    public ?int $academic_year_id = null;
    public ?int $semester_id = null;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-m-plus')
                ->hiddenLabel()
                ->tooltip('បញ្ចូលនិស្សិត'),
        ];
    }

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }
}
