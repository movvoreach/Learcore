<?php

namespace App\Filament\Admin\Pages\Reports;

use Filament\Support\Icons\Heroicon;

class FinanceReport extends BaseReportPage
{
    protected static ?string $slug = 'reports/finance';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $title = 'របាយការណ៍ហិរញ្ញវត្ថុ';

    protected function reportKey(): string
    {
        return 'finance';
    }
}
