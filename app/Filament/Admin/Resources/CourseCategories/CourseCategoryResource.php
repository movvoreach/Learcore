<?php

namespace App\Filament\Admin\Resources\CourseCategories;

use App\Filament\Admin\Resources\CourseCategories\Pages\CreateCourseCategory;
use App\Filament\Admin\Resources\CourseCategories\Pages\EditCourseCategory;
use App\Filament\Admin\Resources\CourseCategories\Pages\ListCourseCategories;
use App\Filament\Admin\Resources\CourseCategories\Schemas\CourseCategoryForm;
use App\Filament\Admin\Resources\CourseCategories\Tables\CourseCategoriesTable;
use App\Models\CourseCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseCategoryResource extends Resource
{
    protected static ?string $model = CourseCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'ប្រភេទវគ្គសិក្សា';

    protected static ?string $pluralModelLabel = 'ប្រភេទវគ្គសិក្សា';

    protected static string|\UnitEnum|null $navigationGroup = 'គ្រប់គ្រងការសិក្សា';

    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return CourseCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseCategoriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourseCategories::route('/'),
            'create' => CreateCourseCategory::route('/create'),
            'edit' => EditCourseCategory::route('/{record}/edit'),
        ];
    }
}
