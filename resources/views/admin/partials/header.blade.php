<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">

    <!-- LEFT NAVBAR -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- RIGHT NAVBAR -->
    <ul class="navbar-nav ml-auto">

        <!-- FULLSCREEN -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <!-- DARK MODE -->
        <li class="nav-item">
            <a class="nav-link" href="#" id="darkModeToggle">
                <i class="fas fa-moon" id="darkModeIcon"></i>
            </a>
        </li>

        @php
            $currentLocale = app()->getLocale();
            $availableLanguages = $appLanguages ?? collect();
        @endphp

        <!-- LANGUAGE DROPDOWN -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-language"></i>
                <span class="badge badge-info navbar-badge text-uppercase">
                    {{ $currentLocale }}
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <span class="dropdown-header">
                    {{ __('messages.language') }}
                </span>

                @foreach ($availableLanguages as $lang)
                    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.language.switch') ? route('admin.language.switch', $lang->code) : '#' }}"
                        class="dropdown-item {{ $currentLocale == $lang->code ? 'active' : '' }}">

                        {{ $lang->flag ?? 'ðŸŒ' }}
                        {{ $lang->name }}

                        @if ($currentLocale == $lang->code)
                            <i class="fas fa-check float-right text-success"></i>
                        @endif
                    </a>
                @endforeach
            </div>

        </li>

        <!-- USER DROPDOWN -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="{{ Auth::user()->avatar }}" class="img-circle" width="30" height="30"
                    style="object-fit:cover;">

                <span class="ml-1">
                    {{ Auth::user()->name ?? 'អ្នកប្រើប្រាស់' }}
                </span>

                <i class="fas fa-chevron-down text-xs ml-2"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right">

                <div class="dropdown-item text-center bg-primary text-white">
                    <strong>{{ Auth::user()->name ?? 'អ្នកប្រើប្រាស់' }}</strong><br>
                    <small>
                        {{ Auth::user()->getRoleNames()->first() ?? 'មិនមានតួនាទី' }}
                    </small>
                </div>

                <div class="dropdown-divider"></div>

                <a href="/profile" class="dropdown-item">
                    <i class="fas fa-user-circle mr-2"></i>
                    {{ __('messages.profile') }}
                </a>
                <a href="/profile" class="dropdown-item">
                    <i class="fas fa-user-circle mr-2"></i>
                    ចូលទៅ Website
                </a>

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-power-off mr-2"></i>
                    {{ __('messages.logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </div>
        </li>

    </ul>
</nav>

