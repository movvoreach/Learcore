<?php

namespace App\Models;

use App\Models\Concerns\GeneratesCodes;
use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use GeneratesCodes, LogsActivity;

    protected $primaryKey = 'faculty_id';

    protected $fillable = [
        'faculty_code',
        'faculty_name',
    ];

    public static function generateNextFacultyCode(): string
    {
        $prefix = 'FC';
        $padding = 3;

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $castType = $driver === 'pgsql' || $driver === 'sqlite' ? 'INTEGER' : 'UNSIGNED';

        // Use DB MAX() to find the highest existing number
        $maxCode = static::query()
            ->where('faculty_code', 'like', "{$prefix}%")
            ->max(\Illuminate\Support\Facades\DB::raw("CAST(SUBSTRING(faculty_code, " . (strlen($prefix) + 1) . ") AS {$castType})"));

        $nextNumber = ((int) $maxCode) + 1;

        do {
            $code = sprintf("%s%0{$padding}d", $prefix, $nextNumber++);
        } while (static::query()->where('faculty_code', $code)->exists());

        return $code;
    }

    protected static function booted(): void
    {
        static::creating(function (Faculty $faculty): void {
            if (blank($faculty->faculty_code)) {
                $faculty->faculty_code = static::generateNextFacultyCode();
            }
        });
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'faculty_id', 'faculty_id');
    }
}
