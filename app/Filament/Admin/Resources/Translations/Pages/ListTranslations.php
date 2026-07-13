<?php

namespace App\Filament\Admin\Resources\Translations\Pages;

use App\Filament\Admin\Resources\Languages\Widgets\LocalizationStatsWidget;
use App\Filament\Admin\Resources\Translations\TranslationResource;
use App\Models\Language;
use App\Models\Translation;
use App\Services\Localization\LocalizationService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class ListTranslations extends ListRecords
{
    protected static string $resource = TranslationResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            LocalizationStatsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('missing_report')
                ->label('Missing report')
                ->icon(Heroicon::OutlinedExclamationTriangle)
                ->modalHeading('Missing translations')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Close')
                ->modalContent(fn () => view('filament.admin.resources.translations.missing-report', [
                    'missing' => app(LocalizationService::class)->missingTranslations(),
                ])),
            Action::make('import_json')
                ->label('Import JSON')
                ->icon(Heroicon::OutlinedArrowUpTray)
                ->visible(fn (): bool => auth()->user()?->can('translation.import'))
                ->form([
                    Select::make('language_id')
                        ->label('Language')
                        ->options(fn (): array => Language::query()->ordered()->pluck('native_name', 'id')->all())
                        ->searchable()
                        ->required(),
                    TextInput::make('group')
                        ->helperText('Optional. Leave empty for grouped JSON: {"frontend": {"home": "Home"}}. Use a group for flat JSON.')
                        ->maxLength(255),
                    FileUpload::make('file')
                        ->label('JSON file')
                        ->disk('local')
                        ->directory('translation-imports')
                        ->acceptedFileTypes(['application/json', 'text/plain'])
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $language = Language::query()->findOrFail($data['language_id']);
                    $path = is_array($data['file']) ? reset($data['file']) : $data['file'];
                    $payload = json_decode(Storage::disk('local')->get($path), true);

                    if (! is_array($payload)) {
                        Notification::make()->title('Invalid JSON file')->danger()->send();
                        return;
                    }

                    $count = app(LocalizationService::class)->importJson($language, $payload, $data['group'] ?: null);
                    Notification::make()->title("Imported {$count} translations")->success()->send();
                }),
            Action::make('export_json')
                ->label('Export JSON')
                ->icon(Heroicon::OutlinedArrowDownTray)
                ->visible(fn (): bool => auth()->user()?->can('translation.export'))
                ->form([
                    Select::make('language_id')
                        ->label('Language')
                        ->options(fn (): array => Language::query()->ordered()->pluck('native_name', 'id')->all())
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data): \Symfony\Component\HttpFoundation\StreamedResponse {
                    $language = Language::query()->findOrFail($data['language_id']);
                    $payload = app(LocalizationService::class)->exportJson($language);

                    return response()->streamDownload(
                        fn () => print json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                        "translations-{$language->code}.json",
                        ['Content-Type' => 'application/json'],
                    );
                }),
            Action::make('clear_translation_cache')
                ->label('Clear cache')
                ->icon(Heroicon::OutlinedArrowPath)
                ->visible(fn (): bool => auth()->user()?->can('translation.update'))
                ->action(function (): void {
                    app(LocalizationService::class)->clearCache();
                    Notification::make()->title('Translation cache cleared')->success()->send();
                }),
            CreateAction::make()
                ->visible(fn (): bool => auth()->user()?->can('translation.update')),
        ];
    }
}
