<?php

namespace App\Filament\Admin\Resources\AssignmentSubmissions;

use App\Filament\Admin\Resources\AssignmentSubmissions\Pages\EditAssignmentSubmission;
use App\Filament\Admin\Resources\AssignmentSubmissions\Pages\ListAssignmentSubmissions;
use App\Filament\Admin\Resources\AssignmentSubmissions\Schemas\AssignmentSubmissionForm;
use App\Filament\Admin\Resources\AssignmentSubmissions\Tables\AssignmentSubmissionsTable;
use App\Models\AssignmentSubmission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssignmentSubmissionResource extends Resource
{
    protected static ?string $model = AssignmentSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Assignment Submission';

    protected static ?string $pluralModelLabel = 'Assignment Submissions';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return AssignmentSubmissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssignmentSubmissionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssignmentSubmissions::route('/'),
            'edit' => EditAssignmentSubmission::route('/{record}/edit'),
        ];
    }
}
