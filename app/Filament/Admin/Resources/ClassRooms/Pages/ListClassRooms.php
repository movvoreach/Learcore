<?php

namespace App\Filament\Admin\Resources\ClassRooms\Pages;

use App\Filament\Admin\Resources\ClassRooms\ClassRoomResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClassRooms extends ListRecords
{
    protected static string $resource = ClassRoomResource::class;

    protected string $view = 'filament.admin.resources.class-rooms.pages.list-class-rooms';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-m-plus')
                ->hiddenLabel()
                ->tooltip('បញ្ចូលថ្នាក់រៀន'),
        ];
    }
}
