<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentPromotion extends Model
{
    protected $fillable = [
        'student_id',
        'from_department_id',
        'from_year_id',
        'from_semester_id',
        'to_year_id',
        'to_semester_id',
        'promoted_at',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'promoted_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function fromDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'from_department_id', 'department_id');
    }

    public function fromYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'from_year_id', 'academic_year_id');
    }

    public function fromSemester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'from_semester_id', 'semester_id');
    }

    public function toYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'to_year_id', 'academic_year_id');
    }

    public function toSemester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'to_semester_id', 'semester_id');
    }
}
