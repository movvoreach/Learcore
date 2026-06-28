<?php

namespace App\Filament\Admin\Resources\Quizzes;

use App\Filament\Admin\Resources\Quizzes\Pages\CreateQuiz;
use App\Filament\Admin\Resources\Quizzes\Pages\EditQuiz;
use App\Filament\Admin\Resources\Quizzes\Pages\ListQuizzes;
use App\Filament\Admin\Resources\Quizzes\Schemas\QuizForm;
use App\Filament\Admin\Resources\Quizzes\Tables\QuizzesTable;
use App\Models\Quiz;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    protected static ?string $modelLabel = 'តេស្តខ្លី';

    protected static ?string $pluralModelLabel = 'តេស្តខ្លី';

    public static function form(Schema $schema): Schema
    {
        return QuizForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuizzesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuizzes::route('/'),
            'create' => CreateQuiz::route('/create'),
            'edit' => EditQuiz::route('/{record}/edit'),
        ];
    }
}
