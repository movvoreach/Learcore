<?php

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Resources\Roles\RoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected static ?string $title = 'បញ្ជីតួនាទី';

    protected static ?string $breadcrumb = 'បញ្ជី';

    protected string $view = 'filament.admin.resources.roles.pages.list-roles';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-m-plus')
                ->hiddenLabel()
                ->tooltip('បញ្ចូលតួនាទី'),
        ];
    }
}
