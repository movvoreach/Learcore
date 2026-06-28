<?php

namespace App\Filament\Admin\Resources\QuestionOptions;

use App\Filament\Admin\Resources\QuestionOptions\Pages\CreateQuestionOption;
use App\Filament\Admin\Resources\QuestionOptions\Pages\EditQuestionOption;
use App\Filament\Admin\Resources\QuestionOptions\Pages\ListQuestionOptions;
use App\Filament\Admin\Resources\QuestionOptions\Schemas\QuestionOptionForm;
use App\Filament\Admin\Resources\QuestionOptions\Tables\QuestionOptionsTable;
use App\Models\QuestionOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuestionOptionResource extends Resource
{
    protected static ?string $model = QuestionOption::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckCircle;

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    protected static ?string $modelLabel = 'ជម្រើសចម្លើយ';

    protected static ?string $pluralModelLabel = 'ជម្រើសចម្លើយ';

    public static function form(Schema $schema): Schema
    {
        return QuestionOptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionOptionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionOptions::route('/'),
            'create' => CreateQuestionOption::route('/create'),
            'edit' => EditQuestionOption::route('/{record}/edit'),
        ];
    }
}
