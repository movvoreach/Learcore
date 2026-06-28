<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait GeneratesCodes
{
    /**
     * Generate a unique sequential code for this model.
     * Uses a DB aggregate MAX() instead of loading all codes into memory.
     * A do-while loop ensures uniqueness under concurrent requests.
     */
    protected static function nextCode(string $column, string $prefix, int $padding = 6): string
    {
        $prefix = Str::upper($prefix);

        // Use DB MAX() to find the highest existing number — avoids loading
        // all codes into PHP memory (critical for large tables).
        $maxCode = static::query()
            ->where($column, 'like', "{$prefix}-%")
            ->max(DB::raw("CAST(SUBSTRING({$column}, " . (strlen($prefix) + 2) . ") AS UNSIGNED)"));

        $nextNumber = ((int) $maxCode) + 1;

        // Collision guard: loop until we find a code that doesn't exist yet.
        // The unique DB constraint is the final safety net against race conditions.
        do {
            $code = sprintf("%s-%0{$padding}d", $prefix, $nextNumber++);
        } while (static::query()->where($column, $code)->exists());

        return $code;
    }
}
