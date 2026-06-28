<?php

namespace App\Filament\Admin\Resources\AssessmentResults;

use App\Filament\Admin\Resources\AssessmentResults\Pages\CreateAssessmentResult;
use App\Filament\Admin\Resources\AssessmentResults\Pages\EditAssessmentResult;
use App\Filament\Admin\Resources\AssessmentResults\Pages\ListAssessmentResults;
use App\Filament\Admin\Resources\AssessmentResults\Schemas\AssessmentResultForm;
use App\Filament\Admin\Resources\AssessmentResults\Tables\AssessmentResultsTable;
use App\Models\AssessmentResult;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssessmentResultResource extends Resource
{
    protected static ?string $model = AssessmentResult::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrophy;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'លទ្ធផល';

    protected static ?string $pluralModelLabel = 'លទ្ធផល';

    public static function form(Schema $schema): Schema
    {
        return AssessmentResultForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssessmentResultsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssessmentResults::route('/'),
            'create' => CreateAssessmentResult::route('/create'),
            'edit' => EditAssessmentResult::route('/{record}/edit'),
        ];
    }
}
