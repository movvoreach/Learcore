<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $primaryKey = 'exam_id';

    protected $fillable = [
        'course_id',
        'subject_id',
        'title',
        'description',
        'exam_date',
        'start_time',
        'end_time',
        'duration_minutes',
        'total_score',
        'passing_score',
        'status',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'total_score' => 'decimal:2',
        'passing_score' => 'decimal:2',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

    public function candidates(): HasMany
    {
        return $this->hasMany(ExamCandidate::class, 'exam_id', 'exam_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(ExamSubmission::class, 'exam_id', 'exam_id');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(AssessmentGrade::class, 'exam_id', 'exam_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(AssessmentResult::class, 'exam_id', 'exam_id');
    }
}
