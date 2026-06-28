<?php

namespace App\Filament\Admin\Resources\AssessmentQuestions;

use App\Filament\Admin\Resources\AssessmentQuestions\Pages\CreateAssessmentQuestion;
use App\Filament\Admin\Resources\AssessmentQuestions\Pages\EditAssessmentQuestion;
use App\Filament\Admin\Resources\AssessmentQuestions\Pages\ListAssessmentQuestions;
use App\Filament\Admin\Resources\AssessmentQuestions\Schemas\AssessmentQuestionForm;
use App\Filament\Admin\Resources\AssessmentQuestions\Tables\AssessmentQuestionsTable;
use App\Models\AssessmentQuestion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssessmentQuestionResource extends Resource
{
    protected static ?string $model = AssessmentQuestion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    protected static ?string $modelLabel = 'សំណួរ';

    protected static ?string $pluralModelLabel = 'សំណួរ';

    public static function form(Schema $schema): Schema
    {
        return AssessmentQuestionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssessmentQuestionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssessmentQuestions::route('/'),
            'create' => CreateAssessmentQuestion::route('/create'),
            'edit' => EditAssessmentQuestion::route('/{record}/edit'),
        ];
    }
}
