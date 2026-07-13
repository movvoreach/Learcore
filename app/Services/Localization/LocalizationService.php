<?php

namespace App\Services\Localization;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LocalizationService
{
    public const SESSION_KEY = 'learning_locale';

    public function activeLanguages(): Collection
    {
        if (! Schema::hasTable('languages')) {
            return collect();
        }

        return Cache::rememberForever('localization.languages.active', fn () => Language::query()
            ->active()
            ->ordered()
            ->get());
    }

    public function defaultLanguage(): ?Language
    {
        if (! Schema::hasTable('languages')) {
            return null;
        }

        return Language::query()->where('is_default', true)->first()
            ?? Language::query()->active()->ordered()->first()
            ?? Language::query()->ordered()->first();
    }

    public function currentLanguage(): ?Language
    {
        $locale = App::getLocale();

        return $this->activeLanguages()->firstWhere('locale', $locale)
            ?? $this->activeLanguages()->firstWhere('code', $locale)
            ?? $this->defaultLanguage();
    }

    public function resolveLocale(Request $request): string
    {
        $active = $this->activeLanguages();
        $default = $this->defaultLanguage();
        $fallback = $default?->locale ?? config('app.fallback_locale', 'en');

        $sessionLocale = $request->session()->get(self::SESSION_KEY);
        if ($this->isActiveLocale($sessionLocale)) {
            return $sessionLocale;
        }

        $browserLocale = $this->browserLocale($request);
        if ($browserLocale) {
            $request->session()->put(self::SESSION_KEY, $browserLocale);

            return $browserLocale;
        }

        if ($active->isNotEmpty() && ! $this->isActiveLocale($fallback)) {
            return (string) $active->first()->locale;
        }

        return $fallback;
    }

    public function switchLocale(string $locale, Request $request): ?Language
    {
        $language = Language::query()
            ->active()
            ->where(fn ($query) => $query->where('locale', $locale)->orWhere('code', $locale))
            ->first();

        if (! $language) {
            return null;
        }

        $request->session()->put(self::SESSION_KEY, $language->locale);
        App::setLocale($language->locale);

        return $language;
    }

    public function setDefault(Language $language): void
    {
        DB::transaction(function () use ($language): void {
            Language::query()->whereKeyNot($language->getKey())->update(['is_default' => false]);
            $language->forceFill(['is_default' => true, 'is_active' => true])->save();
        });

        $this->clearCache();
    }

    public function duplicate(Language $source, array $attributes): Language
    {
        return DB::transaction(function () use ($source, $attributes): Language {
            $language = Language::query()->create([
                ...$attributes,
                'is_default' => false,
                'is_active' => $attributes['is_active'] ?? false,
            ]);

            $source->translations()
                ->select(['group', 'key', 'value'])
                ->orderBy('group')
                ->orderBy('key')
                ->each(fn (Translation $translation) => $language->translations()->create($translation->only(['group', 'key', 'value'])));

            $this->clearCache();

            return $language;
        });
    }

    public function loadTranslations(string $locale, string $group): array
    {
        if (! Schema::hasTable('languages') || ! Schema::hasTable('translations')) {
            return [];
        }

        return Cache::rememberForever($this->cacheKey($locale, $group), function () use ($locale, $group): array {
            $language = Language::query()
                ->where(fn ($query) => $query->where('locale', $locale)->orWhere('code', $locale))
                ->first();

            if (! $language) {
                return [];
            }

            return Translation::query()
                ->where('language_id', $language->id)
                ->where('group', $group)
                ->pluck('value', 'key')
                ->mapWithKeys(fn (?string $value, string $key): array => [$key => $value ?? ''])
                ->undot()
                ->all();
        });
    }

    public function importJson(Language $language, array $payload, ?string $group = null): int
    {
        $rows = $this->flattenPayload($payload, $group);
        $count = 0;

        DB::transaction(function () use ($language, $rows, &$count): void {
            foreach ($rows as $row) {
                Translation::query()->updateOrCreate(
                    [
                        'language_id' => $language->id,
                        'group' => $row['group'],
                        'key' => $row['key'],
                    ],
                    ['value' => $row['value']],
                );

                $count++;
            }
        });

        $this->clearCache();

        return $count;
    }

