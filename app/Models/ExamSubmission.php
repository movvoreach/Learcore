<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSubmission extends Model
{
    use LogsActivity;

    protected $primaryKey = 'exam_submission_id';

    protected $fillable = [
        'exam_id',
        'student_id',
        'submitted_at',
        'attempt_no',
        'answers',
        'score',
        'status',
        'feedback',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'answers' => 'array',
        'score' => 'decimal:2',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'exam_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
