<?php

namespace App\Filament\Admin\Resources\Languages;

use App\Filament\Admin\Resources\Languages\Pages\CreateLanguage;
use App\Filament\Admin\Resources\Languages\Pages\EditLanguage;
use App\Filament\Admin\Resources\Languages\Pages\ListLanguages;
use App\Models\Language;
use App\Services\Localization\LocalizationService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLanguage;

    protected static ?string $slug = 'languages';

    protected static ?string $modelLabel = 'Language';

    protected static ?string $pluralModelLabel = 'Languages';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Language information')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('native_name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('code')
                        ->helperText('Short code such as en, km, ar.')
                        ->required()
                        ->maxLength(12)
                        ->alphaDash()
                        ->unique(ignoreRecord: true),
                    TextInput::make('locale')
                        ->helperText('Laravel locale such as en, km, en_US.')
                        ->required()
                        ->maxLength(20)
                        ->alphaDash()
                        ->unique(ignoreRecord: true),
                    Select::make('direction')
                        ->required()
                        ->options(['ltr' => 'Left to right', 'rtl' => 'Right to left'])
                        ->default('ltr'),
                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                    FileUpload::make('flag')
                        ->label('Flag / Icon')
                        ->image()
                        ->disk('public')
                        ->directory('language-flags')
                        ->imageEditor()
                        ->columnSpanFull(),
                    Toggle::make('is_active')
                        ->label('Enabled')
                        ->default(true),
                    Toggle::make('is_default')
                        ->label('Default language')
                        ->helperText('Only one language can be default. Default languages are always enabled.'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('flag')
                    ->label('Flag')
                    ->getStateUsing(fn (Language $record): ?string => $record->flagUrl())
                    ->circular(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('native_name')->searchable()->sortable(),
                TextColumn::make('code')->badge()->searchable()->sortable(),
                TextColumn::make('locale')->badge()->searchable()->sortable(),
                TextColumn::make('direction')->badge()->sortable(),
                IconColumn::make('is_default')->label('Default')->boolean()->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Enabled')
                    ->disabled(fn (Language $record): bool => $record->is_default || ! auth()->user()?->can('language.update')),
                TextColumn::make('completion')
                    ->label('Completion')
                    ->state(fn (Language $record): string => app(LocalizationService::class)->completionPercentage($record).'%')
                    ->badge(),
                TextColumn::make('sort_order')->sortable(),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([1 => 'Enabled', 0 => 'Disabled']),
                SelectFilter::make('direction')
                    ->options(['ltr' => 'LTR', 'rtl' => 'RTL']),
            ])
            ->recordActions([
                Action::make('set_default')
                    ->label('Set default')
                    ->icon(Heroicon::OutlinedStar)
                    ->visible(fn (Language $record): bool => ! $record->is_default && auth()->user()?->can('language.update'))
                    ->requiresConfirmation()
                    ->action(function (Language $record): void {
                        app(LocalizationService::class)->setDefault($record);
                        Notification::make()->title('Default language updated')->success()->send();
                    }),
                Action::make('duplicate')
                    ->label('Duplicate')
                    ->icon(Heroicon::OutlinedSquare2Stack)
                    ->visible(fn (): bool => auth()->user()?->can('language.create'))
                    ->form([
                        TextInput::make('name')->required()->maxLength(255),
                        TextInput::make('native_name')->required()->maxLength(255),
                        TextInput::make('code')->required()->maxLength(12)->alphaDash()
                            ->rule(fn (): array => [Rule::unique('languages', 'code')]),
                        TextInput::make('locale')->required()->maxLength(20)->alphaDash()
                            ->rule(fn (): array => [Rule::unique('languages', 'locale')]),
                        Select::make('direction')->options(['ltr' => 'LTR', 'rtl' => 'RTL'])->default('ltr')->required(),
                        Toggle::make('is_active')->default(false),
                    ])
                    ->action(function (Language $record, array $data): void {
                        app(LocalizationService::class)->duplicate($record, $data);
                        Notification::make()->title('Language duplicated')->success()->send();
                    }),
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn (Language $record): bool => ! $record->is_default && auth()->user()?->can('language.delete')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => auth()->user()?->can('language.delete')),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('language.view') ?? false;
    }

    public static function canAccess(): bool
    {
        return static::canViewAny();
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('language.create') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('language.update') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return ! $record->is_default && (auth()->user()?->can('language.delete') ?? false);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLanguages::route('/'),
            'create' => CreateLanguage::route('/create'),
            'edit' => EditLanguage::route('/{record}/edit'),
        ];
    }
}
