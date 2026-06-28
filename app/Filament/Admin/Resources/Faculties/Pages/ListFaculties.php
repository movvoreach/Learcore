<?php

namespace App\Filament\Admin\Resources\Faculties\Pages;

use App\Filament\Admin\Resources\Faculties\FacultyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFaculties extends ListRecords
{
    protected static string $resource = FacultyResource::class;

    protected static ?string $title = 'បញ្ជីមហាវិទ្យាល័យ';

    protected static ?string $breadcrumb = 'បញ្ជី';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('បញ្ចូលមហាវិទ្យាល័យ'),
        ];
    }

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }
}
