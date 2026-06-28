<?php

namespace App\Filament\Admin\Resources\QuestionBanks;

use App\Filament\Admin\Resources\QuestionBanks\Pages\CreateQuestionBank;
use App\Filament\Admin\Resources\QuestionBanks\Pages\EditQuestionBank;
use App\Filament\Admin\Resources\QuestionBanks\Pages\ListQuestionBanks;
use App\Filament\Admin\Resources\QuestionBanks\Schemas\QuestionBankForm;
use App\Filament\Admin\Resources\QuestionBanks\Tables\QuestionBanksTable;
use App\Models\QuestionBank;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuestionBankResource extends Resource
{
    protected static ?string $model = QuestionBank::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCircleStack;

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    protected static ?string $modelLabel = 'ធនាគារសំណួរ';

    protected static ?string $pluralModelLabel = 'ធនាគារសំណួរ';

    public static function form(Schema $schema): Schema
    {
        return QuestionBankForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionBanksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionBanks::route('/'),
            'create' => CreateQuestionBank::route('/create'),
            'edit' => EditQuestionBank::route('/{record}/edit'),
        ];
    }
}
