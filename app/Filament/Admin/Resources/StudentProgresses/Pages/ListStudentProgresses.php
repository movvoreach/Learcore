<?php

namespace App\Filament\Admin\Resources\StudentProgresses\Pages;

use App\Filament\Admin\Resources\StudentProgresses\StudentProgressResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudentProgresses extends ListRecords
{
    protected static string $resource = StudentProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
