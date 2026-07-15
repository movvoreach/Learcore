<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentChapter extends Model
{
    use LogsActivity;

    protected $primaryKey = 'content_chapter_id';

    protected $fillable = [
        'content_lesson_id',
        'title',
        'summary',
        'content',
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

    public function videos(): HasMany
    {
        return $this->hasMany(ContentVideo::class, 'content_chapter_id', 'content_chapter_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ContentDocument::class, 'content_chapter_id', 'content_chapter_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(ContentAssignment::class, 'content_chapter_id', 'content_chapter_id');
    }

    public function resources(): HasMany
    {
        return $this->hasMany(ContentResource::class, 'content_chapter_id', 'content_chapter_id');
    }
}
