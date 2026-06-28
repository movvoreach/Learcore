<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-fixed">

    @php
        $routeUrl = function (array|string $names, string $fallback = '/student'): string {
            foreach ((array) $names as $name) {
                if (\Illuminate\Support\Facades\Route::has($name)) {
                    return route($name);
                }
            }
            return url($fallback);
        };
    @endphp

    {{-- ================= Logo ================= --}}
    <a href="{{ $routeUrl('student.dashboard') }}" class="brand-link d-flex align-items-center">
        <img src="{{ asset('backend/dist/img/spilogo.png') }}"
            alt="SPI Logo"
            class="brand-image img-circle elevation-3"
            style="opacity:.9;width:45px;height:45px;">

        <span class="brand-text font-weight-light ml-2">
            Student Portal
        </span>
    </a>

    {{-- ================= Sidebar ================= --}}
    <div class="sidebar">

        {{-- ================= User Panel ================= --}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="{{ Auth::user()->avatar ?? asset('backend/dist/img/user.png') }}"
                    class="img-circle elevation-2"
                    style="width:40px;height:40px;">
            </div>

            <div class="info">
                <a href="#" class="d-block text-white">
                    {{ Auth::user()->name ?? 'Student' }}
                </a>
            </div>
        </div>

        {{-- ================= Menu ================= --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ $routeUrl('student.dashboard') }}"
                        class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">Learning</li>

                {{-- Courses --}}
                <li class="nav-item">
                    <a href="{{ $routeUrl('student.courses.index') }}"
                        class="nav-link {{ request()->routeIs('student.courses.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>My Courses</p>
                    </a>
                </li>

                {{-- Lessons --}}
                <li class="nav-item">
                    <a href="{{ $routeUrl('student.lessons.index') }}"
                        class="nav-link {{ request()->routeIs('student.lessons.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>Lessons</p>
                    </a>
                </li>

                {{-- Assignments --}}
                <li class="nav-item">
                    <a href="{{ $routeUrl('student.assignments.index') }}"
                        class="nav-link {{ request()->routeIs('student.assignments.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Assignments</p>
                    </a>
                </li>

                {{-- Quizzes / Exams --}}
                <li class="nav-item">
                    <a href="{{ $routeUrl('student.quizzes.index') }}"
                        class="nav-link {{ request()->routeIs('student.quizzes.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Quizzes & Exams</p>
                    </a>
                </li>

                <li class="nav-header">Progress</li>

                {{-- Progress --}}
                <li class="nav-item">
                    <a href="{{ $routeUrl('student.progress.index') }}"
                        class="nav-link {{ request()->routeIs('student.progress.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>My Progress</p>
                    </a>
                </li>

                {{-- Grades --}}
                <li class="nav-item">
                    <a href="{{ $routeUrl('student.grades.index') }}"
                        class="nav-link {{ request()->routeIs('student.grades.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>My Grades</p>
                    </a>
                </li>

                <li class="nav-header">Community</li>

                {{-- Forum --}}
                <li class="nav-item">
                    <a href="{{ $routeUrl('student.forums.index') }}"
                        class="nav-link {{ request()->routeIs('student.forums.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Discussion Forum</p>
                    </a>
                </li>

                <li class="nav-header">Account</li>

                {{-- Profile --}}
                <li class="nav-item">
                    <a href="{{ $routeUrl('student.profile') }}"
                        class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>My Profile</p>
                    </a>
                </li>

                {{-- Logout --}}
                <li class="nav-item">
                    <a href="{{ route('logout') }}"
                        class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
