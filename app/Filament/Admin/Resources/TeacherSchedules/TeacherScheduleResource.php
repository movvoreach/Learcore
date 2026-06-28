<?php

namespace App\Filament\Admin\Resources\TeacherSchedules;

use App\Filament\Admin\Resources\TeacherSchedules\Pages\CreateTeacherSchedule;
use App\Filament\Admin\Resources\TeacherSchedules\Pages\EditTeacherSchedule;
use App\Filament\Admin\Resources\TeacherSchedules\Pages\ListTeacherSchedules;
use App\Filament\Admin\Resources\TeacherSchedules\Schemas\TeacherScheduleForm;
use App\Filament\Admin\Resources\TeacherSchedules\Tables\TeacherSchedulesTable;
use App\Models\TeacherSchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TeacherScheduleResource extends Resource
{
    protected static ?string $model = TeacherSchedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'កាលវិភាគគ្រូ';

    protected static ?string $pluralModelLabel = 'កាលវិភាគគ្រូ';

    public static function form(Schema $schema): Schema
    {
        return TeacherScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeacherSchedulesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeacherSchedules::route('/'),
            'create' => CreateTeacherSchedule::route('/create'),
            'edit' => EditTeacherSchedule::route('/{record}/edit'),
        ];
    }
}
