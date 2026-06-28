<?php

namespace App\Models;

use App\Models\Concerns\GeneratesCodes;
use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use GeneratesCodes, LogsActivity;

    protected $primaryKey = 'teacher_id';

    protected $fillable = [
        'user_id',
        'department_id',
        'employment_type',
        'teacher_code',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'email',
        'specialization',
        'hire_date',
        'status',
        'address',
    ];

    protected static function booted(): void
    {
        static::creating(function (Teacher $teacher): void {
            if (blank($teacher->teacher_code)) {
                $teacher->teacher_code = static::nextCode('teacher_code', 'TCH');
            }
        });
    }

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
        ];
    }

    public function courseAssignments(): HasMany
    {
        return $this->hasMany(CourseAssignment::class, 'teacher_id', 'teacher_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(TeacherSchedule::class, 'teacher_id', 'teacher_id');
    }
}
