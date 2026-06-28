<?php

namespace App\Filament\Admin\Resources\ContentAssignments;

use App\Filament\Admin\Resources\ContentAssignments\Pages\CreateContentAssignment;
use App\Filament\Admin\Resources\ContentAssignments\Pages\EditContentAssignment;
use App\Filament\Admin\Resources\ContentAssignments\Pages\ListContentAssignments;
use App\Filament\Admin\Resources\ContentAssignments\Schemas\ContentAssignmentForm;
use App\Filament\Admin\Resources\ContentAssignments\Tables\ContentAssignmentsTable;
use App\Models\ContentAssignment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContentAssignmentResource extends Resource
{
    protected static ?string $model = ContentAssignment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    protected static ?string $modelLabel = 'កិច្ចការ';

    protected static ?string $pluralModelLabel = 'កិច្ចការ';

    public static function form(Schema $schema): Schema
    {
        return ContentAssignmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentAssignmentsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContentAssignments::route('/'),
            'create' => CreateContentAssignment::route('/create'),
            'edit' => EditContentAssignment::route('/{record}/edit'),
        ];
    }
}
