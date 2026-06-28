<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student LMS | LearnCore</title>
    <link rel="icon" type="image/png" href="{{ asset('backend/dist/img/spilogo.png') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Moul&family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #152033;
            --muted: #657085;
            --line: #dfe6ef;
            --surface: #ffffff;
            --soft: #f5f7fb;
            --blue: #1769e0;
            --green: #11996d;
            --amber: #b56a00;
            --rose: #c03758;
            --violet: #6048c6;
            --shadow: 0 16px 36px rgba(21, 32, 51, .09);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: var(--ink);
            background: #eef2f7;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .lms-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
        }

        .lms-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 20px 16px;
            background: #101827;
            color: #e8edf5;
            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 52px;
            margin-bottom: 24px;
        }

        .brand img {
            width: 44px;
            height: 44px;
            object-fit: contain;
            border-radius: 8px;
            background: #fff;
            padding: 4px;
        }

        .brand strong,
        .nav-group {
            display: block;
        }

        .brand strong {
            font-size: 17px;
            line-height: 1.2;
        }

        .brand span,
        .nav-group {
            color: #94a3b8;
            font-size: 12px;
        }

        .nav-group {
            margin: 20px 10px 8px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 44px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #cbd5e1;
            font-weight: 700;
        }

        .nav-link:hover,
        .nav-link.is-active {
            color: #fff;
            background: rgba(255, 255, 255, .10);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        .sidebar-profile {
            margin-top: 24px;
            padding: 14px;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 8px;
            background: rgba(255, 255, 255, .06);
        }

        .sidebar-profile strong {
            display: block;
            font-size: 14px;
        }

        .sidebar-profile span {
            display: block;
            margin-top: 4px;
            color: #94a3b8;
            font-size: 12px;
        }

        .lms-main {
            min-width: 0;
            padding: 22px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            min-height: 62px;
            margin-bottom: 18px;
        }

        .mobile-brand {
            display: none;
            align-items: center;
            gap: 10px;
            font-weight: 900;
        }

        .mobile-brand img {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .search {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            max-width: 560px;
            min-height: 44px;
            padding: 0 14px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
        }

        .search input {
            width: 100%;
            border: 0;
            outline: 0;
            color: var(--ink);
            font-size: 14px;
            background: transparent;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-btn,
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
            color: var(--ink);
            font-weight: 800;
        }

        .icon-btn {
            width: 44px;
            height: 44px;
        }

        .btn {
            gap: 9px;
            min-height: 44px;
            padding: 0 15px;
        }

        .btn-primary {
            border-color: var(--blue);
            background: var(--blue);
            color: #fff;
        }

        .hero {
            position: relative;
            min-height: 310px;
            overflow: hidden;
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) 360px;
            gap: 22px;
            align-items: end;
            padding: 30px;
            border-radius: 8px;
            background:
                linear-gradient(90deg, rgba(11, 18, 32, .92), rgba(11, 18, 32, .58), rgba(11, 18, 32, .15)),
                url("{{ asset('backend/dist/img/slide/SPI-Campus-no-logo-Crop.png') }}");
            background-size: cover;
            background-position: center;
            color: #fff;
            box-shadow: var(--shadow);
        }

        .hero h1 {
            max-width: 720px;
            margin: 0;
            font-size: 42px;
            line-height: 1.12;
            font-weight: 900;
            letter-spacing: 0;
        }

        .hero p {
            max-width: 660px;
            margin: 14px 0 22px;
            color: rgba(255, 255, 255, .84);
            font-size: 16px;
            line-height: 1.6;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            color: #b9f6df;
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .focus-panel {
            padding: 18px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 8px;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(10px);
        }

        .focus-panel p {
            margin: 0;
            font-size: 13px;
        }

        .focus-value {
            margin: 10px 0;
            font-size: 48px;
            line-height: 1;
            font-weight: 900;
        }

        .progress-track {
            height: 10px;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(255, 255, 255, .22);
        }

        .progress-track span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: #35d399;
        }

        .section {
            margin-top: 22px;
        }

        .section-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 14px;
        }

        .section-head h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 900;
        }

        .section-head p {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 14px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .stat-card,
        .course-card,
        .panel,
        .material-item,
        .assignment-item {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
            box-shadow: 0 10px 24px rgba(21, 32, 51, .06);
        }

        .stat-card {
            display: grid;
            grid-template-columns: 46px minmax(0, 1fr);
            gap: 12px;
            align-items: center;
            min-height: 98px;
            padding: 16px;
        }

        .stat-card i {
            display: grid;
            place-items: center;
            width: 46px;
            height: 46px;
            border-radius: 8px;
            font-size: 18px;
        }

        .tone-blue i { background: #e8f1ff; color: var(--blue); }
        .tone-green i { background: #e7f8ef; color: var(--green); }
        .tone-amber i { background: #fff4db; color: var(--amber); }
        .tone-rose i { background: #ffecef; color: var(--rose); }

        .stat-value {
            display: block;
            font-size: 26px;
            line-height: 1;
            font-weight: 900;
        }

        .stat-label {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 800;
        }

        .workspace {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 18px;
            align-items: start;
        }

        .course-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .course-card {
            padding: 18px;
        }

        .course-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .course-badge {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            background: #eef2ff;
            color: var(--violet);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .course-card h3 {
            margin: 0;
            font-size: 18px;
            line-height: 1.3;
            font-weight: 900;
        }

        .course-card p {
            margin: 8px 0 16px;
            color: var(--muted);
            line-height: 1.55;
            font-size: 14px;
        }

        .course-meta {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
        }

        .course-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
            min-width: 0;
        }

        .course-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 16px;
        }

        .mini-progress {
            flex: 1;
            height: 8px;
            overflow: hidden;
            border-radius: 999px;
            background: #e8edf5;
        }

        .mini-progress span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--blue), var(--green));
        }

        .panel {
            overflow: hidden;
        }

        .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 18px;
            border-bottom: 1px solid var(--line);
        }

        .panel-head h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
        }

        .panel-body {
            padding: 16px 18px;
        }

        .lesson-list,
        .assignment-list,
        .material-list {
            display: grid;
            gap: 12px;
        }

        .lesson-item {
            display: grid;
            grid-template-columns: 42px minmax(0, 1fr);
            gap: 12px;
            align-items: start;
        }

        .lesson-icon,
        .material-icon {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            border-radius: 8px;
            background: #e8f1ff;
            color: var(--blue);
        }

        .lesson-item h3,
        .assignment-item h3,
        .material-item h3 {
            margin: 0;
            font-size: 14px;
            line-height: 1.35;
            font-weight: 900;
        }

        .lesson-item p,
        .assignment-item p,
        .material-item p {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.45;
        }

        .assignment-item,
        .material-item {
            padding: 13px;
            box-shadow: none;
        }

        .assignment-date {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
            color: var(--rose);
            font-size: 12px;
            font-weight: 900;
        }

        .material-item {
            display: grid;
            grid-template-columns: 42px minmax(0, 1fr);
            gap: 12px;
            align-items: start;
        }

        .empty {
            padding: 26px 12px;
            color: var(--muted);
            text-align: center;
        }

        .bottom-nav {
            display: none;
            position: sticky;
            bottom: 0;
            z-index: 20;
            grid-template-columns: repeat(4, 1fr);
            border-top: 1px solid var(--line);
            background: rgba(255, 255, 255, .96);
            backdrop-filter: blur(10px);
        }

        .bottom-nav a {
            display: grid;
            place-items: center;
            gap: 4px;
            min-height: 58px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 900;
        }

        .bottom-nav a.is-active {
            color: var(--blue);
        }

        @media (max-width: 1180px) {
            .lms-shell {
                grid-template-columns: 1fr;
            }

            .lms-sidebar {
                display: none;
            }

            .mobile-brand {
                display: flex;
            }

            .hero,
            .workspace {
                grid-template-columns: 1fr;
            }

            .focus-panel {
                max-width: 420px;
            }

            .bottom-nav {
                display: grid;
            }

            .lms-main {
                padding-bottom: 82px;
            }
        }

        @media (max-width: 820px) {
            .lms-main {
                padding: 14px;
                padding-bottom: 82px;
            }

            .topbar {
                align-items: stretch;
                display: grid;
            }

            .search {
                max-width: none;
            }

            .top-actions {
                justify-content: space-between;
            }

            .hero {
                min-height: 420px;
                padding: 22px;
                align-items: end;
                background-position: center;
            }

            .hero h1 {
                font-size: 32px;
            }

            .stats-grid,
            .course-grid {
                grid-template-columns: 1fr;
            }

            .section-head {
                display: grid;
                align-items: start;
            }
        }

        @media (max-width: 520px) {
            .hero h1 {
                font-size: 28px;
            }

            .course-meta {
                grid-template-columns: 1fr;
            }

            .course-footer,
            .course-top {
                display: grid;
            }

            .btn {
                width: 100%;
            }
        }

        /* TV Schedule Styles */
        .tv-schedule-container {
            margin-top: 15px;
            padding: 30px;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: var(--shadow);
            border: 1px solid var(--line);
        }

        .tv-schedule-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 24px;
            text-align: center;
        }

        .school-badge {
            display: inline-block;
            border: 2px solid #2e7d32;
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Kantumruy Pro', sans-serif;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(46, 125, 50, 0.1);
        }

        .tv-schedule-title {
            font-family: 'Moul', cursive;
            font-size: 20px;
            color: #1e293b;
            line-height: 1.6;
            margin: 0;
            max-width: 800px;
        }

        .tv-schedule-subtitle {
            font-family: 'Moul', cursive;
            font-size: 18px;
            color: #1e293b;
            margin-top: 5px;
            margin-bottom: 0;
            text-decoration: underline;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 30px;
            border-radius: 8px;
            border: 1px solid #000000;
        }

        .tv-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Kantumruy Pro', sans-serif;
            font-size: 14px;
            text-align: center;
            background-color: #fff;
            min-width: 800px;
        }

        .tv-table th, .tv-table td {
            border: 1px solid #000000;
            padding: 12px 8px;
            vertical-align: middle;
            font-weight: 600;
        }

        .tv-table th {
            font-weight: 700;
        }

        /* Color classes from image */
        .bg-header-grey {
            background-color: #d1c4e9;
            color: #1e293b;
        }

        .bg-day-cyan {
            background-color: #00e5ff;
            color: #000000;
        }

        .row-grade-7 {
            background-color: #b3e5fc;
            color: #000000;
        }

        .row-grade-8 {
            background-color: #c8e6c9;
            color: #000000;
        }

        .row-grade-9-1 {
            background-color: #ffe082;
            color: #000000;
        }

        .row-grade-9-2 {
            background-color: #ffcc80;
            color: #000000;
        }

        .row-grade-9-3 {
            background-color: #f8bbd0;
            color: #000000;
        }

        .tv-schedule-footer {
            background-color: #f8fafc;
            border: 1px dashed var(--line);
            padding: 20px 25px;
            border-radius: 8px;
            font-family: 'Kantumruy Pro', sans-serif;
            font-size: 14px;
            color: #475569;
            line-height: 1.8;
            text-align: left;
        }

        .tv-schedule-footer h3 {
            font-size: 16px;
            color: #1e293b;
            margin-top: 0;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .tv-schedule-footer ol {
            margin: 0;
            padding-left: 20px;
        }

        .tv-schedule-footer li {
            margin-bottom: 8px;
        }

        .tv-schedule-footer a {
            color: #2563eb;
            text-decoration: underline;
            word-break: break-all;
        }

        .tv-schedule-footer a:hover {
            color: #1d4ed8;
        }

        .hashtags {
            margin-top: 15px;
            font-weight: 700;
            color: #2563eb;
        }
    </style>
</head>
<body>
@php
    $user = auth()->user();
    $studentName = $user?->name
        ?? trim(($student?->first_name ?? '') . ' ' . ($student?->last_name ?? ''))
        ?: 'Student';
    $completionRate = min(100, max(0, (int) data_get($stats, 'lesson_completion_rate', 0)));
    $routeTo = function (array|string $names, string $fallback = '/admin') {
        foreach ((array) $names as $name) {
            if (\Illuminate\Support\Facades\Route::has($name)) {
                return route($name);
            }
        }

        return url($fallback);
    };
@endphp

<div class="lms-shell">
    <aside class="lms-sidebar">
        <a href="{{ route('dashboard') }}" class="brand">
            <img src="{{ asset('backend/dist/img/spilogo.png') }}" alt="LearnCore">
            <span>
                <strong>LearnCore LMS</strong>
                <span>Student Workspace</span>
            </span>
        </a>

        <span class="nav-group">Learning</span>
        <a href="#overview" class="nav-link is-active"><i class="fas fa-compass"></i> Overview</a>
        <a href="#tv-schedule" class="nav-link"><i class="fas fa-tv"></i> TV Schedule</a>
        <a href="#courses" class="nav-link"><i class="fas fa-layer-group"></i> Courses</a>
        <a href="#lessons" class="nav-link"><i class="fas fa-play-circle"></i> Lessons</a>
        <a href="#assignments" class="nav-link"><i class="fas fa-tasks"></i> Assignments</a>
        <a href="#materials" class="nav-link"><i class="fas fa-folder-open"></i> Materials</a>

        <span class="nav-group">Account</span>
        <a href="{{ $routeTo('filament.admin.pages.dashboard') }}" class="nav-link"><i class="fas fa-user-cog"></i> Admin Panel</a>
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="nav-link" style="width:100%;border:0;text-align:left;cursor:pointer;"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
        @endauth

        <div class="sidebar-profile">
            <strong>{{ $studentName }}</strong>
            <span>{{ $student?->student_code ?? 'Ready to learn' }}</span>
        </div>
    </aside>

    <main class="lms-main">
        <header class="topbar">
            <a href="{{ route('dashboard') }}" class="mobile-brand">
                <img src="{{ asset('backend/dist/img/spilogo.png') }}" alt="LearnCore">
                LearnCore LMS
            </a>
            <label class="search">
                <i class="fas fa-search"></i>
                <input id="courseSearch" type="search" placeholder="Search courses, lessons, and materials">
            </label>
            <div class="top-actions">
                <a class="icon-btn" href="#assignments" aria-label="Assignments"><i class="fas fa-bell"></i></a>
                @auth
                    <a class="btn" href="{{ $routeTo('filament.admin.pages.dashboard') }}"><i class="fas fa-user"></i> {{ $studentName }}</a>
                @else
                    <a class="btn btn-primary" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                @endauth
            </div>
        </header>

        <div id="dashboard-tab-content">
            <section class="hero" id="overview">
            <div>
                <span class="hero-kicker"><i class="fas fa-graduation-cap"></i> Student Learning Management System</span>
                <h1>Learn, submit, track progress, and keep every course moving.</h1>
                <p>Use one responsive workspace for courses, lessons, assignments, certificates, resources, and learning progress across your current academic schedule.</p>
                <div class="top-actions">
                    <a class="btn btn-primary" href="#courses"><i class="fas fa-book-open"></i> Continue Learning</a>
                    <a class="btn" href="#materials"><i class="fas fa-folder-open"></i> Browse Materials</a>
                </div>
            </div>

            <aside class="focus-panel">
                <p>Overall Completion</p>
                <div class="focus-value">{{ $completionRate }}%</div>
                <div class="progress-track"><span style="width: {{ $completionRate }}%;"></span></div>
                <p style="margin-top:12px;">{{ data_get($stats, 'active_courses', 0) }} active courses and {{ data_get($stats, 'assignments', 0) }} published assignments.</p>
            </aside>
        </section>

        <section class="section">
            <div class="stats-grid">
                <article class="stat-card tone-blue">
                    <i class="fas fa-book-open"></i>
                    <span><strong class="stat-value">{{ data_get($stats, 'active_courses', 0) }}</strong><span class="stat-label">Active Courses</span></span>
                </article>
                <article class="stat-card tone-green">
                    <i class="fas fa-play-circle"></i>
                    <span><strong class="stat-value">{{ data_get($stats, 'lessons', 0) }}</strong><span class="stat-label">Lessons</span></span>
                </article>
                <article class="stat-card tone-amber">
                    <i class="fas fa-tasks"></i>
                    <span><strong class="stat-value">{{ data_get($stats, 'assignments', 0) }}</strong><span class="stat-label">Assignments</span></span>
                </article>
                <article class="stat-card tone-rose">
                    <i class="fas fa-certificate"></i>
                    <span><strong class="stat-value">{{ data_get($stats, 'certificates', 0) }}</strong><span class="stat-label">Certificates</span></span>
                </article>
            </div>
        </section>

        <section class="section workspace">
            <div>
                <div class="section-head" id="courses">
                    <div>
                        <h2>My Courses</h2>
                        <p>Pick up where you left off and scan course activity fast.</p>
                    </div>
                    <a class="btn" href="{{ $routeTo(['filament.admin.resources.course.index']) }}"><i class="fas fa-arrow-right"></i> All Courses</a>
                </div>

                <div class="course-grid" id="courseGrid">
                    @forelse ($courses as $course)
                        @php
                            $title = data_get($course, 'course_name') ?? data_get($course, 'title') ?? 'Untitled Course';
                            $lessonsCount = (int) data_get($course, 'lessons_count', 0);
                            $enrollmentsCount = (int) data_get($course, 'enrollments_count', 0);
                            $progress = min(100, max(12, $lessonsCount ? $lessonsCount * 12 : ($enrollmentsCount * 10)));
                        @endphp
                        <article class="course-card" data-search="{{ strtolower($title . ' ' . data_get($course, 'course_code') . ' ' . data_get($course, 'description')) }}">
                            <div class="course-top">
                                <div>
                                    <h3>{{ $title }}</h3>
                                    <p>{{ \Illuminate\Support\Str::limit(data_get($course, 'description') ?: 'Course materials, lessons, assignments, and progress are ready in your learning workspace.', 110) }}</p>
                                </div>
                                <span class="course-badge">{{ data_get($course, 'course_code') ?? 'Course' }}</span>
                            </div>
                            <div class="course-meta">
                                <span><i class="fas fa-play-circle"></i> {{ $lessonsCount }} lessons</span>
                                <span><i class="fas fa-users"></i> {{ $enrollmentsCount }} learners</span>
                                <span><i class="fas fa-building"></i> {{ data_get($course, 'department.name') ?? 'General' }}</span>
                            </div>
                            <div class="course-footer">
                                <div class="mini-progress"><span style="width: {{ $progress }}%;"></span></div>
                                <strong>{{ $progress }}%</strong>
                            </div>
                        </article>
                    @empty
                        <div class="panel empty">No courses are available yet.</div>
                    @endforelse
                </div>
            </div>

            <aside class="panel" id="assignments">
                <div class="panel-head">
                    <h2>Due Next</h2>
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="panel-body">
                    <div class="assignment-list">
                        @forelse ($assignments as $assignment)
                            <article class="assignment-item">
                                <h3>{{ data_get($assignment, 'title') ?? 'Assignment' }}</h3>
                                <p>{{ data_get($assignment, 'lesson.course.course_name') ?? data_get($assignment, 'lesson.title') ?? 'Course assignment' }}</p>
                                <span class="assignment-date">
                                    <i class="fas fa-clock"></i>
                                    {{ data_get($assignment, 'due_at') ? $assignment->due_at->format('M d, Y') : 'No due date' }}
                                </span>
                            </article>
                        @empty
                            <div class="empty">No published assignments yet.</div>
                        @endforelse
                    </div>
                </div>
            </aside>
        </section>

        <section class="section workspace">
            <section class="panel" id="lessons">
                <div class="panel-head">
                    <h2>Latest Lessons</h2>
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="panel-body">
                    <div class="lesson-list">
                        @forelse ($lessons as $lesson)
                            <article class="lesson-item">
                                <span class="lesson-icon"><i class="fas fa-play"></i></span>
                                <div>
                                    <h3>{{ data_get($lesson, 'title') ?? data_get($lesson, 'module_title') ?? 'Lesson' }}</h3>
                                    <p>{{ data_get($lesson, 'course.course_name') ?? 'Course lesson' }} · {{ data_get($lesson, 'duration_minutes') ?? 15 }} min</p>
                                </div>
                            </article>
                        @empty
                            <div class="empty">No published lessons yet.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <aside class="panel" id="materials">
                <div class="panel-head">
                    <h2>Materials</h2>
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="panel-body">
                    <div class="material-list">
                        @forelse ($materials as $material)
                            <article class="material-item">
                                <span class="material-icon"><i class="fas fa-file-alt"></i></span>
                                <div>
                                    <h3>{{ data_get($material, 'title') ?? 'Learning Material' }}</h3>
                                    <p>{{ data_get($material, 'lesson.course.course_name') ?? data_get($material, 'lesson.title') ?? 'Resource' }}</p>
                                </div>
                            </article>
                        @empty
                            <div class="empty">No learning materials yet.</div>
                        @endforelse
                    </div>
                </div>
            </aside>
        </section>
        </div>

        <div id="tv-schedule-tab-content" style="display: none;">
            <!-- TV Schedule Section -->
            <section class="section" id="tv-schedule" style="scroll-margin-top: 80px;">
                <div class="tv-schedule-container">
                    <div class="tv-schedule-header">
                        <span class="school-badge">* អនុវិទ្យាល័យ ភូមិធំ *</span>
                        <h1 class="tv-schedule-title">កាលវិភាគនៃការចាក់ផ្សាយកម្មវិធីបង្រៀន ពីថ្នាក់ទី៧ ដល់ទី៩</h1>
                        <h2 class="tv-schedule-subtitle">តាមទូរទស្សន៍</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="tv-table">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="bg-header-grey" style="width: 15%;">ម៉ោងចាក់ផ្សាយ<br>(ពេលរសៀល)</th>
                                    <th rowspan="2" class="bg-header-grey" style="width: 8%;">ថ្នាក់ទី</th>
                                    <th colspan="7" class="bg-header-grey" style="border-bottom: none;">ថ្ងៃ</th>
                                </tr>
                                <tr>
                                    <th class="bg-day-cyan">អាទិត្យ</th>
                                    <th class="bg-day-cyan">ចន្ទ</th>
                                    <th class="bg-day-cyan">អង្គារ</th>
                                    <th class="bg-day-cyan">ពុធ</th>
                                    <th class="bg-day-cyan">ព្រហស្បតិ៍</th>
                                    <th class="bg-day-cyan">សុក្រ</th>
                                    <th class="bg-day-cyan">សៅរ៍</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="row-grade-7">
                                    <td>2:00 – 3:00</td>
                                    <td>7</td>
                                    <td>គណិតវិទ្យា</td>
                                    <td>គណិតវិទ្យា</td>
                                    <td>ភាសាខ្មែរ</td>
                                    <td>រូបវិទ្យា</td>
                                    <td>គីមីវិទ្យា</td>
                                    <td>ជីវវិទ្យា</td>
                                    <td>ប្រវត្តិវិទ្យា</td>
                                </tr>
                                <tr class="row-grade-8">
                                    <td>3:00 – 4:00</td>
                                    <td>8</td>
                                    <td>គណិតវិទ្យា</td>
                                    <td>គណិតវិទ្យា</td>
                                    <td>ភាសាខ្មែរ</td>
                                    <td>រូបវិទ្យា</td>
                                    <td>គីមីវិទ្យា</td>
                                    <td>ជីវវិទ្យា</td>
                                    <td>ប្រវត្តិវិទ្យា</td>
                                </tr>
                                <tr class="row-grade-9-1">
                                    <td>4:00 – 5:00</td>
                                    <td>9</td>
                                    <td>គណិតវិទ្យា</td>
                                    <td>គណិតវិទ្យា</td>
                                    <td>រូបវិទ្យា</td>
                                    <td>គណិតវិទ្យា</td>
                                    <td>ប្រវត្តិវិទ្យា</td>
                                    <td>គីមីវិទ្យា</td>
                                    <td>គណិតវិទ្យា</td>
                                </tr>
                                <tr class="row-grade-9-2">
                                    <td>5:00 – 6:00</td>
                                    <td>9</td>
                                    <td>ភាសាខ្មែរ</td>
                                    <td>គណិតវិទ្យា</td>
                                    <td>ភាសាខ្មែរ</td>
                                    <td>គណិតវិទ្យា</td>
                                    <td>ភាសាខ្មែរ</td>
                                    <td>ជីវវិទ្យា</td>
                                    <td>គណិតវិទ្យា</td>
                                </tr>
                                <tr class="row-grade-9-3">
                                    <td>6:00 – 7:00</td>
                                    <td>9</td>
                                    <td>ភាសាខ្មែរ</td>
                                    <td>ជីវវិទ្យា</td>
                                    <td>ភាសាខ្មែរ</td>
                                    <td>គីមីវិទ្យា</td>
                                    <td>ភាសាខ្មែរ</td>
                                    <td>រូបវិទ្យា</td>
                                    <td>ភាសាខ្មែរ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="tv-schedule-footer">
                        <h3>លោកអ្នកអាចចូលទស្សនាវីដេអូមេរៀនតាមរយៈ៖</h3>
                        <ol>
                            <li><strong>ទូរទស្សន៍ជាតិកម្ពុជាទី២ ឬ TVK2</strong> (តាមកាលវិភាគនៃការចាក់ផ្សាយតាមម៉ោងខាងលើ)</li>
                            <li><strong>ការបញ្ជូនបន្តដោយចាក់ផ្សាយឡើងវិញតាម</strong> TV ឬ Dtv ប៉ុស្តិ៍លេខ ២២</li>
                            <li><strong>គេហទំព័រមជ្ឈមណ្ឌលសិក្សាតាមអេឡិចត្រូនិករបស់ក្រសួងអប់រំ</strong> ដែលមានតំណភ្ជាប់៖ <a href="https://elearning.moeys.gov.kh/" target="_blank" rel="noopener noreferrer">https://elearning.moeys.gov.kh/</a></li>
                            <li><strong>បណ្តាញយូធូបរបស់ក្រសួងអប់រំ</strong> ដែលមានតំណភ្ជាប់៖ <a href="https://www.youtube.com/moeys" target="_blank" rel="noopener noreferrer">youtube.com/moeys</a></li>
                        </ol>
                        <div class="hashtags">#elearning #LearningNeverStops</div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

<nav class="bottom-nav" aria-label="Student navigation">
    <a href="#overview" class="is-active"><i class="fas fa-compass"></i><span>Home</span></a>
    <a href="#tv-schedule"><i class="fas fa-tv"></i><span>TV</span></a>
    <a href="#courses"><i class="fas fa-layer-group"></i><span>Courses</span></a>
    <a href="#lessons"><i class="fas fa-play-circle"></i><span>Lessons</span></a>
    <a href="#assignments"><i class="fas fa-tasks"></i><span>Tasks</span></a>
</nav>

<script>
    const searchInput = document.getElementById('courseSearch');
    const courseCards = Array.from(document.querySelectorAll('[data-search]'));

    searchInput?.addEventListener('input', (event) => {
        const query = event.target.value.trim().toLowerCase();

        courseCards.forEach((card) => {
            card.style.display = card.dataset.search.includes(query) ? '' : 'none';
        });
    });

    // Smooth active state swapping and tab routing
    document.addEventListener('DOMContentLoaded', () => {
        const dashboardContent = document.getElementById('dashboard-tab-content');
        const tvScheduleContent = document.getElementById('tv-schedule-tab-content');
        const navLinks = document.querySelectorAll('.nav-link, .bottom-nav a');
        const dashboardSections = dashboardContent.querySelectorAll('section[id], aside[id]');

        function handleRoute() {
            const hash = window.location.hash || '#overview';

            if (hash === '#tv-schedule') {
                dashboardContent.style.display = 'none';
                tvScheduleContent.style.display = 'block';
                window.scrollTo(0, 0);

                navLinks.forEach(link => {
                    link.classList.remove('is-active');
                    if (link.getAttribute('href') === '#tv-schedule') {
                        link.classList.add('is-active');
                    }
                });
            } else {
                tvScheduleContent.style.display = 'none';
                dashboardContent.style.display = 'block';

                if (hash !== '#overview') {
                    const target = document.querySelector(hash);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                } else {
                    window.scrollTo(0, 0);
                }

                updateActiveLinkForDashboard();
            }
        }

        function updateActiveLinkForDashboard() {
            if (window.location.hash === '#tv-schedule') return;

            let current = '';
            const scrollPos = window.scrollY || document.documentElement.scrollTop;

            dashboardSections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (scrollPos >= (sectionTop - 150)) {
                    current = section.getAttribute('id');
                }
            });

            if (current) {
                navLinks.forEach(link => {
                    link.classList.remove('is-active');
                    const href = link.getAttribute('href');
                    if (href === `#${current}`) {
                        link.classList.add('is-active');
                    }
                });
            }
        }

        window.addEventListener('hashchange', handleRoute);
        window.addEventListener('scroll', updateActiveLinkForDashboard);
        handleRoute(); // run initially
    });
</script>
</body>
</html>
