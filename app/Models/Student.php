<?php

namespace App\Models;

use App\Models\Concerns\GeneratesCodes;
use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use GeneratesCodes, LogsActivity;

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'student_code',
        'user_id',
        'department_id',
        'academic_year_id',
        'semester_id',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'status',
    ];

    protected static function booted(): void
    {
        static::creating(function (Student $student): void {
            if (blank($student->student_code)) {
                $student->student_code = static::nextCode('student_code', 'STU');
            }
        });
    }

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'student_id', 'student_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'academic_year_id');
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'semester_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id', 'student_id');
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(StudentProgress::class, 'student_id', 'student_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'student_id', 'student_id');
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(StudentPromotion::class, 'student_id', 'student_id');
    }

    public function courses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id')
            ->withPivot(['class_room_id', 'academic_year_id', 'semester_id', 'status', 'note'])
            ->withTimestamps();
    }

    public function currentCourses()
    {
        return Course::query()->availableToStudent($this);
    }

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(
            Schedule::class,
            'schedule_students',
            'student_id',
            'schedule_id',
            'student_id',
            'id'
        )->withTimestamps();
    }
}
