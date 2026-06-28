<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait GeneratesCodes
{
    protected static function nextCode(string $column, string $prefix, int $padding = 6): string
    {
        $prefix = Str::upper($prefix);

        $nextNumber = ((int) static::query()
            ->where($column, 'like', "{$prefix}-%")
            ->pluck($column)
            ->map(function (string $code): int {
                $number = Str::afterLast($code, '-');

                return ctype_digit($number) ? (int) $number : 0;
            })
            ->max()) + 1;

        do {
            $code = sprintf("%s-%0{$padding}d", $prefix, $nextNumber++);
        } while (static::query()->where($column, $code)->exists());

        return $code;
    }
}
