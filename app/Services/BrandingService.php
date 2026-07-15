<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class BrandingService
{
    public static function data(): array
    {
        $logo = SettingService::get('logo', 'backend/dist/img/logo.png');
        $headerLogo = SettingService::get('header_logo', $logo);
        $footerLogo = SettingService::get('footer_logo', $logo);
        $favicon = SettingService::get('favicon', 'backend/dist/img/spilogo.png');

        return [
            'site_name' => SettingService::get('site_name', 'LearnCore LMS'),
            'short_name' => SettingService::get('short_name', 'LearnCore'),
            'logo' => $logo,
            'logo_url' => self::assetUrl($logo),
            'dark_logo_url' => self::assetUrl(SettingService::get('dark_logo', $logo)),
            'favicon_url' => self::assetUrl($favicon),
            'header_logo_url' => self::assetUrl($headerLogo),
            'footer_logo_url' => self::assetUrl($footerLogo),
            'hero_image_url' => self::assetUrl(SettingService::get('hero_image')),
            'primary_color' => SettingService::get('primary_color', '#ff5b00'),
            'secondary_color' => SettingService::get('secondary_color', '#2563eb'),
        ];
    }

    public static function assetUrl(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }

        if (str_starts_with($path, 'backend/') || str_starts_with($path, 'frontend/') || str_starts_with($path, 'Icons/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }
}
