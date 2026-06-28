<?php

namespace App\Filament\Admin\Resources\CourseAssignments;

use App\Filament\Admin\Resources\CourseAssignments\Pages\CreateCourseAssignment;
use App\Filament\Admin\Resources\CourseAssignments\Pages\EditCourseAssignment;
use App\Filament\Admin\Resources\CourseAssignments\Pages\ListCourseAssignments;
use App\Filament\Admin\Resources\CourseAssignments\Schemas\CourseAssignmentForm;
use App\Filament\Admin\Resources\CourseAssignments\Tables\CourseAssignmentsTable;
use App\Models\CourseAssignment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseAssignmentResource extends Resource
{
    protected static ?string $model = CourseAssignment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'ចាត់តាំងវគ្គសិក្សា';

    protected static ?string $pluralModelLabel = 'ចាត់តាំងវគ្គសិក្សា';

    public static function form(Schema $schema): Schema
    {
        return CourseAssignmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseAssignmentsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourseAssignments::route('/'),
            'create' => CreateCourseAssignment::route('/create'),
            'edit' => EditCourseAssignment::route('/{record}/edit'),
        ];
    }
}
