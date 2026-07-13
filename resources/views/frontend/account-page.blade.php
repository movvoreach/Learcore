@php
    $adminProfileUrl = url('/admin/my-profile');
    $adminDashboardUrl = url('/admin');
    $accountLinks = [
        'dashboard' => route('frontend.account.dashboard'),
        'profile' => route('frontend.account.profile'),
        'edit' => route('frontend.account.edit'),
        'grades' => route('frontend.account.grades'),
        'settings' => route('frontend.account.settings'),
        'notifications' => route('frontend.account.notifications'),
        'calendar' => route('frontend.account.calendar'),
    ];

    $isProfilePage = $section === 'profile';
    $displayName = $student
        ? trim(($student->first_name ?? '').' '.($student->last_name ?? '')) ?: $user->name
        : $user->name;
@endphp

@extends('frontend.layouts.master')

@section('title', $page['title'].' | LearnCore LMS')

@section('content')
    <section class="learning-account-page {{ $isProfilePage ? 'learning-account-page--profile' : '' }}">
        <div class="learning-account-shell {{ $isProfilePage ? 'learning-account-shell--profile' : '' }}">
            @unless($isProfilePage)
            <aside class="learning-account-sidebar">
                <div class="learning-account-user">
                    <img src="{{ $user->avatar ?: asset('backend/dist/img/avatar.png') }}" alt="{{ $displayName }}">
                    <strong>{{ $displayName }}</strong>
                    <span>{{ $user->email }}</span>
                </div>

                <nav class="learning-account-menu" aria-label="Account menu">
                    @foreach($pageMap as $key => $item)
                        <a href="{{ $accountLinks[$key] }}" class="{{ $section === $key ? 'is-active' : '' }}">
                            <i class="{{ $item['icon'] }}"></i>
                            <span>{{ $item['title'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </aside>
            @endunless

            <main class="learning-account-main">
                @if($section !== 'profile')
                <header class="learning-account-hero">
                    <span class="learning-account-icon">
                        <i class="{{ $page['icon'] }}"></i>
                    </span>
                    <div>
                        <h1>{{ $page['title'] }}</h1>
                        <p>{{ $page['description'] }}</p>
                    </div>
                </header>
                @endif

                @if($section === 'dashboard')
                    <div class="learning-account-stats">
                        <article>
                            <span>វគ្គសិក្សា</span>
                            <strong>{{ $enrollments->count() }}</strong>
                        </article>
                        <article>
                            <span>ពិន្ទុ</span>
                            <strong>{{ $grades->count() }}</strong>
                        </article>
                        <article>
                            <span>កាលវិភាគ</span>
                            <strong>{{ $schedules->count() }}</strong>
                        </article>
                    </div>

                    <div class="learning-account-grid">
                        @include('frontend.partials.account.profile-card')
                        @include('frontend.partials.account.courses-card')
                    </div>
                @elseif($section === 'profile')
                    @include('frontend.partials.account.profile-card')
                @elseif($section === 'edit')
                    <article class="learning-account-card">
                        <h2>កែសម្រួលព័ត៌មានគណនី</h2>
                        <p class="learning-account-muted">សម្រាប់សុវត្ថិភាព ការកែប្រែព័ត៌មានផ្ទាល់ខ្លួនត្រូវធ្វើក្នុងផ្ទាំងគ្រប់គ្រងគណនី។</p>
                        <div class="learning-account-actions">
                            <a href="{{ $adminProfileUrl }}" class="btn btn-primary">
                                <i class="fa fa-user-edit me-2"></i> កែសម្រួលប្រវត្តិរូប
                            </a>
                            <a href="{{ $adminDashboardUrl }}" class="btn btn-outline-secondary">
                                <i class="fas fa-tachometer-alt me-2"></i> ទៅផ្ទាំងគ្រប់គ្រង
                            </a>
                        </div>
                    </article>
                @elseif($section === 'grades')
                    @include('frontend.partials.account.grades-card')
                @elseif($section === 'settings')
                    <article class="learning-account-card">
                        <h2>ការកំណត់</h2>
                        <div class="learning-account-list">
                            <div>
                                <strong>ភាសា</strong>
                                <span>{{ session('learning_locale', 'km') === 'km' ? 'ខ្មែរ (km)' : 'English (en)' }}</span>
                            </div>
                            <div>
                                <strong>អ៊ីមែល</strong>
                                <span>{{ $user->email }}</span>
                            </div>
                            <div>
                                <strong>សុវត្ថិភាព</strong>
                                <span>គ្រប់គ្រងពាក្យសម្ងាត់ និងព័ត៌មានគណនីក្នុងផ្ទាំងគ្រប់គ្រង។</span>
                            </div>
                        </div>
                        <div class="learning-account-actions">
                            <a href="{{ route('frontend.language', 'km') }}" class="btn btn-outline-primary">ខ្មែរ</a>
                            <a href="{{ route('frontend.language', 'en') }}" class="btn btn-outline-primary">English</a>
                            <a href="{{ $adminProfileUrl }}" class="btn btn-primary">គ្រប់គ្រងគណនី</a>
                        </div>
                    </article>
                @elseif($section === 'notifications')
                    <article class="learning-account-card">
                        <h2>ការជូនដំណឹង</h2>
                        <div class="learning-account-empty">
                            <i class="fa fa-paper-plane"></i>
                            <strong>មិនទាន់មានការជូនដំណឹងថ្មីទេ</strong>
                            <span>សារពីវគ្គសិក្សា កិច្ចការ និងប្រព័ន្ធនឹងបង្ហាញនៅទីនេះ។</span>
                        </div>
                    </article>
                @elseif($section === 'calendar')
                    @include('frontend.partials.account.calendar-card')
                @endif
            </main>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        @if($isProfilePage)
        .learning-navbar,
        .learning-footer {
            display: none !important;
        }

        .frontend-main {
            padding-top: 0 !important;
        }
        @endif

        .learning-account-page {
            max-width: 1240px;
            margin: 0 auto;
            padding: 42px 24px 86px;
        }

        .learning-account-page--profile {
            max-width: none;
            padding: 0 0 72px;
            background: #fff;
        }

        .learning-account-shell {
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
            gap: 24px;
            align-items: start;
        }

        .learning-account-shell--profile {
            display: block;
        }

        .learning-account-shell--profile .learning-account-main {
            display: block;
        }

        .learning-account-sidebar,
        .learning-account-card,
        .learning-account-hero,
        .learning-account-stats article {
            border: 1px solid #dee2e6;
            border-radius: .75rem;
            background: #fff;
        }

        .learning-account-sidebar {
            position: sticky;
            top: 104px;
            padding: 18px;
        }

        .learning-account-user {
            display: grid;
            justify-items: center;
            gap: 6px;
            padding: 10px 8px 18px;
            border-bottom: 1px solid #edf2f7;
            text-align: center;
        }

        .learning-account-user img {
            width: 74px;
            height: 74px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e9ecef;
        }

        .learning-account-user strong {
            color: #172033;
            font-size: 16px;
        }

        .learning-account-user span,
        .learning-account-muted,
        .learning-account-empty span {
            color: #6c757d;
            font-size: 14px;
        }

        .learning-account-menu {
            display: grid;
            gap: 6px;
            margin-top: 16px;
        }

        .learning-account-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 42px;
            padding: 0 12px;
            border-radius: .5rem;
            color: #334155;
            text-decoration: none;
            font-weight: 700;
        }

        .learning-account-menu a:hover,
        .learning-account-menu a.is-active {
            background: #fff3cd;
            color: #f04d00;
        }

        .learning-account-menu i {
            width: 18px;
            text-align: center;
        }

        .learning-account-main {
            min-width: 0;
            display: grid;
            gap: 20px;
        }

        .learning-account-hero {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 24px;
        }

        .learning-account-icon {
            width: 56px;
            height: 56px;
            display: grid;
            place-items: center;
            border-radius: .75rem;
            background: #fff3cd;
            color: #f04d00;
            font-size: 22px;
            flex: 0 0 56px;
        }

        .learning-account-hero h1,
        .learning-account-card h2 {
            margin: 0;
            color: #172033;
            font-weight: 800;
        }

        .learning-account-hero h1 {
            font-size: 26px;
        }

        .learning-account-hero p {
            margin: 6px 0 0;
            color: #64748b;
        }

        .learning-account-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .learning-account-stats article,
        .learning-account-card {
            padding: 20px;
        }

        .learning-account-stats span {
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .learning-account-stats strong {
            display: block;
            margin-top: 4px;
            color: #f04d00;
            font-size: 28px;
            font-weight: 900;
        }

        .learning-account-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .learning-account-card h2 {
            margin-bottom: 16px;
            font-size: 20px;
        }

        .learning-account-list {
            display: grid;
            gap: 10px;
        }

        .learning-account-list > div {
            display: grid;
            gap: 2px;
            padding: 12px;
            border: 1px solid #edf2f7;
            border-radius: .5rem;
            background: #f8fafc;
        }

        .learning-account-list strong {
            color: #172033;
            font-size: 14px;
        }

        .learning-account-list span {
            color: #64748b;
            font-size: 14px;
        }

        .learning-account-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 18px;
        }

        .learning-account-empty {
            display: grid;
            justify-items: center;
            gap: 8px;
            padding: 34px 18px;
            border: 1px dashed #cbd5e1;
            border-radius: .75rem;
            text-align: center;
        }

        .learning-account-empty i {
            color: #f04d00;
            font-size: 34px;
        }

        .learning-account-table {
            width: 100%;
            margin: 0;
        }

        .learning-account-table th,
        .learning-account-table td {
            vertical-align: middle;
        }

        @media (max-width: 991.98px) {
            .learning-account-shell,
            .learning-account-grid {
                grid-template-columns: 1fr;
            }

            .learning-account-sidebar {
                position: static;
            }
        }

        @media (max-width: 575.98px) {
            .learning-account-page {
                padding: 28px 14px 72px;
            }

            .learning-account-hero {
                align-items: flex-start;
                padding: 18px;
            }

            .learning-account-hero h1 {
                font-size: 22px;
            }

            .learning-account-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush
