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

    protected string $view = 'filament.admin.resources.permissions.pages.list-permissions';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-m-plus')
                ->hiddenLabel()
                ->tooltip('បញ្ចូលសិទ្ធិ'),
        ];
    }
}
