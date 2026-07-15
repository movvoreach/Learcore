<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavigationItem extends Model
{
    use LogsActivity;

    protected $fillable = [
        'navigation_group_id',
        'parent_id',
        'page_id',
        'title',
        'slug',
        'url',
        'icon',
        'target',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(NavigationGroup::class, 'navigation_group_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(FrontendPage::class, 'page_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order')->orderBy('title');
    }

    public function activeChildren(): HasMany
    {
        return $this->children()->where('is_active', true);
    }

    public function childrenRecursive(): HasMany
    {
        return $this->activeChildren()->with(['page', 'childrenRecursive']);
    }

    public function resolvedUrl(): string
    {
        if ($this->page) {
            return route('frontend.pages.show', $this->page->slug);
        }

        return filled($this->url) ? (string) $this->url : '#';
    }

    public function translatedTitle(): string
    {
        if (! filled($this->slug)) {
            return $this->title;
        }

        $key = "navigation.items.{$this->slug}";
        $translation = __($key);

        return $translation === $key ? $this->title : $translation;
    }
}
