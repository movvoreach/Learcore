<?php

namespace App\Filament\Admin\Resources\ActivityLogResource\Widgets;

use App\Models\ActivityLog;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class ActivityLogChartWidget extends ChartWidget
{
    protected ?string $heading = 'Activity Overview (Last 7 Days)';
    
    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('M d');
            $data[] = ActivityLog::whereDate('created_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Activities',
                    'data' => $data,
                    'fill' => 'start',
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)'  ,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
