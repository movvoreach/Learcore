<?php

namespace App\Filament\Admin\Resources\Languages\Pages;

use App\Filament\Admin\Resources\Languages\LanguageResource;
use App\Filament\Admin\Resources\Languages\Widgets\LocalizationStatsWidget;
use App\Services\Localization\LocalizationService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListLanguages extends ListRecords
{
    protected static string $resource = LanguageResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            LocalizationStatsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('clear_translation_cache')
                ->label('Clear translation cache')
                ->icon(Heroicon::OutlinedArrowPath)
                ->visible(fn (): bool => auth()->user()?->can('translation.update'))
                ->action(function (): void {
                    app(LocalizationService::class)->clearCache();
                    Notification::make()->title('Translation cache cleared')->success()->send();
                }),
            CreateAction::make(),
        ];
    }
}
