<x-filament-panels::page>
    <style>
        .lc-report {
            display: grid;
            gap: 18px;
            font-family: "Battambang", ui-sans-serif, system-ui, sans-serif;
        }

        .lc-report-head {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 18px;
            background: #fff;
        }

        .lc-report-title {
            margin: 0;
            color: #111827;
            font-size: 22px;
            font-weight: 800;
        }

        .lc-report-copy {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .lc-report-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .lc-report-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            border-radius: 7px;
            padding: 8px 14px;
            background: #f59e0b;
            color: #111827;
            font-size: 14px;
            font-weight: 800;
            text-decoration: none;
        }

        .lc-report-button.secondary {
            border: 1px solid #d1d5db;
            background: #fff;
        }

        .lc-report-card {
            overflow: hidden;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fff;
        }

        .lc-report-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 16px;
            color: #4b5563;
            font-size: 13px;
        }

        .lc-report-table-wrap {
            overflow-x: auto;
        }

        .lc-report-table {
            width: 100%;
            min-width: 820px;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .lc-report-table th,
        .lc-report-table td {
            border-bottom: 1px solid #eef2f7;
            padding: 11px 12px;
            vertical-align: top;
        }

        .lc-report-table th {
            background: #f9fafb;
            color: #374151;
            font-weight: 800;
            white-space: nowrap;
        }

        .lc-report-empty {
            padding: 28px;
            color: #6b7280;
            text-align: center;
        }

        .dark .lc-report-head,
        .dark .lc-report-card,
        .dark .lc-report-button.secondary {
            border-color: rgba(255, 255, 255, .12);
            background: #111827;
        }

        .dark .lc-report-title,
        .dark .lc-report-button.secondary {
            color: #f9fafb;
        }

        .dark .lc-report-copy,
        .dark .lc-report-meta,
        .dark .lc-report-empty {
            color: #d1d5db;
        }

        .dark .lc-report-table th {
            background: #1f2937;
            color: #f9fafb;
        }

        .dark .lc-report-table th,
        .dark .lc-report-table td,
        .dark .lc-report-meta {
            border-color: rgba(255, 255, 255, .10);
        }
    </style>

    <div class="lc-report">
        <section class="lc-report-head">
            <div>
                <h2 class="lc-report-title">{{ $report['title'] }}</h2>
                <p class="lc-report-copy">{{ $report['description'] }}</p>
            </div>

            <div class="lc-report-actions">
                <a class="lc-report-button secondary" href="{{ route('admin.reports.print', $report['key']) }}" target="_blank" rel="noopener">
                    Print / PDF
                </a>
                <a class="lc-report-button" href="{{ route('admin.reports.excel', $report['key']) }}">
                    Excel
                </a>
            </div>
        </section>

        <section class="lc-report-card">
            <div class="lc-report-meta">
                <span>Generated: {{ $report['generatedAt'] }}</span>
                <span>Total: {{ $report['total'] }}</span>
            </div>

            @if ($report['total'] === 0)
                <div class="lc-report-empty">មិនមានទិន្នន័យសម្រាប់បង្ហាញទេ។</div>
            @else
                <div class="lc-report-table-wrap">
                    <table class="lc-report-table">
                        <thead>
                            <tr>
                                @foreach ($report['columns'] as $column)
                                    <th>{{ $column }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report['rows'] as $row)
                                <tr>
                                    @foreach ($row as $cell)
                                        <td>{{ $cell }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
