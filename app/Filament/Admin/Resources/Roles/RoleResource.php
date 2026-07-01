<?php

namespace App\Filament\Admin\Resources\Roles;

use App\Filament\Admin\Resources\Roles\Pages\CreateRole;
use App\Filament\Admin\Resources\Roles\Pages\EditRole;
use App\Filament\Admin\Resources\Roles\Pages\ListRoles;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $modelLabel = 'តួនាទី';

    protected static ?string $pluralModelLabel = 'តួនាទី';

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('តួនាទី')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('ឈ្មោះតួនាទី')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    TextInput::make('guard_name')
                        ->label('ឈ្មោះ Guard')
                        ->default('web')
                        ->required()
                        ->maxLength(255),
                    Select::make('permissions')
                        ->label('សិទ្ធិអនុញ្ញាត')
                        ->relationship('permissions', 'name')
                        ->multiple()
                        ->options(fn (): array => Permission::query()->orderBy('name')->pluck('name', 'id')->all())
                        ->preload()
                        ->searchable()
                        ->columnSpanFull()
                        ->placeholder('ជ្រើសរើសជម្រើសណាមួយ'),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('ឈ្មោះតួនាទី')->searchable()->sortable(),
                TextColumn::make('permissions.name')->label('សិទ្ធិអនុញ្ញាត')->badge()->separator(',')->limitList(6),
                TextColumn::make('created_at')->label('បានបង្កើតនៅ')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('កែសម្រួល')
                    ->successNotificationTitle('តួនាទីត្រូវបានកែសម្រួលដោយជោគជ័យ!'),
                DeleteAction::make()
                    ->label('លុប')
                    ->successNotificationTitle('តួនាទីត្រូវបានលុបដោយជោគជ័យ!'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('លុបដែលបានជ្រើសរើស')
                        ->successNotificationTitle('តួនាទីដែលបានជ្រើសរើសត្រូវបានលុបដោយជោគជ័យ!'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
