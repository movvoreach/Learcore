<?php

namespace App\Filament\Admin\Resources\Attendances;

use App\Filament\Admin\Resources\Attendances\Pages\CreateAttendance;
use App\Filament\Admin\Resources\Attendances\Pages\EditAttendance;
use App\Filament\Admin\Resources\Attendances\Pages\ListAttendances;
use App\Filament\Admin\Resources\Attendances\Schemas\AttendanceForm;
use App\Filament\Admin\Resources\Attendances\Tables\AttendancesTable;
use App\Models\Attendance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static ?string $modelLabel = 'វត្តមាន';

    protected static ?string $pluralModelLabel = 'វត្តមាន';

    protected static string|\UnitEnum|null $navigationGroup = 'គ្រប់គ្រងនិស្សិត';

    protected static ?int $navigationSort = 30;

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return new HtmlString('<img src="'.e(asset('Icons/presence.png')).'" alt="" class="fi-sidebar-item-icon" />');
    }

    public static function form(Schema $schema): Schema
    {
        return AttendanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttendancesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttendances::route('/'),
            'create' => CreateAttendance::route('/create'),
            'edit' => EditAttendance::route('/{record}/edit'),
        ];
    }
}
