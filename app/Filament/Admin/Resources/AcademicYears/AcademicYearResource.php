<?php

namespace App\Filament\Admin\Resources\AcademicYears;

use App\Filament\Admin\Resources\AcademicYears\Pages\CreateAcademicYear;
use App\Filament\Admin\Resources\AcademicYears\Pages\EditAcademicYear;
use App\Filament\Admin\Resources\AcademicYears\Pages\ListAcademicYears;
use App\Filament\Admin\Resources\AcademicYears\Schemas\AcademicYearForm;
use App\Filament\Admin\Resources\AcademicYears\Tables\AcademicYearsTable;
use App\Models\AcademicYear;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class AcademicYearResource extends Resource
{
    protected static ?string $model = AcademicYear::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static ?string $modelLabel = 'ឆ្នាំសិក្សា';

    protected static ?string $pluralModelLabel = 'ឆ្នាំសិក្សា';

    protected static string|\UnitEnum|null $navigationGroup = 'គ្រប់គ្រងការសិក្សា';

    protected static ?int $navigationSort = 30;

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return new HtmlString('<img src="'.e(asset('Icons/yearacademic.png')).'" alt="" class="fi-sidebar-item-icon" />');
    }

    public static function form(Schema $schema): Schema
    {
        return AcademicYearForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AcademicYearsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAcademicYears::route('/'),
            'create' => CreateAcademicYear::route('/create'),
            'edit' => EditAcademicYear::route('/{record}/edit'),
        ];
    }
}
