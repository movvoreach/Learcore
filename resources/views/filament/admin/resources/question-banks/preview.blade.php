<div class="as-preview">
    <style>
        .as-preview { color:#334155;font-family:"Battambang","Noto Sans Khmer",ui-sans-serif,system-ui,sans-serif; }
        .as-title { margin:0 0 14px;color:#1f2937;font-size:20px;font-weight:700; }
        .as-grid { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin-bottom:16px; }
        .as-info { border:1px solid #e2e8f0;border-radius:6px;background:#f8fafc;padding:10px 12px; }
        .as-label { color:#64748b;font-size:12px; }
        .as-value { margin-top:3px;color:#253052;font-weight:700; }
        .as-body { border:1px solid #d8dbe8;border-radius:6px;background:#fff;padding:16px;color:#475569;line-height:1.8;min-height:110px; }
    </style>

    <h3 class="as-title">{{ $record->title ?: 'Question bank' }}</h3>
    <div class="as-grid">
        <div class="as-info"><div class="as-label">Course</div><div class="as-value">{{ $record->course?->course_name ?: '-' }}</div></div>
        <div class="as-info"><div class="as-label">Subject</div><div class="as-value">{{ $record->subject?->subject_name ?: '-' }}</div></div>
        <div class="as-info"><div class="as-label">Questions</div><div class="as-value">{{ $record->questions_count ?? $record->questions()->count() }}</div></div>
        <div class="as-info"><div class="as-label">Status</div><div class="as-value">{{ $record->is_active ? 'Active' : 'Inactive' }}</div></div>
    </div>
    <div class="as-body">{!! nl2br(e($record->description ?: 'No description has been added yet.')) !!}</div>
</div>
