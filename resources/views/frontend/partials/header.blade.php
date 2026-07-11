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
                <strong>LearnCore <span>LMS</span></strong>
                <small class="d-none d-md-inline-flex">{{ $learningText['brand'] }}</small>
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

        {{-- Actions & Search (MoEYS Style) --}}
        <div class="learning-actions d-flex align-items-center gap-3">
            {{-- Search (MoEYS Style Collapsible Form) --}}
            <div class="learning-search-simple simplesearchform my-auto d-none d-md-block">
                <div class="collapse" id="searchform-navbar">
                    <form autocomplete="off" action="{{ route('frontend.courses') }}" method="GET" class="form-inline searchform-navbar">
                        <div class="input-group">
                            <input type="text" class="form-control withclear" placeholder="{{ $learningText['search_placeholder'] }}" aria-label="{{ $learningText['search'] }}" name="search" value="{{ request('search') }}" autocomplete="off">
                            <a class="btn btn-close-toggle" data-bs-toggle="collapse" href="#searchform-navbar" role="button" aria-label="Close search">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </a>
                            <button type="submit" class="btn btn-submit" aria-label="Submit search">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <a class="btn btn-open" data-bs-toggle="collapse" href="#searchform-navbar" role="button" aria-expanded="false" aria-controls="searchform-navbar" aria-label="Toggle search">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </a>
            </div>

            {{-- Language (MoEYS Style Dropdown) --}}
            <div class="nav-item dropdown my-auto learning-language">
                <a href="#" class="nav-link dropdown-toggle my-auto d-flex align-items-center gap-2 text-decoration-none" role="button" id="langmenu0" data-bs-toggle="dropdown" aria-expanded="false" title="{{ $learningText['language'] }}">
                    <i class="fa fa-globe fa-lg"></i>
                    <span class="langdesc">{{ $learningLocale === 'km' ? 'ខ្មែរ (km)' : 'English (en)' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langmenu0">
                    <li>
                        <a title="ខ្មែរ (km)" class="dropdown-item {{ $learningLocale === 'km' ? 'active' : '' }}" href="{{ route('frontend.language', 'km') }}">ខ្មែរ (km)</a>
                    </li>
                    <li>
                        <a title="English (en)" class="dropdown-item {{ $learningLocale === 'en' ? 'active' : '' }}" href="{{ route('frontend.language', 'en') }}">English (en)</a>
                    </li>
                </ul>
            </div>

            {{-- User / Guest (MoEYS Style Dropdown) --}}
            @auth
                <div class="nav-item dropdown learning-user my-auto">
                    <a class="nav-link dropdown-toggle my-auto d-flex align-items-center gap-2 text-decoration-none" role="button" href="#" id="usermenu" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu" title="{{ Auth::user()->name }}">
                        <span class="d-none d-md-inline-block mx-1">{{ Auth::user()->name }}</span>
                        <img src="{{ Auth::user()->avatar ?: asset('backend/dist/img/avatar.png') }}" class="userpicture rounded-circle" width="40" height="40" aria-hidden="true" style="object-fit: cover; border: 2px solid #237dbe;">
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" role="menu" id="usermenu-dropdown" aria-labelledby="usermenu">
                        <a class="dropdown-item" href="{{ route('filament.admin.pages.dashboard') }}" title="ផ្ទៃតាប្លូ">
                            <i aria-hidden="true" class="fas fa-tachometer-alt me-2"></i>
                            <span>ផ្ទៃតាប្លូ</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('filament.admin.pages.my-profile') }}" title="មើលប្រវត្តិរូប">
                            <i aria-hidden="true" class="fa fa-user me-2"></i>
                            <span>មើលប្រវត្តិរូប</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('filament.admin.pages.my-profile') }}" title="កែសម្រួលព័ត៌មាន">
                            <i aria-hidden="true" class="fa fa-cog me-2"></i>
                            <span>កែសម្រួលព័ត៌មាន</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('filament.admin.pages.dashboard') }}" title="ពិន្ទុ">
                            <i aria-hidden="true" class="fa fa-list-alt me-2"></i>
                            <span>ពិន្ទុ</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('filament.admin.pages.my-profile') }}" title="ការកំណត់">
                            <i aria-hidden="true" class="fa fa-cog me-2"></i>
                            <span>ការកំណត់</span>
                        </a>
                        <a class="dropdown-item" href="#" title="ការជូនដំណឹង">
                            <i aria-hidden="true" class="fa fa-paper-plane me-2"></i>
                            <span>ការជូនដំណឹង</span>
                        </a>
                        <a class="dropdown-item" href="#" title="ប្រតិទិន">
                            <i aria-hidden="true" class="fa fa-calendar me-2"></i>
                            <span>ប្រតិទិន</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#" title="ចេញ" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i aria-hidden="true" class="fa fa-sign-out-alt me-2"></i>
                            <span>ចេញ</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <div class="nav-item dropdown learning-user my-auto">
                    <a class="nav-link dropdown-toggle my-auto d-flex align-items-center gap-2 text-decoration-none" role="button" href="#" id="usermenu" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu" title="អ្នកប្រើជាភ្ញៀវ">
                        <span class="d-none d-md-inline-block mx-1">អ្នកប្រើជាភ្ញៀវ</span>
                        <img src="{{ asset('backend/dist/img/avatar.png') }}" class="userpicture rounded-circle" width="40" height="40" aria-hidden="true" style="object-fit: cover; border: 2px solid #ccc;">
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" role="menu" id="usermenu-dropdown" aria-labelledby="usermenu">
                        <a class="dropdown-item" href="{{ route('login') }}" title="{{ $learningText['login'] }}">
                            <i aria-hidden="true" class="fas fa-sign-in-alt me-2"></i>
                            <span>{{ $learningText['login'] }}</span>
                        </a>
                        <a class="dropdown-item" href="{{ $registerUrl }}" title="{{ $learningText['register'] }}">
                            <i aria-hidden="true" class="fas fa-user-plus me-2"></i>
                            <span>{{ $learningText['register'] }}</span>
                        </a>
                    </div>
                </div>
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

