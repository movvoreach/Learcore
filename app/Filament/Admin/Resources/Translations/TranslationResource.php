<?php

namespace App\Filament\Admin\Resources\Translations;

use App\Filament\Admin\Resources\Translations\Pages\CreateTranslation;
use App\Filament\Admin\Resources\Translations\Pages\EditTranslation;
use App\Filament\Admin\Resources\Translations\Pages\ListTranslations;
use App\Models\Language;
use App\Models\Translation;
use App\Services\Localization\LocalizationService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLanguage;

    protected static ?string $slug = 'translations';

    protected static ?string $modelLabel = 'Translation';

    protected static ?string $pluralModelLabel = 'Translations';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Translation')
                ->columns(2)
                ->schema([
                    Select::make('language_id')
                        ->label('Language')
                        ->relationship('language', 'native_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('group')
                        ->required()
                        ->default('frontend')
                        ->maxLength(255),
                    TextInput::make('key')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('value')
                        ->rows(5)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with('language'))
            ->columns([
                TextColumn::make('language.native_name')->label('Language')->searchable()->sortable(),
                TextColumn::make('language.code')->label('Code')->badge()->sortable(),
                TextColumn::make('group')->badge()->searchable()->sortable(),
                TextColumn::make('key')->searchable()->sortable()->wrap(),
                TextColumn::make('value')->searchable()->limit(80)->wrap(),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('language_id')
                    ->label('Language')
                    ->relationship('language', 'native_name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('group')
                    ->options(fn (): array => Translation::query()->select('group')->distinct()->orderBy('group')->pluck('group', 'group')->all())
                    ->searchable(),
                Filter::make('missing')
                    ->label('Missing value')
                    ->query(fn (Builder $query): Builder => $query->where(fn (Builder $query): Builder => $query->whereNull('value')->orWhere('value', ''))),
            ])
            ->recordActions([
                Action::make('edit_all_languages')
                    ->label('Edit all languages')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->visible(fn (): bool => auth()->user()?->can('translation.update'))
                    ->fillForm(fn (Translation $record): array => Language::query()
                        ->ordered()
                        ->get()
                        ->mapWithKeys(fn (Language $language): array => [
                            'value_'.$language->id => Translation::query()
                                ->where('language_id', $language->id)
                                ->where('group', $record->group)
                                ->where('key', $record->key)
                                ->value('value'),
                        ])
                        ->all())
                    ->form(fn (Translation $record): array => [
                        Grid::make(1)->schema(
                            Language::query()
                                ->ordered()
                                ->get()
                                ->map(fn (Language $language): Textarea => Textarea::make('value_'.$language->id)
                                    ->label($language->native_name.' ('.$language->code.')')
                                    ->rows(3))
                                ->all()
                        ),
                    ])
                    ->action(function (Translation $record, array $data): void {
                        foreach (Language::query()->ordered()->get() as $language) {
                            Translation::query()->updateOrCreate(
                                [
                                    'language_id' => $language->id,
                                    'group' => $record->group,
                                    'key' => $record->key,
                                ],
                                ['value' => $data['value_'.$language->id] ?? null],
                            );
                        }

                        app(LocalizationService::class)->clearCache();
                        Notification::make()->title('Translations updated')->success()->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => auth()->user()?->can('translation.update')),
                ]),
            ])
            ->defaultSort('group');
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('translation.view') ?? false;
    }

    public static function canAccess(): bool
    {
        return static::canViewAny();
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('translation.update') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('translation.update') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('translation.update') ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTranslations::route('/'),
            'create' => CreateTranslation::route('/create'),
            'edit' => EditTranslation::route('/{record}/edit'),
        ];
    }
}
