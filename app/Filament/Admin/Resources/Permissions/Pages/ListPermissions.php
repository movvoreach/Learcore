<?php

namespace App\Filament\Admin\Resources\Permissions\Pages;

use App\Filament\Admin\Resources\Permissions\PermissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    protected static ?string $title = 'បញ្ជីសិទ្ធិ';

    protected static ?string $breadcrumb = 'បញ្ជី';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('បញ្ចូលសិទ្ធិ'),
        ];
    }
}