@push('styles')
    <style>
        .learning-navbar {
            background: #fff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
            border-bottom: 1px solid #eef2f6;
        }

        .simplesearchform {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        
        .simplesearchform #searchform-navbar {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1050;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            padding: 4px;
            width: 320px;
        }
        
        .simplesearchform .input-group {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border-radius: 20px;
            padding: 2px 8px;
            width: 100%;
        }
        
        .simplesearchform .form-control {
            border: 0 !important;
            background: transparent !important;
            font-size: 14px;
            box-shadow: none !important;
            padding: 6px 12px;
            color: #334155;
            flex-grow: 1;
        }
        
        .simplesearchform .btn {
            border: 0;
            background: transparent;
            color: #64748b;
            padding: 6px 10px;
            cursor: pointer;
            transition: color 0.2s ease, transform 0.2s ease;
        }
        
        .simplesearchform .btn:hover {
            color: #237dbe;
            transform: scale(1.05);
        }

        .learning-language .dropdown-toggle,
        .learning-user .dropdown-toggle {
            color: #475569;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .learning-language .dropdown-toggle:hover,
        .learning-user .dropdown-toggle:hover {
            color: #237dbe;
        }

        .learning-language .langdesc {
            font-size: 14px;
        }

        .dropdown-menu {
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            padding: 6px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            font-size: 14px;
            color: #475569;
            border-radius: 6px;
            transition: background-color 0.15s ease, color 0.15s ease;
        }

        .dropdown-item:hover {
            background-color: #f1f5f9;
            color: #237dbe;
        }

        .dropdown-item.active, .dropdown-item:active {
            background-color: #237dbe;
            color: #fff;
        }
        
        .dropdown-item i {
            width: 20px;
        }
    </style>
@endpush