    public function exportJson(Language $language): array
    {
        return $language->translations()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group')
            ->map(fn (Collection $translations): array => $translations
                ->mapWithKeys(fn (Translation $translation): array => [$translation->key => $translation->value])
                ->undot()
                ->all())
            ->all();
    }

    public function missingTranslations(?Language $language = null): Collection
    {
        if (! Schema::hasTable('languages') || ! Schema::hasTable('translations')) {
            return collect();
        }

        $default = $this->defaultLanguage();

        if (! $default) {
            return collect();
        }

        $baseKeys = Translation::query()
            ->where('language_id', $default->id)
            ->select(['group', 'key'])
            ->get();

        $languages = $language ? collect([$language]) : Language::query()->ordered()->get();

        return $languages->flatMap(function (Language $target) use ($baseKeys): Collection {
            $existing = $target->translations()
                ->select(['group', 'key', 'value'])
                ->get()
                ->keyBy(fn (Translation $translation): string => $translation->group.'.'.$translation->key);

            return $baseKeys
                ->reject(fn (Translation $base): bool => filled($existing->get($base->group.'.'.$base->key)?->value))
                ->map(fn (Translation $base): array => [
                    'language' => $target->native_name,
                    'locale' => $target->locale,
                    'group' => $base->group,
                    'key' => $base->key,
                ]);
        })->values();
    }

    public function completionPercentage(?Language $language = null): float
    {
        if (! Schema::hasTable('languages') || ! Schema::hasTable('translations')) {
            return 0.0;
        }

        $default = $this->defaultLanguage();
        $target = $language ?? $this->currentLanguage();

        if (! $default || ! $target) {
            return 0.0;
        }

        $total = $default->translations()->count();
        if ($total === 0) {
            return 100.0;
        }

        $filled = $target->translations()->whereNotNull('value')->where('value', '!=', '')->count();

        return round(min(100, ($filled / $total) * 100), 1);
    }

    public function clearCache(): void
    {
        Cache::forget('localization.languages.active');

        if (! Schema::hasTable('languages') || ! Schema::hasTable('translations')) {
            return;
        }

        Language::query()->pluck('locale')->each(function (string $locale): void {
            Translation::query()
                ->select('group')
                ->distinct()
                ->pluck('group')
                ->each(fn (string $group): bool => Cache::forget($this->cacheKey($locale, $group)));
        });
    }

    public function isActiveLocale(?string $locale): bool
    {
        if (! $locale) {
            return false;
        }

        return $this->activeLanguages()->contains(fn (Language $language): bool => in_array($locale, [$language->locale, $language->code], true));
    }

    private function browserLocale(Request $request): ?string
    {
        $header = $request->server('HTTP_ACCEPT_LANGUAGE');
        if (! is_string($header) || $header === '') {
            return null;
        }

        foreach (explode(',', $header) as $part) {
            $candidate = strtolower(str_replace('_', '-', trim(explode(';', $part)[0])));
            $primary = explode('-', $candidate)[0];

            $language = $this->activeLanguages()->first(
                fn (Language $language): bool => strtolower($language->locale) === $candidate || strtolower($language->code) === $primary,
            );

            if ($language) {
                return $language->locale;
            }
        }

        return null;
    }

    private function cacheKey(string $locale, string $group): string
    {
        return "localization.translations.{$locale}.{$group}";
    }

    private function flattenPayload(array $payload, ?string $group): array
    {
        if ($group) {
            return collect($payload)->dot()
                ->map(fn (mixed $value, string $key): array => [
                    'group' => $group,
                    'key' => $key,
                    'value' => is_scalar($value) || $value === null ? (string) $value : json_encode($value),
                ])
                ->values()
                ->all();
        }

        return collect($payload)->flatMap(function (mixed $values, string $payloadGroup): array {
            if (! is_array($values)) {
                return [[
                    'group' => '*',
                    'key' => $payloadGroup,
                    'value' => is_scalar($values) || $values === null ? (string) $values : json_encode($values),
                ]];
            }

            return collect($values)->dot()
                ->map(fn (mixed $value, string $key): array => [
                    'group' => $payloadGroup,
                    'key' => $key,
                    'value' => is_scalar($value) || $value === null ? (string) $value : json_encode($value),
                ])
                ->values()
                ->all();
        })->values()->all();
    }
}
