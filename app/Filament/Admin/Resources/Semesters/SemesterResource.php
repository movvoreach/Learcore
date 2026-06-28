<?php

namespace App\Filament\Admin\Resources\Semesters;

use App\Filament\Admin\Resources\Semesters\Pages\CreateSemester;
use App\Filament\Admin\Resources\Semesters\Pages\EditSemester;
use App\Filament\Admin\Resources\Semesters\Pages\ListSemesters;
use App\Filament\Admin\Resources\Semesters\Schemas\SemesterForm;
use App\Filament\Admin\Resources\Semesters\Tables\SemestersTable;
use App\Models\Semester;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class SemesterResource extends Resource
{
    protected static ?string $model = Semester::class;

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static ?string $modelLabel = 'ឆមាស';

    protected static ?string $pluralModelLabel = 'ឆមាស';

    protected static string|\UnitEnum|null $navigationGroup = 'គ្រប់គ្រងការសិក្សា';

    protected static ?int $navigationSort = 35;

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return new HtmlString('<img src="'.e(asset('Icons/semester.png')).'" alt="" class="fi-sidebar-item-icon" />');
    }

    public static function form(Schema $schema): Schema
    {
        return SemesterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SemestersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSemesters::route('/'),
            'create' => CreateSemester::route('/create'),
            'edit' => EditSemester::route('/{record}/edit'),
        ];
    }
}
