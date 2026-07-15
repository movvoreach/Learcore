<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentGrade extends Model
{
    use LogsActivity;

    protected $primaryKey = 'assessment_grade_id';

    protected $fillable = [
        'student_id',
        'exam_id',
        'quiz_id',
        'content_assignment_id',
        'graded_by',
        'score',
        'max_score',
        'grade',
        'graded_at',
        'remarks',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'graded_at' => 'datetime',
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

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(ContentAssignment::class, 'content_assignment_id', 'content_assignment_id');
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}
