@php
    $learningLocale = session('learning_locale', 'km');

    $learningTexts = [
        'km' => [
            'brand' => 'ប្រព័ន្ធគ្រប់គ្រងកម្មវិធីសិក្សា',
            'home' => 'ទំព័រដើម',
            'courses' => 'មុខវិជ្ជាសិក្សា',
            'about' => 'អំពីយើង',
            'dashboard' => 'ផ្ទាំងគ្រប់គ្រង',
            'profile' => 'គណនីផ្ទាល់ខ្លួន',
            'logout' => 'ចាកចេញ',
            'login' => 'ចូលប្រើប្រាស់',
            'register' => 'ចុះឈ្មោះ',
            'language' => 'ភាសា',
            'current_language' => 'ខ្មែរ',
            'search_placeholder' => 'ស្វែងរកមុខវិជ្ជា...',
            'search' => 'ស្វែងរក',
        ],

        'en' => [
            'brand' => 'Learning Management System',
            'home' => 'Home',
            'courses' => 'Courses',
            'about' => 'About',
            'dashboard' => 'Dashboard',
            'profile' => 'My Profile',
            'logout' => 'Logout',
            'login' => 'Login',
            'register' => 'Register',
            'language' => 'Language',
            'current_language' => 'English',
            'search_placeholder' => 'Search courses...',
            'search' => 'Search',
        ],
    ];

    $learningText = $learningTexts[$learningLocale] ?? $learningTexts['km'];
    $registerUrl = \Illuminate\Support\Facades\Route::has('register') ? route('register') : route('login');
@endphp

<nav class="learning-navbar fixed-top">
    <div class="learning-navbar__inner">

        {{-- Brand --}}
        <a
            class="learning-brand"
            href="{{ route('dashboard') }}"
            aria-label="Learning Management System home"
        >
            <span class="learning-brand__icon">
                <i class="fas fa-book-open"></i>
            </span>

            <span class="learning-brand__text">
                <small>{{ $learningText['brand'] }}</small>
            </span>
        </a>

        {{-- Navigation --}}
        <div
            class="learning-nav d-none d-lg-flex"
            aria-label="Primary navigation"
        >
            <a
                href="{{ route('dashboard') }}"
                class="learning-nav__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}"
            >
                {{ $learningText['home'] }}
            </a>

            <a
                href="{{ route('frontend.about') }}"
                class="learning-nav__link {{ request()->routeIs('frontend.about') ? 'is-active' : '' }}"
            >
                {{ $learningText['about'] }}
            </a>

            <a
                href="{{ route('frontend.courses') }}"
                class="learning-nav__link {{ request()->routeIs('frontend.courses') ? 'is-active' : '' }}"
            >
                {{ $learningText['courses'] }}
            </a>
        </div>

        {{-- Search --}}
        <form
            action="{{ route('frontend.courses') }}"
            method="GET"
            class="learning-search d-none d-md-flex"
            role="search"
        >
            <div class="learning-search__group">
                <i class="fas fa-search learning-search__icon"></i>

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    class="learning-search__input"
                    placeholder="{{ $learningText['search_placeholder'] }}"
                    aria-label="{{ $learningText['search'] }}"
                    autocomplete="off"
                >

                @if(request()->filled('search'))
                    <a
                        href="{{ route('frontend.courses') }}"
                        class="learning-search__clear"
                        aria-label="Clear search"
                    >
                        <i class="fas fa-times"></i>
                    </a>
                @endif

                <button
                    type="submit"
                    class="learning-search__button"
                    aria-label="{{ $learningText['search'] }}"
                >
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        {{-- Actions --}}
        <div class="learning-actions">
            {{-- Language --}}
            <div class="learning-language dropdown">
                <button
                    class="learning-language__button dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <i class="fas fa-globe"></i>
                    <span class="d-none d-xl-inline">
                        {{ $learningText['current_language'] }}
                    </span>
                </button>

                <div class="dropdown-menu dropdown-menu-end">
                    <a
                        href="{{ route('frontend.language', 'km') }}"
                        class="dropdown-item {{ $learningLocale === 'km' ? 'active' : '' }}"
                    >
                        ខ្មែរ
                    </a>

                    <a
                        href="{{ route('frontend.language', 'en') }}"
                        class="dropdown-item {{ $learningLocale === 'en' ? 'active' : '' }}"
                    >
                        English
                    </a>
                </div>
            </div>

            @auth
                {{-- User --}}
                <div class="learning-user dropdown">
                    <button
                        class="learning-user__button dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <img
                            src="{{ Auth::user()->avatar ?: asset('backend/dist/img/avatar.png') }}"
                            alt="{{ Auth::user()->name }}"
                        >

                        <span class="d-none d-xl-inline">
                            {{ Auth::user()->name }}
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a
                            href="{{ route('filament.admin.pages.dashboard') }}"
                            class="dropdown-item"
                        >
                            <i class="fas fa-user-shield me-2"></i>
                            {{ $learningText['dashboard'] }}
                        </a>

                        <div class="dropdown-divider"></div>

                        <a
                            href="{{ route('filament.admin.pages.my-profile') }}"
                            class="dropdown-item"
                        >
                            <i class="fas fa-user me-2"></i>
                            {{ $learningText['profile'] }}
                        </a>

                        <div class="dropdown-divider"></div>

                        <a
                            href="#"
                            class="dropdown-item text-danger"
                            onclick="
                                event.preventDefault();
                                document.getElementById('logout-form').submit();
                            "
                        >
                            <i class="fas fa-sign-out-alt me-2"></i>
                            {{ $learningText['logout'] }}
                        </a>

                        <form
                            id="logout-form"
                            action="{{ route('logout') }}"
                            method="POST"
                            class="d-none"
                        >
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <a
                    href="{{ route('login') }}"
                    class="learning-login"
                >
                    {{ $learningText['login'] }}
                </a>

                <a
                    href="{{ $registerUrl }}"
                    class="learning-cta"
                >
                    {{ $learningText['register'] }}
                </a>
            @endauth
        </div>
    </div>

    {{-- Mobile navigation --}}
    <div class="learning-nav learning-nav--mobile d-lg-none" aria-label="Mobile navigation">
        <a
            href="{{ route('dashboard') }}"
            class="learning-nav__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}"
        >
            <i class="fas fa-home"></i>
            <span>{{ $learningText['home'] }}</span>
        </a>

        <a
            href="{{ route('frontend.about') }}"
            class="learning-nav__link {{ request()->routeIs('frontend.about') ? 'is-active' : '' }}"
        >
            <i class="fas fa-info-circle"></i>
            <span>{{ $learningText['about'] }}</span>
        </a>

        <a
            href="{{ route('frontend.courses') }}"
            class="learning-nav__link {{ request()->routeIs('frontend.courses') ? 'is-active' : '' }}"
        >
            <i class="fas fa-graduation-cap"></i>
            <span>{{ $learningText['courses'] }}</span>
        </a>
    </div>

    {{-- Mobile search --}}
    <form
        action="{{ route('frontend.courses') }}"
        method="GET"
        class="learning-search learning-search--mobile d-md-none"
        role="search"
    >
        <div class="learning-search__group">
            <i class="fas fa-search learning-search__icon"></i>

            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                class="learning-search__input"
                placeholder="{{ $learningText['search_placeholder'] }}"
                aria-label="{{ $learningText['search'] }}"
            >

            @if(request()->filled('search'))
                <a
                    href="{{ route('frontend.courses') }}"
                    class="learning-search__clear"
                >
                    <i class="fas fa-times"></i>
                </a>
            @endif

            <button
                type="submit"
                class="learning-search__button"
            >
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</nav>
