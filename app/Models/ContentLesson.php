<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentLesson extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'content_lesson_id';

    protected $fillable = [
        'course_id',
        'module_number',
        'module_title',
        'title',
        'slug',
        'content_type',
        'summary',
        'body',
        'external_url',
        'file_path',
        'video_url',
        'duration_minutes',
        'position',
        'available_from',
        'available_until',
        'completion_required',
        'visibility',
        'max_score',
        'passing_score',
        'allow_comments',
        'metadata',
        'is_published',
    ];

    protected $casts = [
        'available_from' => 'datetime',
        'available_until' => 'datetime',
        'completion_required' => 'boolean',
        'allow_comments' => 'boolean',
        'metadata' => 'array',
        'is_published' => 'boolean',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function scopeAvailableToStudent(Builder $query, Student $student): Builder
    {
        return $query->whereHas('course', fn (Builder $courseQuery): Builder => $courseQuery->availableToStudent($student));
    }

    public function scopePublishedForStudents(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->where(function (Builder $query): void {
                $query
                    ->where('visibility', 'visible')
                    ->orWhere(function (Builder $query): void {
                        $query
                            ->where('visibility', 'scheduled')
                            ->where(function (Builder $query): void {
                                $query->whereNull('available_from')->orWhere('available_from', '<=', now());
                            })
                            ->where(function (Builder $query): void {
                                $query->whereNull('available_until')->orWhere('available_until', '>=', now());
                            });
                    });
            });
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(ContentChapter::class, 'content_lesson_id', 'content_lesson_id');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(ContentVideo::class, 'content_lesson_id', 'content_lesson_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ContentDocument::class, 'content_lesson_id', 'content_lesson_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(ContentAssignment::class, 'content_lesson_id', 'content_lesson_id');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'content_lesson_id', 'content_lesson_id');
    }

    public function assessmentQuestions(): HasMany
    {
        return $this->hasMany(AssessmentQuestion::class, 'content_lesson_id', 'content_lesson_id');
    }

    public function resources(): HasMany
    {
        return $this->hasMany(ContentResource::class, 'content_lesson_id', 'content_lesson_id');
    }

    public function discussionPosts(): HasMany
    {
        return $this->hasMany(DiscussionPost::class, 'content_lesson_id', 'content_lesson_id');
    }
}
