<?php

namespace App\Services;

use App\Models\FrontendPage;

class PageService
{
    public static function publishedBySlug(string $slug): ?FrontendPage
    {
        return FrontendPage::query()->published()->where('slug', $slug)->first();
    }

    public static function url(FrontendPage $page): string
    {
        return route('frontend.pages.show', $page->slug);
    }
}
