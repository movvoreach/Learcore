<div class="as-preview">
    <style>
        .as-preview { color:#334155;font-family:"Battambang","Noto Sans Khmer",ui-sans-serif,system-ui,sans-serif; }
        .as-title { margin:0 0 14px;color:#1f2937;font-size:20px;font-weight:700; }
        .as-grid { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin-bottom:16px; }
        .as-info { border:1px solid #e2e8f0;border-radius:6px;background:#f8fafc;padding:10px 12px; }
        .as-label { color:#64748b;font-size:12px; }
        .as-value { margin-top:3px;color:#253052;font-weight:700; }
        .as-body { border:1px solid #d8dbe8;border-radius:6px;background:#fff;padding:16px;color:#475569;line-height:1.8;margin-bottom:12px; }
    </style>

    <h3 class="as-title">Question</h3>
    <div class="as-grid">
        <div class="as-info"><div class="as-label">Bank</div><div class="as-value">{{ $record->bank?->title ?: '-' }}</div></div>
        <div class="as-info"><div class="as-label">Lesson</div><div class="as-value">{{ $record->lesson?->title ?: '-' }}</div></div>
        <div class="as-info"><div class="as-label">Type</div><div class="as-value">{{ str_replace('_', ' ', $record->question_type ?: '-') }}</div></div>
        <div class="as-info"><div class="as-label">Points</div><div class="as-value">{{ $record->points ?? '-' }}</div></div>
    </div>
    <div class="as-body">{!! nl2br(e($record->question_text ?: 'No question text has been added yet.')) !!}</div>
    @if($record->correct_answer)
        <div class="as-body"><strong>Correct answer:</strong><br>{!! nl2br(e($record->correct_answer)) !!}</div>
    @endif
    @if($record->explanation)
        <div class="as-body"><strong>Explanation:</strong><br>{!! nl2br(e($record->explanation)) !!}</div>
    @endif
</div>
