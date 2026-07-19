<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseCategory extends Model
{
    use LogsActivity;

    protected $primaryKey = 'course_category_id';

    protected $fillable = [
        'category_code',
        'category_name',
        'description',
    ];

    public static function generateNextCategoryCode(): string
    {
        $prefix = 'CC';
        $padding = 3;

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $castType = $driver === 'pgsql' || $driver === 'sqlite' ? 'INTEGER' : 'UNSIGNED';

        // Use DB MAX() to find the highest existing number
        $maxCode = static::query()
            ->where('category_code', 'like', "{$prefix}%")
            ->max(\Illuminate\Support\Facades\DB::raw("CAST(SUBSTRING(category_code, " . (strlen($prefix) + 1) . ") AS {$castType})"));

        $nextNumber = ((int) $maxCode) + 1;

        do {
            $code = sprintf("%s%0{$padding}d", $prefix, $nextNumber++);
        } while (static::query()->where('category_code', $code)->exists());

        return $code;
    }

    protected static function booted(): void
    {
        static::creating(function (CourseCategory $category): void {
            if (blank($category->category_code)) {
                $category->category_code = static::generateNextCategoryCode();
            }
        });
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'course_category_id', 'course_category_id');
    }
}
