<?php

namespace App\Filament\Admin\Resources\StudentProgresses\Pages;

use App\Filament\Admin\Resources\StudentProgresses\StudentProgressResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentProgress extends CreateRecord
{
    protected static string $resource = StudentProgressResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}