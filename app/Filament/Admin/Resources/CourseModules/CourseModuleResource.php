<?php

namespace App\Filament\Admin\Resources\CourseModules;

use App\Filament\Admin\Resources\CourseModules\Pages\CreateCourseModule;
use App\Filament\Admin\Resources\CourseModules\Pages\EditCourseModule;
use App\Filament\Admin\Resources\CourseModules\Pages\ListCourseModules;
use App\Filament\Admin\Resources\CourseModules\Schemas\CourseModuleForm;
use App\Filament\Admin\Resources\CourseModules\Tables\CourseModulesTable;
use App\Models\CourseModule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseModuleResource extends Resource
{
    protected static ?string $model = CourseModule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Module';

    protected static ?string $pluralModelLabel = 'Course Modules';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return CourseModuleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseModulesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourseModules::route('/'),
            'create' => CreateCourseModule::route('/create'),
            'edit' => EditCourseModule::route('/{record}/edit'),
        ];
    }
}
