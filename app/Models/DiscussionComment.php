<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscussionComment extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'discussion_comment_id';

    protected $fillable = [
        'discussion_post_id',
        'parent_comment_id',
        'user_id',
        'body',
        'image_path',
        'status',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(DiscussionPost::class, 'discussion_post_id', 'discussion_post_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_comment_id', 'discussion_comment_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_comment_id', 'discussion_comment_id');
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(DiscussionReaction::class, 'discussion_comment_id', 'discussion_comment_id');
    }

    public function publishedReplies(): HasMany
    {
        return $this->replies()->published();
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
