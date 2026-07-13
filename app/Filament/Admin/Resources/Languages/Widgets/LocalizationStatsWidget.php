<?php

namespace App\Filament\Admin\Resources\Languages\Widgets;

use App\Models\Language;
use App\Models\Translation;
use App\Services\Localization\LocalizationService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LocalizationStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalKeys = Translation::query()->select('group', 'key')->distinct()->count();
        $averageCompletion = Language::query()->get()
            ->avg(fn (Language $language): float => app(LocalizationService::class)->completionPercentage($language)) ?? 0;

        return [
            Stat::make('Total Languages', Language::query()->count())
                ->description('All configured languages')
                ->descriptionIcon('heroicon-m-language')
                ->color('primary'),
            Stat::make('Active Languages', Language::query()->where('is_active', true)->count())
                ->description('Available to users')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Total Translation Keys', $totalKeys)
                ->description('Unique group/key pairs')
                ->descriptionIcon('heroicon-m-key')
                ->color('info'),
            Stat::make('Translation Completion %', round($averageCompletion, 1).'%')
                ->description('Average across languages')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($averageCompletion >= 90 ? 'success' : 'warning'),
        ];
    }
}
