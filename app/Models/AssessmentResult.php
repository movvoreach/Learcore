<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentResult extends Model
{
    protected $primaryKey = 'assessment_result_id';

    protected $fillable = [
        'student_id',
        'exam_id',
        'quiz_id',
        'assessment_type',
        'total_score',
        'passed',
        'rank',
        'published_at',
        'remarks',
    ];

    protected $casts = [
        'total_score' => 'decimal:2',
        'passed' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'exam_id');
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'quiz_id');
    }
}
