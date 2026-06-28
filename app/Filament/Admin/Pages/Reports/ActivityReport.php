<?php

namespace App\Filament\Admin\Pages\Reports;

use Filament\Support\Icons\Heroicon;

class ActivityReport extends BaseReportPage
{
    protected static ?string $slug = 'reports/activity';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static ?string $title = 'កំណត់ត្រាសកម្មភាព';

    protected function reportKey(): string
    {
        return 'activity';
    }
}
