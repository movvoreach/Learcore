<?php

namespace App\Filament\Admin\Resources\TeacherSchedules\Pages;

use App\Filament\Admin\Resources\TeacherSchedules\TeacherScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeacherSchedule extends EditRecord
{
    protected static string $resource = TeacherScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
