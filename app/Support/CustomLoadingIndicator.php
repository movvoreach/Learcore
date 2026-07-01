<?php

namespace App\Support;

use Filament\Support\Contracts\LoadingIndicator;
use Illuminate\View\ComponentAttributeBag;

class CustomLoadingIndicator implements LoadingIndicator
{
    public function toHtml(?ComponentAttributeBag $attributes = null): string
    {
        $classes = 'fa fa-spinner fa-spin';
        if ($attributes && $attributes->has('class')) {
            $classes .= ' ' . $attributes->get('class');
            $attributes = $attributes->except('class');
        }

        return '<i class="' . $classes . '" ' . ($attributes ? $attributes->toHtml() : '') . '></i>';
    }
}
