<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Reports\LmsReport;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportExportController extends Controller
{
    public function excel(string $report): StreamedResponse
    {
        $data = LmsReport::make($report);
        $filename = $data['filename'].'-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($data): void {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [$data['title']]);
            fputcsv($handle, ['Generated at', $data['generatedAt']]);
            fputcsv($handle, []);
            fputcsv($handle, $data['columns']);

            foreach ($data['rows'] as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function print(string $report)
    {
        return view('admin.reports.print', [
            'report' => LmsReport::make($report),
        ]);
    }
}
