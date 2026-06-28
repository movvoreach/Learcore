<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProgress extends Model
{
    protected $table = 'student_progresses';

    protected $primaryKey = 'progress_id';

    protected $fillable = [
        'student_id',
        'course_id',
        'class_room_id',
        'progress_date',
        'progress_percent',
        'score',
        'status',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'progress_date' => 'date',
            'progress_percent' => 'decimal:2',
            'score' => 'decimal:2',
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

    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id', 'class_room_id');
    }
}
