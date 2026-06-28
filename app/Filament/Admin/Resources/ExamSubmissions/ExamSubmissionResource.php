<?php

namespace App\Filament\Admin\Resources\ExamSubmissions;

use App\Filament\Admin\Resources\ExamSubmissions\Pages\CreateExamSubmission;
use App\Filament\Admin\Resources\ExamSubmissions\Pages\EditExamSubmission;
use App\Filament\Admin\Resources\ExamSubmissions\Pages\ListExamSubmissions;
use App\Filament\Admin\Resources\ExamSubmissions\Schemas\ExamSubmissionForm;
use App\Filament\Admin\Resources\ExamSubmissions\Tables\ExamSubmissionsTable;
use App\Models\ExamSubmission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExamSubmissionResource extends Resource
{
    protected static ?string $model = ExamSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxStack;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'ការដាក់ស្នើ';

    protected static ?string $pluralModelLabel = 'ការដាក់ស្នើ';

    public static function form(Schema $schema): Schema
    {
        return ExamSubmissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamSubmissionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExamSubmissions::route('/'),
            'create' => CreateExamSubmission::route('/create'),
            'edit' => EditExamSubmission::route('/{record}/edit'),
        ];
    }
}
