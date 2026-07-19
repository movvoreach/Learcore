<?php

namespace App\Models;

use App\Models\Concerns\GeneratesCodes;
use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use GeneratesCodes, LogsActivity;

    protected $primaryKey = 'department_id';

    protected $fillable = [
        'faculty_id',
        'department_code',
        'department_name',
        'deans',
    ];

    public static function generateNextDepartmentCode(): string
    {
        $prefix = 'DEP';
        $padding = 3;

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $castType = $driver === 'pgsql' || $driver === 'sqlite' ? 'INTEGER' : 'UNSIGNED';

        // Use DB MAX() to find the highest existing number
        $maxCode = static::query()
            ->where('department_code', 'like', "{$prefix}%")
            ->max(\Illuminate\Support\Facades\DB::raw("CAST(SUBSTRING(department_code, " . (strlen($prefix) + 1) . ") AS {$castType})"));

        $nextNumber = ((int) $maxCode) + 1;

        do {
            $code = sprintf("%s%0{$padding}d", $prefix, $nextNumber++);
        } while (static::query()->where('department_code', $code)->exists());

        return $code;
    }

    protected static function booted(): void
    {
        static::creating(function (Department $department): void {
            if (blank($department->department_code)) {
                $department->department_code = static::generateNextDepartmentCode();
            }
        });
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'faculty_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'department_id', 'department_id');
    }
}
