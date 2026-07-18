<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $primaryKey = 'certificate_id';

    protected $fillable = [
        'student_id',
        'course_id',
        'course_completion_request_id',
        'certificate_no',
        'issued_date',
        'issued_by',
        'issued_at',
        'status',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'issued_date' => 'date',
            'issued_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function completionRequest(): BelongsTo
    {
        return $this->belongsTo(CourseCompletionRequest::class, 'course_completion_request_id');
    }

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
