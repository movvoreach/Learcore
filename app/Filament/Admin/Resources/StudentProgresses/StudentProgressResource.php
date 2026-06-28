<?php

namespace App\Filament\Admin\Resources\StudentProgresses;

use App\Filament\Admin\Resources\StudentProgresses\Pages\CreateStudentProgress;
use App\Filament\Admin\Resources\StudentProgresses\Pages\EditStudentProgress;
use App\Filament\Admin\Resources\StudentProgresses\Pages\ListStudentProgresses;
use App\Filament\Admin\Resources\StudentProgresses\Schemas\StudentProgressForm;
use App\Filament\Admin\Resources\StudentProgresses\Tables\StudentProgressesTable;
use App\Models\StudentProgress;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudentProgressResource extends Resource
{
    protected static ?string $model = StudentProgress::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBarSquare;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'student-progresses';

    protected static ?string $modelLabel = 'តាមដានវឌ្ឍនភាព';

    protected static ?string $pluralModelLabel = 'តាមដានវឌ្ឍនភាព';

    protected static string|\UnitEnum|null $navigationGroup = 'គ្រប់គ្រងនិស្សិត';

    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return StudentProgressForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentProgressesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentProgresses::route('/'),
            'create' => CreateStudentProgress::route('/create'),
            'edit' => EditStudentProgress::route('/{record}/edit'),
        ];
    }
}
