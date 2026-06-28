<?php

namespace App\Filament\Admin\Resources\TeacherSchedules\Pages;

use App\Filament\Admin\Resources\TeacherSchedules\TeacherScheduleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeacherSchedule extends CreateRecord
{
    protected static string $resource = TeacherScheduleResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}