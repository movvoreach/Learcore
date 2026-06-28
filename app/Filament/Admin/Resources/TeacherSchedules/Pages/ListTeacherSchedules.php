<?php

namespace App\Filament\Admin\Resources\TeacherSchedules\Pages;

use App\Filament\Admin\Resources\TeacherSchedules\TeacherScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTeacherSchedules extends ListRecords
{
    protected static string $resource = TeacherScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
