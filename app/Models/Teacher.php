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
        'first_name_kh',
        'last_name_kh',
        'gender',
        'phone',
        'email',
        'specialization',
        'hire_date',
        'status',
        'address',
    ];

    public static function generateNextTeacherCode(): string
    {
        $prefix = 'TC';
        $padding = 3;

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $castType = $driver === 'pgsql' || $driver === 'sqlite' ? 'INTEGER' : 'UNSIGNED';

        // Use DB MAX() to find the highest existing number
        $maxCode = static::query()
            ->where('teacher_code', 'like', "{$prefix}%")
            ->max(\Illuminate\Support\Facades\DB::raw("CAST(SUBSTRING(teacher_code, " . (strlen($prefix) + 1) . ") AS {$castType})"));

        $nextNumber = ((int) $maxCode) + 1;

        do {
            $code = sprintf("%s%0{$padding}d", $prefix, $nextNumber++);
        } while (static::query()->where('teacher_code', $code)->exists());

        return $code;
    }

    protected static function booted(): void
    {
        static::creating(function (Teacher $teacher): void {
            if (blank($teacher->teacher_code)) {
                $teacher->teacher_code = static::generateNextTeacherCode();
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

    public function completionRequests(): HasMany
    {
        return $this->hasMany(CourseCompletionRequest::class, 'teacher_id', 'teacher_id');
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
