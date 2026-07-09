<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscussionPost extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'discussion_post_id';

    protected $fillable = [
        'course_id',
        'content_lesson_id',
        'user_id',
        'title',
        'body',
        'image_path',
        'status',
        'is_pinned',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(ContentLesson::class, 'content_lesson_id', 'content_lesson_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(DiscussionComment::class, 'discussion_post_id', 'discussion_post_id');
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(DiscussionReaction::class, 'discussion_post_id', 'discussion_post_id');
    }

    public function publishedComments(): HasMany
    {
        return $this->comments()->published();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
