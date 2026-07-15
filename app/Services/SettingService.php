<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public static function all(): Collection
    {
        return Cache::rememberForever('frontend_settings.all', fn () => Setting::query()->get()->keyBy('key'));
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = self::all()->get($key);

        return filled($setting?->value) ? $setting->value : $default;
    }

    public static function group(string $group): array
    {
        return self::all()
            ->where('group', $group)
            ->mapWithKeys(fn (Setting $setting): array => [$setting->key => $setting->value])
            ->all();
    }

    public static function forgetCache(): void
    {
        Cache::forget('frontend_settings.all');
    }
}
