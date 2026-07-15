<?php

namespace App\Providers;

use App\Services\BrandingService;
use App\Services\NavigationService;
use App\Services\SettingService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('frontend.*', function ($view): void {
            $view->with([
                'branding' => BrandingService::data(),
                'navigationGroups' => NavigationService::menus(),
                'footerSettings' => SettingService::group('footer'),
                'contactSettings' => SettingService::group('contact'),
                'socialLinks' => SettingService::group('social_links'),
            ]);
        });
    }
}
