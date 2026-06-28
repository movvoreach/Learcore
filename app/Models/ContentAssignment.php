<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentAssignment extends Model
{
    protected $primaryKey = 'content_assignment_id';

    protected $fillable = [
        'content_lesson_id',
        'content_chapter_id',
        'title',
        'instructions',
        'attachment_path',
        'due_at',
        'max_score',
        'allow_late_submission',
        'is_published',
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'allow_late_submission' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(ContentLesson::class, 'content_lesson_id', 'content_lesson_id');
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(ContentChapter::class, 'content_chapter_id', 'content_chapter_id');
    }
}
