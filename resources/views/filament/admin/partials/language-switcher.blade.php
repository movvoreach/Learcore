@php
    $localization = app(\App\Services\Localization\LocalizationService::class);
    $languages = $activeLanguages ?? $localization->activeLanguages();
    $current = $currentLanguage ?? $localization->currentLanguage();
@endphp

@if($languages->isNotEmpty())
    <div class="lc-admin-language-switcher">
        <label class="sr-only" for="lc-admin-language-select">Language</label>
        <div class="lc-admin-language-switcher__field">
            @if($current?->flagUrl())
                <img src="{{ $current->flagUrl() }}" alt="" class="lc-admin-language-switcher__flag">
            @else
                <x-filament::icon icon="heroicon-m-language" class="lc-admin-language-switcher__icon" />
            @endif

            <select
                id="lc-admin-language-select"
                class="lc-admin-language-switcher__select"
                aria-label="Language"
                onchange="if (this.value) window.location.href = this.value"
            >
                @foreach($languages as $language)
                    <option
                        value="{{ route('admin.language', $language->locale) }}"
                        @selected(app()->getLocale() === $language->locale)
                    >
                        {{ $language->native_name }} ({{ $language->code }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    @once
        <style>
            .lc-admin-language-switcher {
                display: flex;
                align-items: center;
                margin-inline-start: .5rem;
                margin-inline-end: .5rem;
            }

            .lc-admin-language-switcher__field {
                height: 2.25rem;
                display: inline-flex;
                align-items: center;
                gap: .45rem;
                padding-inline-start: .65rem;
                border: 1px solid rgb(209 213 219);
                border-radius: .5rem;
                background: rgb(255 255 255);
                color: rgb(55 65 81);
            }

            .dark .lc-admin-language-switcher__field {
                border-color: rgb(75 85 99);
                background: rgb(17 24 39);
                color: rgb(229 231 235);
            }

            .lc-admin-language-switcher__flag {
                width: 1.1rem;
                height: 1.1rem;
                border-radius: 9999px;
                object-fit: cover;
                flex: 0 0 auto;
            }

            .lc-admin-language-switcher__icon {
                width: 1rem;
                height: 1rem;
                color: rgb(107 114 128);
                flex: 0 0 auto;
            }

            .lc-admin-language-switcher__select {
                height: 2.125rem;
                max-width: 9.5rem;
                border: 0;
                background: transparent;
                color: inherit;
                font-size: .875rem;
                line-height: 1.25rem;
                outline: 0;
                padding-inline-end: .55rem;
            }

            .lc-admin-language-switcher__select:focus {
                box-shadow: none;
            }

            @media (max-width: 767px) {
                .lc-admin-language-switcher {
                    display: none;
                }
            }
        </style>
    @endonce
@endif
