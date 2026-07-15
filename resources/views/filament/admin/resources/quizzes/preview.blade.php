<div class="qz-preview">
    <style>
        .qz-preview {
            color: #334155;
            font-family: "Battambang", "Noto Sans Khmer", ui-sans-serif, system-ui, sans-serif;
        }

        .qz-path {
            margin-bottom: 12px;
            color: #5866f5;
            font-size: 14px;
            font-weight: 700;
        }

        .qz-title {
            margin: 0 0 14px;
            color: #1f2937;
            font-size: 20px;
            font-weight: 700;
        }

        .qz-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 16px;
        }

        .qz-info {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: #f8fafc;
            padding: 10px 12px;
        }

        .qz-label {
            color: #64748b;
            font-size: 12px;
        }

        .qz-value {
            margin-top: 3px;
            color: #253052;
            font-weight: 700;
        }

        .qz-body {
            border: 1px solid #d8dbe8;
            border-radius: 6px;
            background: #fff;
            padding: 16px;
            color: #475569;
            line-height: 1.8;
            min-height: 130px;
        }
    </style>

    <div class="qz-path">{{ $contentPath }}</div>
    <h3 class="qz-title">{{ $record->title ?: 'Quiz' }}</h3>

    <div class="qz-grid">
        <div class="qz-info">
            <div class="qz-label">Start</div>
            <div class="qz-value">{{ $record->available_from?->format('Y-m-d H:i') ?: '-' }}</div>
        </div>
        <div class="qz-info">
            <div class="qz-label">End</div>
            <div class="qz-value">{{ $record->available_until?->format('Y-m-d H:i') ?: '-' }}</div>
        </div>
        <div class="qz-info">
            <div class="qz-label">Time limit</div>
            <div class="qz-value">{{ $record->time_limit_minutes ? $record->time_limit_minutes.' min' : '-' }}</div>
        </div>
        <div class="qz-info">
            <div class="qz-label">Passing score</div>
            <div class="qz-value">{{ $record->passing_score ?? '-' }}</div>
        </div>
        <div class="qz-info">
            <div class="qz-label">Max attempts</div>
            <div class="qz-value">{{ $record->max_attempts ?? '-' }}</div>
        </div>
        <div class="qz-info">
            <div class="qz-label">Status</div>
            <div class="qz-value">{{ $record->is_published ? 'Published' : 'Draft' }}</div>
        </div>
    </div>

    <div class="qz-body">
        {!! $record->instructions ?: 'No instructions have been added yet.' !!}
    </div>
</div>
