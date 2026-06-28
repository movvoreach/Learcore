<?php

namespace App\Filament\Admin\Resources\ExamCandidates;

use App\Filament\Admin\Resources\ExamCandidates\Pages\CreateExamCandidate;
use App\Filament\Admin\Resources\ExamCandidates\Pages\EditExamCandidate;
use App\Filament\Admin\Resources\ExamCandidates\Pages\ListExamCandidates;
use App\Filament\Admin\Resources\ExamCandidates\Schemas\ExamCandidateForm;
use App\Filament\Admin\Resources\ExamCandidates\Tables\ExamCandidatesTable;
use App\Models\ExamCandidate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExamCandidateResource extends Resource
{
    protected static ?string $model = ExamCandidate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'បេក្ខជនប្រឡង';

    protected static ?string $pluralModelLabel = 'បេក្ខជនប្រឡង';

    public static function form(Schema $schema): Schema
    {
        return ExamCandidateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamCandidatesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExamCandidates::route('/'),
            'create' => CreateExamCandidate::route('/create'),
            'edit' => EditExamCandidate::route('/{record}/edit'),
        ];
    }
}
