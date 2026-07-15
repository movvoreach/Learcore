<div class="ca-preview">
    <style>
        .ca-preview {
            color: #334155;
            font-family: "Battambang", "Noto Sans Khmer", ui-sans-serif, system-ui, sans-serif;
        }

        .ca-path {
            margin-bottom: 12px;
            color: #5866f5;
            font-size: 14px;
            font-weight: 700;
        }

        .ca-title {
            margin: 0 0 14px;
            color: #1f2937;
            font-size: 20px;
            font-weight: 700;
        }

        .ca-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 16px;
        }

        .ca-info {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: #f8fafc;
            padding: 10px 12px;
        }

        .ca-label {
            color: #64748b;
            font-size: 12px;
        }

        .ca-value {
            margin-top: 3px;
            color: #253052;
            font-weight: 700;
        }

        .ca-body {
            border: 1px solid #d8dbe8;
            border-radius: 6px;
            background: #fff;
            padding: 16px;
            color: #475569;
            line-height: 1.8;
            min-height: 130px;
        }

        .ca-link {
            display: inline-flex;
            align-items: center;
            min-height: 38px;
            margin-top: 14px;
            border-radius: 4px;
            background: #5866f5;
            color: #fff;
            padding: 0 14px;
            text-decoration: none;
        }
    </style>

    <div class="ca-path">{{ $contentPath }}</div>
    <h3 class="ca-title">{{ $record->title ?: 'Assignment' }}</h3>

    <div class="ca-grid">
        <div class="ca-info">
            <div class="ca-label">Due date</div>
            <div class="ca-value">{{ $record->due_at?->format('Y-m-d H:i') ?: '-' }}</div>
        </div>
        <div class="ca-info">
            <div class="ca-label">Max score</div>
            <div class="ca-value">{{ $record->max_score ?? '-' }}</div>
        </div>
    </div>

    <div class="ca-body">
        {!! nl2br(e($record->instructions ?: 'No instructions have been added yet.')) !!}
    </div>

    @if($attachmentUrl)
        <a class="ca-link" href="{{ $attachmentUrl }}" target="_blank" rel="noopener">Open attachment</a>
    @endif
</div>
