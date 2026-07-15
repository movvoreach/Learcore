<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentResource extends Model
{
    use LogsActivity;

    protected $primaryKey = 'content_resource_id';

    protected $fillable = [
        'content_lesson_id',
        'content_chapter_id',
        'title',
        'description',
        'file_path',
        'external_url',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
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
