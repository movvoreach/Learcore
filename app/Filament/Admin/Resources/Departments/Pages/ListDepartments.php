<?php

namespace App\Filament\Admin\Resources\Departments\Pages;

use App\Filament\Admin\Resources\Departments\DepartmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;

    protected static ?string $title = 'បញ្ជីដេប៉ាតឺម៉ង់';

    protected static ?string $breadcrumb = 'បញ្ជី';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('បញ្ចូលដេប៉ាតឺម៉ង់'),
        ];
    }

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }
}
