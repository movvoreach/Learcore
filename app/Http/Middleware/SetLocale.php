<?php

namespace App\Http\Middleware;

use App\Services\Localization\LocalizationService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $localization = app(LocalizationService::class);
        $locale = $localization->resolveLocale($request);

        App::setLocale($locale);

        $language = $localization->currentLanguage();
        View::share('currentLanguage', $language);
        View::share('activeLanguages', $localization->activeLanguages());

        config([
            'app.locale' => $locale,
            'app.fallback_locale' => $localization->defaultLanguage()?->locale ?? config('app.fallback_locale'),
        ]);

        return $next($request);
    }
}
