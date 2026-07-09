<?php

namespace App\Filament\Admin\Resources\Schedules;

use App\Filament\Admin\Resources\Schedules\Pages\EditSchedule;
use App\Filament\Admin\Resources\Schedules\Pages\ListSchedules;
use App\Filament\Admin\Resources\Schedules\Pages\ScheduleAttendanceSheet;
use App\Filament\Admin\Resources\Schedules\Pages\ShowSchedule;
use App\Filament\Admin\Resources\Schedules\Schemas\ScheduleForm;
use App\Filament\Admin\Resources\Schedules\Tables\SchedulesTable;
use App\Models\Schedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'កាលវិភាគសិក្សា';

    protected static ?string $pluralModelLabel = 'កាលវិភាគសិក្សា';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher', 'student']) ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher', 'student']) ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return ScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchedulesTable::configure($table);
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
            'index' => ListSchedules::route('/'),
            'edit' => EditSchedule::route('/{record}/edit'),
            'show' => ShowSchedule::route('/{record}/show'),
            'attendance-sheet' => ScheduleAttendanceSheet::route('/{record}/attendance-sheet'),
        ];
    }
}
