<?php

namespace App\Filament\Admin\Resources\AssessmentGrades;

use App\Filament\Admin\Resources\AssessmentGrades\Pages\CreateAssessmentGrade;
use App\Filament\Admin\Resources\AssessmentGrades\Pages\EditAssessmentGrade;
use App\Filament\Admin\Resources\AssessmentGrades\Pages\ListAssessmentGrades;
use App\Filament\Admin\Resources\AssessmentGrades\Schemas\AssessmentGradeForm;
use App\Filament\Admin\Resources\AssessmentGrades\Tables\AssessmentGradesTable;
use App\Models\AssessmentGrade;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssessmentGradeResource extends Resource
{
    protected static ?string $model = AssessmentGrade::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'ការដាក់ពិន្ទុ';

    protected static ?string $pluralModelLabel = 'ការដាក់ពិន្ទុ';

    public static function form(Schema $schema): Schema
    {
        return AssessmentGradeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssessmentGradesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssessmentGrades::route('/'),
            'create' => CreateAssessmentGrade::route('/create'),
            'edit' => EditAssessmentGrade::route('/{record}/edit'),
        ];
    }
}
