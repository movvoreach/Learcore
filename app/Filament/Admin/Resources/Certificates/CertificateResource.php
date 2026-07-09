<?php

namespace App\Filament\Admin\Resources\Certificates;

use App\Filament\Admin\Resources\Certificates\Pages\CreateCertificate;
use App\Filament\Admin\Resources\Certificates\Pages\EditCertificate;
use App\Filament\Admin\Resources\Certificates\Pages\ListCertificates;
use App\Filament\Admin\Resources\Certificates\Schemas\CertificateForm;
use App\Filament\Admin\Resources\Certificates\Tables\CertificatesTable;
use App\Models\Certificate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'វិញ្ញាបនបត្រ';

    protected static ?string $pluralModelLabel = 'វិញ្ញាបនបត្រ';

    protected static string|\UnitEnum|null $navigationGroup = 'គ្រប់គ្រងនិស្សិត';

    protected static ?int $navigationSort = 50;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher', 'student']) ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return ! auth()->user()?->isStudent()
            && (auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false);
    }

    public static function canDelete(Model $record): bool
    {
        return ! auth()->user()?->isStudent()
            && (auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false);
    }

    public static function canDeleteAny(): bool
    {
        return ! auth()->user()?->isStudent()
            && (auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user?->isStudent()) {
            return $user->student
                ? $query->where('student_id', $user->student->student_id)
                : $query->whereRaw('1 = 0');
        }

        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return CertificateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CertificatesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCertificates::route('/'),
            'create' => CreateCertificate::route('/create'),
            'edit' => EditCertificate::route('/{record}/edit'),
        ];
    }
}
