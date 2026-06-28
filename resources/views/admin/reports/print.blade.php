<!doctype html>
<html lang="km">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $report['title'] }}</title>
    <style>
        body {
            margin: 0;
            padding: 28px;
            color: #111827;
            font-family: Battambang, Arial, sans-serif;
            background: #fff;
        }

        .toolbar {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 18px;
        }

        button,
        a {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 8px 12px;
            background: #fff;
            color: #111827;
            font: inherit;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .description,
        .meta {
            color: #4b5563;
            font-size: 13px;
        }

        .description {
            margin: 6px 0 14px;
        }

        .meta {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 7px 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
            font-weight: 800;
        }

        .empty {
            border: 1px solid #d1d5db;
            padding: 24px;
            text-align: center;
        }

        @page {
            margin: 14mm;
        }

        @media print {
            body {
                padding: 0;
            }

            .toolbar {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <a href="{{ route('admin.reports.excel', $report['key']) }}">Excel</a>
        <button type="button" onclick="window.print()">Print / Save PDF</button>
    </div>

    <h1>{{ $report['title'] }}</h1>
    <p class="description">{{ $report['description'] }}</p>
    <div class="meta">
        <span>Generated: {{ $report['generatedAt'] }}</span>
        <span>Total: {{ $report['total'] }}</span>
    </div>

    @if ($report['total'] === 0)
        <div class="empty">មិនមានទិន្នន័យសម្រាប់បង្ហាញទេ។</div>
    @else
        <table>
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
    @endif
</body>
</html>
