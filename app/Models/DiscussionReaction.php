<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionReaction extends Model
{
    protected $primaryKey = 'discussion_reaction_id';

    protected $fillable = [
        'user_id',
        'discussion_post_id',
        'discussion_comment_id',
        'type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(DiscussionPost::class, 'discussion_post_id', 'discussion_post_id');
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(DiscussionComment::class, 'discussion_comment_id', 'discussion_comment_id');
    }
}
