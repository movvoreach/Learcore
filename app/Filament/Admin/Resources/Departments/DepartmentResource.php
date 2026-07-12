<?php

namespace App\Filament\Admin\Resources\Departments;

use App\Filament\Admin\Resources\Departments\Pages\CreateDepartment;
use App\Filament\Admin\Resources\Departments\Pages\EditDepartment;
use App\Filament\Admin\Resources\Departments\Pages\ListDepartments;
use App\Filament\Admin\Resources\Departments\Pages\ViewDepartment;
use App\Filament\Admin\Resources\Departments\Schemas\DepartmentForm;
use App\Filament\Admin\Resources\Departments\Tables\DepartmentsTable;
use App\Models\Department;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static ?string $modelLabel = 'ដេប៉ាតឺម៉ង់';

    protected static ?string $pluralModelLabel = 'ដេប៉ាតឺម៉ង់';

    protected static string|\UnitEnum|null $navigationGroup = 'គ្រប់គ្រងការសិក្សា';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return DepartmentForm::configure($schema);
    }
    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return new HtmlString('<img src="'.e(asset('Icons/department.png')).'" alt="" class="fi-sidebar-item-icon" />');
    }

    public static function table(Table $table): Table
    {
        return DepartmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDepartments::route('/'),
            'create' => CreateDepartment::route('/create'),
            'view' => ViewDepartment::route('/{record}'),
            'edit' => EditDepartment::route('/{record}/edit'),
        ];
    }
}
