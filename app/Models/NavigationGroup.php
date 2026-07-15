<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavigationGroup extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(NavigationItem::class)->orderBy('sort_order')->orderBy('title');
    }

    public function rootItems(): HasMany
    {
        return $this->items()->whereNull('parent_id');
    }

    public function translatedName(): string
    {
        $key = "navigation.groups.{$this->slug}";
        $translation = __($key);

        return $translation === $key ? $this->name : $translation;
    }
}
