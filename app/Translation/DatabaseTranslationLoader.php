<?php

namespace App\Translation;

use App\Services\Localization\LocalizationService;
use Illuminate\Contracts\Translation\Loader;

class DatabaseTranslationLoader implements Loader
{
    public function __construct(
        private readonly Loader $loader,
        private readonly LocalizationService $localization,
    ) {
    }

    public function load($locale, $group, $namespace = null): array
    {
        $fileTranslations = $this->loader->load($locale, $group, $namespace);

        if ($namespace !== null && $namespace !== '*') {
            return $fileTranslations;
        }

        return array_replace_recursive(
            $fileTranslations,
            $this->localization->loadTranslations($locale, $group),
        );
    }

    public function addNamespace($namespace, $hint): void
    {
        $this->loader->addNamespace($namespace, $hint);
    }

    public function addJsonPath($path): void
    {
        $this->loader->addJsonPath($path);
    }

    public function namespaces(): array
    {
        return $this->loader->namespaces();
    }
}
