<?php

namespace App\Filament\Admin\Resources\Students;

use App\Filament\Admin\Resources\Students\Pages\CreateStudent;
use App\Filament\Admin\Resources\Students\Pages\EditStudent;
use App\Filament\Admin\Resources\Students\Pages\ListStudents;
use App\Filament\Admin\Resources\Students\Schemas\StudentForm;
use App\Filament\Admin\Resources\Students\Tables\StudentsTable;
use App\Models\Student;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static ?string $modelLabel = 'និស្សិត';

    protected static ?string $pluralModelLabel = 'និស្សិត';

    protected static string|\UnitEnum|null $navigationGroup = 'គ្រប់គ្រងនិស្សិត';

    protected static ?int $navigationSort = 10;

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return new HtmlString('<img src="'.e(asset('Icons/students.png')).'" alt="" class="fi-sidebar-item-icon" />');
    }

    public static function form(Schema $schema): Schema
    {
        return StudentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['department', 'academicYear', 'semester'])
            ->withCount(['enrollments', 'progresses', 'certificates']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}
