<?php

namespace App\Filament\Admin\Resources\Departments\Pages;

use App\Filament\Admin\Resources\Departments\DepartmentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDepartment extends ViewRecord
{
    protected static string $resource = DepartmentResource::class;

    protected static ?string $title = 'មើលដេប៉ាតឺម៉ង់';

    protected static ?string $breadcrumb = 'មើល';

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('កែសម្រួល'),
        ];
    }
}
