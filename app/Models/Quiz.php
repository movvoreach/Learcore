<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $primaryKey = 'quiz_id';

    protected $fillable = [
        'content_lesson_id',
        'title',
        'instructions',
        'available_from',
        'available_until',
        'time_limit_minutes',
        'max_attempts',
        'passing_score',
        'is_published',
    ];

    protected $casts = [
        'available_from' => 'datetime',
        'available_until' => 'datetime',
        'passing_score' => 'decimal:2',
        'is_published' => 'boolean',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(ContentLesson::class, 'content_lesson_id', 'content_lesson_id');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(AssessmentGrade::class, 'quiz_id', 'quiz_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(AssessmentResult::class, 'quiz_id', 'quiz_id');
    }
}
