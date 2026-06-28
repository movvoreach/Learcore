<?php

namespace App\Filament\Admin\Pages\Reports;

use Filament\Support\Icons\Heroicon;

class ExamReport extends BaseReportPage
{
    protected static ?string $slug = 'reports/exams';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;

    protected static ?string $title = 'របាយការណ៍ប្រឡង';

    protected function reportKey(): string
    {
        return 'exams';
    }
}
