@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    $learningLocale = session('learning_locale', 'km');
    $currentUser = Auth::user();
    $isStudent = $currentUser?->hasRole('student') ?? false;
    $isTeacher = $currentUser?->hasRole('teacher') ?? false;
    $isAdmin = $currentUser?->hasAnyRole(['admin', 'super_admin']) ?? false;

    $learningTexts = [
        'km' => [
            'brand' => 'ប្រព័ន្ធគ្រប់គ្រងកម្មវិធីសិក្សា',
            'home' => 'ទំព័រដើម',
            'courses' => 'មុខវិជ្ជាសិក្សា',
            'course_categories' => 'ប្រភេទមុខវិជ្ជា',
            'about' => 'អំពីយើង',
            'more' => 'ច្រើនទៀត',
            'instructors' => 'គ្រូបង្រៀន',
            'contact' => 'ទំនាក់ទំនង',
            'faq' => 'សំណួរញឹកញាប់',
            'dashboard' => 'ផ្ទាំងគ្រប់គ្រង',
            'my_dashboard' => 'ផ្ទាំងគ្រប់គ្រងរបស់ខ្ញុំ',
            'teacher_dashboard' => 'ផ្ទាំងគ្រប់គ្រងគ្រូបង្រៀន',
            'admin_dashboard' => 'ផ្ទាំងគ្រប់គ្រងអ្នកគ្រប់គ្រង',
            'my_courses' => 'មុខវិជ្ជារបស់ខ្ញុំ',
            'create_course' => 'បង្កើតមុខវិជ្ជា',
            'manage_lessons' => 'គ្រប់គ្រងមេរៀន',
            'my_students' => 'សិស្សរបស់ខ្ញុំ',
            'assignments' => 'កិច្ចការ',
            'quizzes' => 'ការប្រឡងខ្លី',
            'grades' => 'ពិន្ទុ',
            'student_grades' => 'ពិន្ទុសិស្ស',
            'learning_progress' => 'វឌ្ឍនភាពសិក្សា',
            'certificates' => 'វិញ្ញាបនបត្រ',
            'reports' => 'របាយការណ៍',
            'calendar' => 'ប្រតិទិន',
            'notifications' => 'ការជូនដំណឹង',
            'profile' => 'ប្រវត្តិរូប',
            'edit_profile' => 'កែសម្រួលព័ត៌មាន',
            'settings' => 'ការកំណត់',
            'logout' => 'ចាកចេញ',
            'login' => 'ចូលប្រើប្រាស់',
            'register' => 'ចុះឈ្មោះ',
            'guest_user' => 'អ្នកប្រើជាភ្ញៀវ',
            'language' => 'ភាសា',
            'current_language' => 'ខ្មែរ',
            'search_placeholder' => 'ស្វែងរកមុខវិជ្ជា...',
            'search' => 'ស្វែងរក',
            'menu' => 'ម៉ឺនុយ',
        ],

        'en' => [
            'brand' => 'Learning Management System',
            'home' => 'Home',
            'courses' => 'Courses',
            'course_categories' => 'Course Categories',
            'about' => 'About Us',
            'more' => 'More',
            'instructors' => 'Instructors',
            'contact' => 'Contact Us',
            'faq' => 'FAQ',
            'dashboard' => 'Dashboard',
            'my_dashboard' => 'My Dashboard',
            'teacher_dashboard' => 'Teacher Dashboard',
            'admin_dashboard' => 'Admin Dashboard',
            'my_courses' => 'My Courses',
            'create_course' => 'Create Course',
            'manage_lessons' => 'Manage Lessons',
            'my_students' => 'My Students',
            'assignments' => 'Assignments',
            'quizzes' => 'Quizzes',
            'grades' => 'Grades',
            'student_grades' => 'Student Grades',
            'learning_progress' => 'Learning Progress',
            'certificates' => 'Certificates',
            'reports' => 'Reports',
            'calendar' => 'Calendar',
            'notifications' => 'Notifications',
            'profile' => 'Profile',
            'edit_profile' => 'Edit Profile',
            'settings' => 'Settings',
            'logout' => 'Logout',
            'login' => 'Login',
            'register' => 'Register',
            'guest_user' => 'Guest User',
            'language' => 'Language',
            'current_language' => 'English',
            'search_placeholder' => 'Search courses...',
            'search' => 'Search',
            'menu' => 'Menu',
        ],
    ];

    $learningLocale = app()->getLocale();
    $localizationService = app(\App\Services\Localization\LocalizationService::class);
    $activeLanguages = ($activeLanguages ?? $localizationService->activeLanguages());
    $currentLanguage = ($currentLanguage ?? $localizationService->currentLanguage());
    $translationKeys = [
        'brand',
        'home',
        'courses',
        'course_categories',
        'about',
        'more',
        'instructors',
        'contact',
        'faq',
        'dashboard',
        'my_dashboard',
        'teacher_dashboard',
        'admin_dashboard',
        'my_courses',
        'create_course',
        'manage_lessons',
        'my_students',
        'assignments',
        'quizzes',
        'grades',
        'student_grades',
        'learning_progress',
        'certificates',
        'reports',
        'calendar',
        'notifications',
        'profile',
        'edit_profile',
        'settings',
        'logout',
        'login',
        'register',
        'guest_user',
        'language',
        'search_placeholder',
        'search',
        'menu',
    ];
    $learningText = collect($translationKeys)
        ->mapWithKeys(fn (string $key): array => [$key => __("frontend.{$key}")])
        ->all();
    $registerUrl = Route::has('register') ? route('register') : route('login');
    $adminDashboardUrl = Route::has('admin.dashboard') ? route('admin.dashboard') : url('/admin');

    $categoryUrl = Route::has('frontend.course-categories')
        ? route('frontend.course-categories')
        : route('frontend.courses');
    $courseCategories = \App\Models\CourseCategory::query()
        ->whereHas('courses', fn ($query) => $isAdmin || $isTeacher ? $query : $query->visibleOnFrontend($currentUser))
        ->withCount(['courses' => fn ($query) => $isAdmin || $isTeacher ? $query : $query->visibleOnFrontend($currentUser)])
        ->orderBy('category_name')
        ->limit(10)
        ->get();
    $instructorsUrl = Route::has('frontend.instructors')
        ? route('frontend.instructors')
        : route('frontend.about').'#instructors';
    $contactUrl = Route::has('frontend.contact')
        ? route('frontend.contact')
        : route('frontend.about').'#contact';
    $faqUrl = Route::has('frontend.faqs') ? route('frontend.faqs') : route('frontend.about').'#faq';

    $studentDropdown = [
        ['key' => 'my_dashboard', 'icon' => 'fas fa-tachometer-alt', 'route' => 'frontend.student.dashboard', 'fallback' => Route::has('frontend.account.dashboard') ? route('frontend.account.dashboard') : null, 'active' => 'frontend.student.dashboard'],
        ['key' => 'my_courses', 'icon' => 'fas fa-graduation-cap', 'route' => 'frontend.student.courses', 'active' => 'frontend.student.courses*'],
        ['key' => 'assignments', 'icon' => 'fas fa-tasks', 'route' => 'frontend.student.assignments', 'active' => 'frontend.student.assignments*'],
        ['key' => 'quizzes', 'icon' => 'fas fa-question-circle', 'route' => 'frontend.student.quizzes', 'active' => 'frontend.student.quizzes*'],
        ['key' => 'grades', 'icon' => 'fas fa-list-alt', 'route' => 'frontend.student.grades', 'fallback' => Route::has('frontend.account.grades') ? route('frontend.account.grades') : null, 'active' => 'frontend.student.grades*'],
        ['key' => 'learning_progress', 'icon' => 'fas fa-chart-line', 'route' => 'frontend.student.progress', 'active' => 'frontend.student.progress*'],
        ['key' => 'certificates', 'icon' => 'fas fa-certificate', 'route' => 'frontend.student.certificates', 'active' => 'frontend.student.certificates*'],
        ['key' => 'calendar', 'icon' => 'fas fa-calendar', 'route' => 'frontend.account.calendar', 'active' => 'frontend.account.calendar'],
        ['key' => 'notifications', 'icon' => 'fas fa-paper-plane', 'route' => 'frontend.account.notifications', 'active' => 'frontend.account.notifications'],
        ['key' => 'profile', 'icon' => 'fas fa-user', 'route' => 'frontend.account.profile', 'active' => 'frontend.account.profile'],
        ['key' => 'settings', 'icon' => 'fas fa-cog', 'route' => 'frontend.account.settings', 'active' => 'frontend.account.settings'],
    ];

    $teacherDropdown = [
        ['key' => 'teacher_dashboard', 'icon' => 'fas fa-tachometer-alt', 'route' => 'frontend.teacher.dashboard', 'active' => 'frontend.teacher.dashboard'],
        ['key' => 'my_courses', 'icon' => 'fas fa-graduation-cap', 'route' => 'frontend.teacher.courses', 'active' => 'frontend.teacher.courses*'],
        ['key' => 'create_course', 'icon' => 'fas fa-plus-circle', 'route' => 'frontend.teacher.courses.create', 'active' => 'frontend.teacher.courses.create'],
        ['key' => 'manage_lessons', 'icon' => 'fas fa-book-open', 'route' => 'frontend.teacher.lessons', 'active' => 'frontend.teacher.lessons*'],
        ['key' => 'my_students', 'icon' => 'fas fa-users', 'route' => 'frontend.teacher.students', 'active' => 'frontend.teacher.students*'],
        ['key' => 'assignments', 'icon' => 'fas fa-tasks', 'route' => 'frontend.teacher.assignments', 'active' => 'frontend.teacher.assignments*'],
        ['key' => 'quizzes', 'icon' => 'fas fa-question-circle', 'route' => 'frontend.teacher.quizzes', 'active' => 'frontend.teacher.quizzes*'],
        ['key' => 'student_grades', 'icon' => 'fas fa-list-alt', 'route' => 'frontend.teacher.grades', 'active' => 'frontend.teacher.grades*'],
        ['key' => 'reports', 'icon' => 'fas fa-chart-bar', 'route' => 'frontend.teacher.reports', 'active' => 'frontend.teacher.reports*'],
        ['key' => 'calendar', 'icon' => 'fas fa-calendar', 'route' => 'frontend.account.calendar', 'active' => 'frontend.account.calendar'],
        ['key' => 'notifications', 'icon' => 'fas fa-paper-plane', 'route' => 'frontend.account.notifications', 'active' => 'frontend.account.notifications'],
        ['key' => 'profile', 'icon' => 'fas fa-user', 'route' => 'frontend.account.profile', 'active' => 'frontend.account.profile'],
        ['key' => 'settings', 'icon' => 'fas fa-cog', 'route' => 'frontend.account.settings', 'active' => 'frontend.account.settings'],
    ];

    $adminDropdown = [
        ['key' => 'admin_dashboard', 'icon' => 'fas fa-tachometer-alt', 'url' => $adminDashboardUrl, 'active' => 'admin.*'],
        ['key' => 'profile', 'icon' => 'fas fa-user', 'route' => 'frontend.account.profile', 'active' => 'frontend.account.profile'],
        ['key' => 'settings', 'icon' => 'fas fa-cog', 'route' => 'frontend.account.settings', 'active' => 'frontend.account.settings'],
    ];

    $dropdownItems = $isStudent
        ? $studentDropdown
        : ($isTeacher ? $teacherDropdown : ($isAdmin ? $adminDropdown : []));

    $userAvatar = $currentUser?->avatar
        ? (str_starts_with($currentUser->avatar, 'http') ? $currentUser->avatar : asset('storage/'.$currentUser->avatar))
        : asset('backend/dist/img/avatar.png');
