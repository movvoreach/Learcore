<?php

namespace App\Filament\Admin\Resources\Languages\Pages;

use App\Filament\Admin\Resources\Languages\LanguageResource;
use App\Services\Localization\LocalizationService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLanguage extends EditRecord
{
    protected static string $resource = LanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => ! $this->record->is_default && auth()->user()?->can('language.delete')),
        ];
    }

    protected function afterSave(): void
    {
        app(LocalizationService::class)->clearCache();
    }
}
