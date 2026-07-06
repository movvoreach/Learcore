<nav class="learning-navbar fixed-top">
    <div class="learning-navbar__inner">
        <a class="learning-brand" href="{{ route('dashboard') }}" aria-label="Moodle LMS home">
            <span class="learning-brand__icon">
                <i class="fas fa-book-open"></i>
            </span>
            <span class="learning-brand__text">
                <small>ប្រព័ន្ធគ្រប់គ្រងការសិក្សា</small>
            </span>
        </a>

        <div class="learning-nav d-none d-lg-flex" aria-label="Primary navigation">
            <a href="{{ route('dashboard') }}" class="learning-nav__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">ទំព័រដើម</a>
            <a href="{{ route('frontend.courses') }}" class="learning-nav__link {{ request()->routeIs('frontend.courses') ? 'is-active' : '' }}">មុខវិជ្ជាសិក្សា</a>
        </div>

        <div class="learning-actions">
            <a href="{{ route('frontend.courses') }}" class="learning-action learning-action--outline">
                <i class="fas fa-code"></i>
                <span>មុខវិជ្ជាសិក្សា</span>
            </a>

            @auth
                <div class="learning-user dropdown">
                    <a class="learning-user__button dropdown-toggle" data-toggle="dropdown" href="#">
                        <img src="{{ Auth::user()->avatar ?? asset('backend/dist/img/avatar.png') }}" alt="">
                        <span>{{ Auth::user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('filament.admin.pages.dashboard') }}" class="dropdown-item">
                            <i class="fas fa-user-shield mr-2"></i>
                            ផ្ទាំងគ្រប់គ្រង
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="/profile" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i>
                            គណនីផ្ទាល់ខ្លួន
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#"
                            class="dropdown-item text-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            ចាកចេញ
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="learning-login">ចូលប្រើប្រាស់</a>
                <a href="{{ route('login') }}" class="learning-cta">ចុះឈ្មោះ</a>
            @endauth
        </div>
    </div>
</nav>