@endphp

@php
    $renderDropdownItem = function (array $item) use ($learningText) {
        $url = $item['url'] ?? null;

        if (! $url && isset($item['route']) && Route::has($item['route'])) {
            $url = route($item['route']);
        }

        $url ??= $item['fallback'] ?? null;

        if (! $url) {
            return;
        }
        @endphp
            <a class="dropdown-item {{ request()->routeIs($item['active'] ?? '') ? 'active' : '' }}" href="{{ $url }}" title="{{ $learningText[$item['key']] }}">
                <i aria-hidden="true" class="{{ $item['icon'] }} me-2"></i>
                <span>{{ $learningText[$item['key']] }}</span>
            </a>
        @php
    };
@endphp

<nav class="learning-navbar fixed-top">
    <div class="learning-navbar__inner">
        <a class="learning-brand" href="{{ route('dashboard') }}" aria-label="{{ $learningText['brand'] }}">
            <span class="learning-brand__text">
                <strong>{{ $learningText['brand'] }}</strong>
            </span>
        </a>

        <button class="learning-menu-toggle d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#learningNavbarMenu" aria-controls="learningNavbarMenu" aria-expanded="false" aria-label="{{ $learningText['menu'] }}">
            <i class="fas fa-bars"></i>
        </button>

        <div class="learning-nav d-none d-lg-flex" aria-label="Primary navigation">
            <a href="{{ route('dashboard') }}" class="learning-nav__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
                {{ $learningText['home'] }}
            </a>

            <a href="{{ route('frontend.courses') }}" class="learning-nav__link {{ request()->routeIs('frontend.courses*') ? 'is-active' : '' }}">
                {{ $learningText['courses'] }}
            </a>

            @if($isStudent && Route::has('frontend.student.courses'))
                <a href="{{ route('frontend.student.courses') }}" class="learning-nav__link {{ request()->routeIs('frontend.student.courses*') ? 'is-active' : '' }}">
                    {{ $learningText['my_courses'] }}
                </a>
            @endif

            @if($isTeacher && Route::has('frontend.teacher.courses'))
                <a href="{{ route('frontend.teacher.courses') }}" class="learning-nav__link {{ request()->routeIs('frontend.teacher.courses*') ? 'is-active' : '' }}">
                    {{ $learningText['my_courses'] }}
                </a>
            @endif

            @if($isTeacher && Route::has('frontend.teacher.courses.create'))
                <a href="{{ route('frontend.teacher.courses.create') }}" class="learning-nav__link {{ request()->routeIs('frontend.teacher.courses.create') ? 'is-active' : '' }}">
                    {{ $learningText['create_course'] }}
                </a>
            @endif

            @if($isAdmin)
                <a href="{{ $adminDashboardUrl }}" class="learning-nav__link {{ request()->is('admin*') ? 'is-active' : '' }}">
                    {{ $learningText['admin_dashboard'] }}
                </a>
            @endif

            @unless($isTeacher || $isAdmin)
                <div class="nav-item dropdown learning-categories">
                    <a class="learning-nav__link dropdown-toggle {{ request()->filled('category_id') ? 'is-active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $learningText['course_categories'] }}
                    </a>
                    <div class="dropdown-menu learning-category-menu">
                        <a class="dropdown-item {{ request()->filled('category_id') ? '' : 'active' }}" href="{{ route('frontend.courses') }}">
                            <i class="fas fa-layer-group"></i>
                            <span>{{ $learningText['course_categories'] }}</span>
                        </a>
                        @forelse($courseCategories as $category)
                            <a class="dropdown-item {{ (int) request('category_id') === (int) $category->course_category_id ? 'active' : '' }}" href="{{ route('frontend.courses', ['category_id' => $category->course_category_id]) }}">
                                <i class="fas fa-folder"></i>
                                <span>{{ $category->category_name }}</span>
                                <small>{{ $category->courses_count }}</small>
                            </a>
                        @empty
                            <span class="dropdown-item disabled">
                                <i class="fas fa-folder-open"></i>
                                <span>{{ $learningText['course_categories'] }}</span>
                            </span>
                        @endforelse
                    </div>
                </div>
            @endunless

            <a href="{{ route('frontend.about') }}" class="learning-nav__link {{ request()->routeIs('frontend.about') ? 'is-active' : '' }}">
                {{ $learningText['about'] }}
            </a>

            <div class="nav-item dropdown learning-more">
                <a class="learning-nav__link dropdown-toggle {{ request()->routeIs('frontend.faqs') ? 'is-active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ $learningText['more'] }}
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ $instructorsUrl }}">{{ $learningText['instructors'] }}</a>
                    <a class="dropdown-item" href="{{ $contactUrl }}">{{ $learningText['contact'] }}</a>
                    <a class="dropdown-item {{ request()->routeIs('frontend.faqs') ? 'active' : '' }}" href="{{ $faqUrl }}">{{ $learningText['faq'] }}</a>
                </div>
            </div>
        </div>

        <div class="learning-actions d-flex align-items-center gap-3">
            <div class="learning-search-simple simplesearchform my-auto d-none d-md-block">
                <div class="collapse" id="searchform-navbar">
                    <form autocomplete="off" action="{{ route('frontend.courses') }}" method="GET" class="form-inline searchform-navbar">
                        <div class="input-group">
                            <input type="text" class="form-control withclear" placeholder="{{ $learningText['search_placeholder'] }}" aria-label="{{ $learningText['search'] }}" name="search" value="{{ request('search') }}" autocomplete="off">
                            <a class="btn btn-close-toggle" data-bs-toggle="collapse" href="#searchform-navbar" role="button" aria-label="Close search">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </a>
                            <button type="submit" class="btn btn-submit" aria-label="{{ $learningText['search'] }}">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <a class="btn btn-open" data-bs-toggle="collapse" href="#searchform-navbar" role="button" aria-expanded="false" aria-controls="searchform-navbar" aria-label="{{ $learningText['search'] }}">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </a>
            </div>

            <div class="nav-item dropdown my-auto learning-language">
                <a href="#" class="nav-link dropdown-toggle my-auto d-flex align-items-center gap-2 text-decoration-none" role="button" id="langmenu0" data-bs-toggle="dropdown" aria-expanded="false" title="{{ $learningText['language'] }}">
                    @if($currentLanguage?->flagUrl())
                        <img src="{{ $currentLanguage->flagUrl() }}" alt="" width="22" height="22" class="rounded-circle" style="object-fit: cover;">
                    @else
                        <i class="fa fa-globe fa-lg"></i>
                    @endif
                    <span class="langdesc">{{ $currentLanguage?->native_name ?? strtoupper($learningLocale) }} ({{ $currentLanguage?->code ?? $learningLocale }})</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langmenu0">
                    @foreach($activeLanguages as $language)
                        <li>
                            <a title="{{ $language->native_name }} ({{ $language->code }})" class="dropdown-item {{ $learningLocale === $language->locale ? 'active' : '' }}" href="{{ route('frontend.language', $language->locale) }}">
                                @if($language->flagUrl())
                                    <img src="{{ $language->flagUrl() }}" alt="" width="20" height="20" class="rounded-circle" style="object-fit: cover;">
                                @else
                                    <i class="fa fa-globe"></i>
                                @endif
                                <span>{{ $language->native_name }} ({{ $language->code }})</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            @auth
                <div class="nav-item dropdown learning-user my-auto">
                    <a class="nav-link dropdown-toggle my-auto d-flex align-items-center gap-2 text-decoration-none" role="button" href="#" id="usermenu" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu" title="{{ $currentUser->name }}">
                        <span class="d-none d-md-inline-block mx-1">{{ $currentUser->name }}</span>
                        <img src="{{ $userAvatar }}" class="userpicture rounded-circle" width="40" height="40" alt="" style="object-fit: cover; border: 2px solid #237dbe;">
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" role="menu" id="usermenu-dropdown" aria-labelledby="usermenu">
                        @foreach($dropdownItems as $item)
                            @php($renderDropdownItem($item))
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#" title="{{ $learningText['logout'] }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i aria-hidden="true" class="fa fa-sign-out-alt me-2"></i>
                            <span>{{ $learningText['logout'] }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <div class="nav-item dropdown learning-user my-auto">
                    <a class="nav-link dropdown-toggle my-auto d-flex align-items-center gap-2 text-decoration-none" role="button" href="#" id="usermenu" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu" title="{{ $learningText['guest_user'] }}">
                        <span class="d-none d-md-inline-block mx-1">{{ $learningText['guest_user'] }}</span>
                        <img src="{{ asset('backend/dist/img/avatar.png') }}" class="userpicture rounded-circle" width="40" height="40" alt="" style="object-fit: cover; border: 2px solid #ccc;">
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

    <div class="collapse learning-mobile-collapse d-lg-none" id="learningNavbarMenu">
        <div class="learning-nav learning-nav--mobile" aria-label="Mobile navigation">
            <a href="{{ route('dashboard') }}" class="learning-nav__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
                <i class="fas fa-home"></i><span>{{ $learningText['home'] }}</span>
            </a>
            <a href="{{ route('frontend.courses') }}" class="learning-nav__link {{ request()->routeIs('frontend.courses*') ? 'is-active' : '' }}">
                <i class="fas fa-graduation-cap"></i><span>{{ $learningText['courses'] }}</span>
            </a>
            @if($isStudent && Route::has('frontend.student.courses'))
                <a href="{{ route('frontend.student.courses') }}" class="learning-nav__link {{ request()->routeIs('frontend.student.courses*') ? 'is-active' : '' }}">
                    <i class="fas fa-book-reader"></i><span>{{ $learningText['my_courses'] }}</span>
                </a>
            @endif
            @if($isTeacher && Route::has('frontend.teacher.courses'))
                <a href="{{ route('frontend.teacher.courses') }}" class="learning-nav__link {{ request()->routeIs('frontend.teacher.courses*') ? 'is-active' : '' }}">
                    <i class="fas fa-book-reader"></i><span>{{ $learningText['my_courses'] }}</span>
                </a>
            @endif
            @if($isTeacher && Route::has('frontend.teacher.courses.create'))
                <a href="{{ route('frontend.teacher.courses.create') }}" class="learning-nav__link {{ request()->routeIs('frontend.teacher.courses.create') ? 'is-active' : '' }}">
                    <i class="fas fa-plus-circle"></i><span>{{ $learningText['create_course'] }}</span>
                </a>
            @endif
            @if($isAdmin)
                <a href="{{ $adminDashboardUrl }}" class="learning-nav__link {{ request()->is('admin*') ? 'is-active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i><span>{{ $learningText['admin_dashboard'] }}</span>
                </a>
            @endif
            @unless($isTeacher || $isAdmin)
                <a href="{{ $categoryUrl }}" class="learning-nav__link {{ request()->filled('category_id') ? 'is-active' : '' }}">
                    <i class="fas fa-layer-group"></i><span>{{ $learningText['course_categories'] }}</span>
                </a>
                @foreach($courseCategories as $category)
                    <a href="{{ route('frontend.courses', ['category_id' => $category->course_category_id]) }}" class="learning-nav__link learning-nav__link--sub {{ (int) request('category_id') === (int) $category->course_category_id ? 'is-active' : '' }}">
                        <i class="fas fa-folder"></i>
                        <span>{{ $category->category_name }}</span>
                    </a>
                @endforeach
            @endunless
            <a href="{{ route('frontend.about') }}" class="learning-nav__link {{ request()->routeIs('frontend.about') ? 'is-active' : '' }}">
                <i class="fas fa-info-circle"></i><span>{{ $learningText['about'] }}</span>
            </a>
            <a href="{{ $instructorsUrl }}" class="learning-nav__link">
                <i class="fas fa-chalkboard-teacher"></i><span>{{ $learningText['instructors'] }}</span>
            </a>
            <a href="{{ $contactUrl }}" class="learning-nav__link">
                <i class="fas fa-envelope"></i><span>{{ $learningText['contact'] }}</span>
            </a>
            <a href="{{ $faqUrl }}" class="learning-nav__link {{ request()->routeIs('frontend.faqs') ? 'is-active' : '' }}">
                <i class="fas fa-question-circle"></i><span>{{ $learningText['faq'] }}</span>
            </a>
        </div>

        <form action="{{ route('frontend.courses') }}" method="GET" class="learning-search learning-search--mobile" role="search">
            <div class="learning-search__group">
                <i class="fas fa-search learning-search__icon"></i>
                <input type="search" name="search" value="{{ request('search') }}" class="learning-search__input" placeholder="{{ $learningText['search_placeholder'] }}" aria-label="{{ $learningText['search'] }}">
                @if(request()->filled('search'))
                    <a href="{{ route('frontend.courses') }}" class="learning-search__clear">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
                <button type="submit" class="learning-search__button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</nav>

@once
    <style>
        @font-face {
            font-family: 'Battambang';
            src: url('/fonts/Battambang-Regular.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Battambang';
            src: url('/fonts/Battambang-Bold.ttf') format('truetype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

        body.frontend-page .learning-navbar {
            min-height: 70px;
            align-items: stretch;
            background: #0a6a76;
            border-bottom: 0;
            box-shadow: none;
            backdrop-filter: none;
            z-index: 1100;
        }

        body.frontend-page .learning-navbar__inner {
            max-width: none;
            min-height: 70px;
            display: flex;
            align-items: stretch;
            gap: 12px;
            padding: 0 36px;
            background: #0a6a76;
            font-family: 'Battambang', 'Khmer OS Siemreap', 'Khmer OS Battambang', Arial, sans-serif;
        }

        body.frontend-page .learning-brand {
            min-width: max-content;
            color: #fff;
            border-radius: 0;
            padding: 0 12px;
        }

        body.frontend-page .learning-brand:hover {
            background: #075c68;
            transform: none;
        }

        body.frontend-page .learning-brand__text strong {
            color: #fff;
            font-family: 'Battambang', sans-serif;
            font-size: 22px;
            font-weight: 700 !important;
            white-space: nowrap;
        }

        .learning-menu-toggle {
            width: 46px;
            height: 46px;
            align-self: center;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 6px;
            background: transparent;
            color: #fff;
            font-size: 20px;
        }

        body.frontend-page .learning-navbar__inner > .learning-nav {
            min-width: 0;
            border: 0;
            border-radius: 0;
            background: transparent;
            padding: 0;
        }

        body.frontend-page .learning-navbar__inner > .learning-nav .learning-nav__link {
            min-height: 70px;
            border-radius: 0;
            color: #fff;
            font-size: 21px;
            font-weight: 400;
            padding: 0 18px;
            white-space: nowrap;
        }

        body.frontend-page .learning-navbar__inner > .learning-nav .learning-nav__link:hover,
        body.frontend-page .learning-navbar__inner > .learning-nav .learning-nav__link.is-active,
        body.frontend-page .learning-navbar__inner > .learning-nav .learning-nav__link.show {
            background: #075c68;
            color: #fff;
            box-shadow: none;
            transform: none;
        }

        body.frontend-page .learning-categories .dropdown-menu,
        body.frontend-page .learning-more .dropdown-menu,
        body.frontend-page .learning-language .dropdown-menu,
        body.frontend-page .learning-user .dropdown-menu {
            z-index: 1200;
        }

        body.frontend-page .learning-categories .dropdown-menu,
        body.frontend-page .learning-more .dropdown-menu {
            min-width: 190px;
            margin-top: 0;
            border: 0;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .16);
            padding: 10px 0;
        }

        body.frontend-page .learning-categories .dropdown-menu {
            min-width: 285px;
        }

        body.frontend-page .learning-actions {
            justify-content: flex-end;
            gap: 0 !important;
            margin-left: auto;
        }

        .simplesearchform {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        body.frontend-page .simplesearchform .btn-open {
            width: 48px;
            height: 48px;
            display: inline-grid;
            place-items: center;
            border: 0;
            border-radius: 0;
            color: #fff;
            font-size: 18px;
            background: transparent;
        }

        .simplesearchform #searchform-navbar {
            position: absolute;
            right: 0;
            top: 50%;
            width: 320px;
            z-index: 1200;
            padding: 4px;
            border: 0;
            border-radius: 3px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            transform: translateY(-50%);
        }

        .simplesearchform .input-group {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 2px 8px;
            border-radius: 0;
            background: #f8fafc;
        }

        .simplesearchform .form-control {
            flex-grow: 1;
            border: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            color: #334155;
            font-size: 14px;
            padding: 6px 12px;
        }

        .simplesearchform .btn {
            border: 0;
            background: transparent;
            color: #0b1a72;
            padding: 6px 10px;
            cursor: pointer;
            transition: color .2s ease, transform .2s ease;
        }

        .simplesearchform .btn:hover {
            color: #0a6a76;
            transform: scale(1.05);
        }

        body.frontend-page .learning-language .dropdown-toggle,
        body.frontend-page .learning-user .dropdown-toggle {
            min-height: 70px;
            display: inline-flex;
            align-items: center;
            gap: 9px !important;
            padding: 0 18px;
            border: 0;
            border-radius: 0;
            background: transparent;
            color: #fff;
            font-family: 'Battambang', 'Khmer OS Siemreap', 'Khmer OS Battambang', Arial, sans-serif;
            font-size: 21px;
            font-weight: 700;
            line-height: 1;
            text-decoration: none;
            transition: background-color .2s ease, color .2s ease;
        }

        body.frontend-page .learning-language .dropdown-toggle:hover,
        body.frontend-page .learning-language .dropdown-toggle.show,
        body.frontend-page .learning-user .dropdown-toggle:hover,
        body.frontend-page .learning-user .dropdown-toggle.show {
            background: #075c68;
            color: #fff;
        }

        body.frontend-page .learning-user .dropdown-toggle {
            background: #087281;
            border-left: 1px solid rgba(255, 255, 255, .16);
            padding-left: 22px;
            padding-right: 22px;
        }

        body.frontend-page .learning-language .dropdown-toggle i {
            width: 22px;
            font-size: 21px;
            text-align: center;
            flex: 0 0 22px;
        }

        body.frontend-page .learning-language .langdesc {
            font-size: 21px;
            line-height: 1;
            white-space: nowrap;
        }

        body.frontend-page .learning-user .dropdown-toggle > span {
            display: inline-block;
            margin: 0 2px !important;
            white-space: nowrap;
        }

        body.frontend-page .learning-user .dropdown-toggle img {
            width: 38px;
            height: 38px;
            border: 0 !important;
            box-shadow: none;
            background: #fff;
            flex: 0 0 38px;
            margin-left: 2px;
        }

        body.frontend-page .learning-language .dropdown-toggle::after,
        body.frontend-page .learning-user .dropdown-toggle::after {
            margin-left: 2px;
            opacity: .92;
        }

        body.frontend-page .learning-language .dropdown-menu,
        body.frontend-page .learning-user .dropdown-menu {
            min-width: 220px;
            max-height: calc(100vh - 86px);
            overflow-y: auto;
            margin-top: 0;
            border: 0;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .16);
            padding: 10px 0;
        }

        body.frontend-page .learning-language .dropdown-item,
        body.frontend-page .learning-user .dropdown-item,
        body.frontend-page .learning-categories .dropdown-item,
        body.frontend-page .learning-more .dropdown-item {
            min-height: 44px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 18px;
            border-radius: 0;
            color: #0b1a72;
            font-family: 'Battambang', 'Khmer OS Siemreap', 'Khmer OS Battambang', Arial, sans-serif;
            font-size: 18px;
            font-weight: 400;
            line-height: 1.45;
            white-space: nowrap;
            transition: background-color .15s ease, color .15s ease;
        }

        body.frontend-page .learning-language .dropdown-item:hover,
        body.frontend-page .learning-user .dropdown-item:hover,
        body.frontend-page .learning-categories .dropdown-item:hover,
        body.frontend-page .learning-more .dropdown-item:hover {
            background-color: #f4f7fb;
            color: #0b1a72;
            transform: none;
        }

        body.frontend-page .learning-language .dropdown-item.active,
        body.frontend-page .learning-language .dropdown-item:active,
        body.frontend-page .learning-user .dropdown-item.active,
        body.frontend-page .learning-user .dropdown-item:active,
        body.frontend-page .learning-categories .dropdown-item.active,
        body.frontend-page .learning-categories .dropdown-item:active,
        body.frontend-page .learning-more .dropdown-item.active,
        body.frontend-page .learning-more .dropdown-item:active {
            background-color: #0a6a76;
            color: #fff;
            font-weight: 500;
        }

        body.frontend-page .learning-language .dropdown-item i,
        body.frontend-page .learning-user .dropdown-item i,
        body.frontend-page .learning-categories .dropdown-item i {
            width: 22px;
            color: inherit;
            font-size: 17px;
            text-align: center;
        }

        body.frontend-page .learning-categories .dropdown-item span {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        body.frontend-page .learning-categories .dropdown-item small {
            min-width: 28px;
            margin-left: auto;
            padding: 2px 8px;
            border-radius: 999px;
            background: #eaf1ff;
            color: #145dff;
            font-size: 12px;
            font-weight: 900;
            text-align: center;
        }

        body.frontend-page .learning-categories .dropdown-item.active small,
        body.frontend-page .learning-categories .dropdown-item:active small {
            background: rgba(255, 255, 255, .18);
            color: #fff;
        }

        body.frontend-page .learning-user .dropdown-divider {
            margin: 6px 0;
        }

        body.frontend-page .learning-mobile-collapse {
            background: #0a6a76;
            box-shadow: 0 12px 22px rgba(0, 0, 0, .12);
        }

        body.frontend-page .learning-nav--mobile {
            width: 100%;
            display: grid;
            gap: 4px;
            margin: 0;
            padding: 10px 12px;
            border: 0;
            border-radius: 0;
            background: #0a6a76;
        }

        body.frontend-page .learning-nav--mobile .learning-nav__link {
            width: 100%;
            min-height: 46px;
            justify-content: flex-start;
            color: #fff;
            background: transparent;
            box-shadow: none;
            font-size: 15px;
        }

        body.frontend-page .learning-nav--mobile .learning-nav__link--sub {
            min-height: 40px;
            padding-left: 34px;
            font-size: 14px;
            opacity: .96;
        }

        body.frontend-page .learning-nav--mobile .learning-nav__link.is-active,
        body.frontend-page .learning-nav--mobile .learning-nav__link:hover {
            background: #075c68;
            color: #fff;
            transform: none;
        }

        body.frontend-page .learning-search--mobile {
            width: calc(100% - 24px);
            margin: 0 12px 12px;
        }

        @media (max-width: 1199.98px) {
            body.frontend-page .learning-navbar__inner {
                padding: 0 18px;
            }

            body.frontend-page .learning-brand__text strong {
                font-size: 18px;
            }

            body.frontend-page .learning-navbar__inner > .learning-nav .learning-nav__link {
                padding: 0 12px;
                font-size: 17px;
            }
        }

        @media (max-width: 991.98px) {
            body.frontend-page .learning-navbar__inner {
                min-height: 62px;
                padding: 0 12px;
            }

            body.frontend-page .learning-brand {
                min-width: 0;
                flex: 1 1 auto;
            }

            body.frontend-page .learning-brand__text strong {
                overflow: hidden;
                display: block;
                max-width: 44vw;
                text-overflow: ellipsis;
            }

            body.frontend-page .learning-language .dropdown-toggle,
            body.frontend-page .learning-user .dropdown-toggle {
                min-height: 62px;
                gap: 7px !important;
                padding: 0 12px;
                font-size: 18px;
            }

            body.frontend-page .learning-user .dropdown-toggle {
                padding-left: 14px;
                padding-right: 14px;
            }

            body.frontend-page .learning-language .langdesc,
            body.frontend-page .learning-user .dropdown-toggle span {
                display: none !important;
            }
        }
    </style>
@endonce

@once
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menu = document.getElementById('learningNavbarMenu');

            if (!menu) {
                return;
            }

            menu.querySelectorAll('a[href]').forEach(function (link) {
                link.addEventListener('click', function () {
                    const collapse = bootstrap.Collapse.getInstance(menu);

                    if (collapse) {
                        collapse.hide();
                    }
                });
            });
        });
    </script>
@endonce
