<?php

namespace App\Filament\Admin\Resources\ActivityLogResource\Widgets;

use App\Models\ActivityLog;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class ActivityLogStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Logs', ActivityLog::count())
                ->description('All time activities')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            Stat::make('Activities Today', ActivityLog::whereDate('created_at', Carbon::today())->count())
                ->description('System activities today')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Logins Today', ActivityLog::whereDate('created_at', Carbon::today())->where('action', 'logged_in')->count())
                ->description('Users who logged in today')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}
