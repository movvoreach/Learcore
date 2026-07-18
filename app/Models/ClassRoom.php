<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    use LogsActivity;

    protected $primaryKey = 'class_room_id';

    protected $fillable = [
        'course_id',
        'academic_year_id',
        'class_code',
        'class_name',
        'table',
        'status',
        'room',
        'capacity',
    ];

    protected static function booted(): void
    {
        static::creating(function (ClassRoom $classRoom): void {
            if (! $classRoom->class_code) {
                $nextId = ((int) static::query()->max('class_room_id')) + 1;
                $classRoom->class_code = 'CLS-'.str_pad((string) $nextId, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'academic_year_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'class_room_id', 'class_room_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'class_room_id', 'class_room_id');
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(StudentProgress::class, 'class_room_id', 'class_room_id');
    }

    public function courseAssignments(): HasMany
    {
        return $this->hasMany(CourseAssignment::class, 'class_room_id', 'class_room_id');
    }

    public function teacherSchedules(): HasMany
    {
        return $this->hasMany(TeacherSchedule::class, 'class_room_id', 'class_room_id');
    }
}
