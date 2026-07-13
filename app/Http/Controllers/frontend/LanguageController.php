<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Services\Localization\LocalizationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $language = app(LocalizationService::class)->switchLocale($locale, $request);

        abort_if(! $language, 404);

        return redirect()->back();
    }
}
