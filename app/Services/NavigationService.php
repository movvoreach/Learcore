<?php

namespace App\Services;

use App\Models\NavigationGroup;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class NavigationService
{
    public static function menus(): EloquentCollection
    {
        return NavigationGroup::query()
            ->where('is_active', true)
            ->with([
                'rootItems' => fn ($query) => $query
                    ->where('is_active', true)
                    ->with(['page', 'childrenRecursive']),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }
}
