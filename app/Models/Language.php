<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use LogicException;

class Language extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'native_name',
        'code',
        'locale',
        'flag',
        'is_default',
        'is_active',
        'direction',
        'sort_order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Language $language): void {
            if ($language->is_default) {
                $language->is_active = true;
            }
        });

        static::saved(function (Language $language): void {
            if ($language->is_default) {
                Language::query()->whereKeyNot($language->getKey())->update(['is_default' => false]);
            }

            Cache::forget('localization.languages.active');
        });

        static::deleting(function (Language $language): void {
            if ($language->is_default) {
                throw new LogicException('The default language cannot be deleted.');
            }
        });

        static::deleted(fn (): bool => Cache::forget('localization.languages.active'));
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function flagUrl(): ?string
    {
        if (! $this->flag) {
            return null;
        }

        if (str_starts_with($this->flag, 'http')) {
            return $this->flag;
        }

        if (str_starts_with($this->flag, 'backend/') || str_starts_with($this->flag, 'Icons/')) {
            return asset($this->flag);
        }

        return asset('storage/'.$this->flag);
    }
}
