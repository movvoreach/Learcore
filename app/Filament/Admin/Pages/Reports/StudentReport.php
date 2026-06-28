<?php

namespace App\Filament\Admin\Pages\Reports;

use Filament\Support\Icons\Heroicon;

class StudentReport extends BaseReportPage
{
    protected static ?string $slug = 'reports/students';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $title = 'របាយការណ៍និស្សិត';

    protected function reportKey(): string
    {
        return 'students';
    }
}
