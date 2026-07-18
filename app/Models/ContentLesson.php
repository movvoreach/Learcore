<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentLesson extends Model
{
    use LogsActivity, SoftDeletes;

    protected $primaryKey = 'content_lesson_id';

    protected $fillable = [
        'course_id',
        'course_module_id',
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

    protected static function booted(): void
    {
        static::creating(function (ContentLesson $lesson): void {
            if ($lesson->course_module_id) {
                $module = CourseModule::query()->find($lesson->course_module_id);

                if ($module) {
                    $lesson->course_id = $lesson->course_id ?: $module->course_id;
                    $lesson->module_number = $module->module_number;
                    $lesson->module_title = $module->title;
                }
            }

            if (! $lesson->position) {
                $query = static::query();

                if ($lesson->course_module_id) {
                    $query->where('course_module_id', $lesson->course_module_id);
                } else {
                    $query
                        ->where('course_id', $lesson->course_id)
                        ->where('module_number', $lesson->module_number ?: 1);
                }

                $lesson->position = ((int) $query->max('position')) + 1;
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id', 'course_module_id');
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
