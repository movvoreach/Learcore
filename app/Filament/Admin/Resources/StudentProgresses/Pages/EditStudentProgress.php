<?php

namespace App\Filament\Admin\Resources\StudentProgresses\Pages;

use App\Filament\Admin\Resources\StudentProgresses\StudentProgressResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStudentProgress extends EditRecord
{
    protected static string $resource = StudentProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
