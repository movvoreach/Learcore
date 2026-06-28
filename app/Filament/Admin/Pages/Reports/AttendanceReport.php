<?php

namespace App\Filament\Admin\Pages\Reports;

use Filament\Support\Icons\Heroicon;

class AttendanceReport extends BaseReportPage
{
    protected static ?string $slug = 'reports/attendance';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;

    protected static ?string $title = 'របាយការណ៍វត្តមាន';

    protected function reportKey(): string
    {
        return 'attendance';
    }
}
