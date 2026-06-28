<?php

namespace App\Filament\Admin\Pages\Reports;

use App\Reports\LmsReport;
use Filament\Pages\Page;

abstract class BaseReportPage extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.reports.report-page';

    abstract protected function reportKey(): string;

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'report' => LmsReport::make($this->reportKey()),
        ];
    }
}
