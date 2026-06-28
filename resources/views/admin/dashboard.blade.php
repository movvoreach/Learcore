@extends('admin.layouts.master')

@section('title', 'Learning Dashboard')

@push('styles')
<style>
    .learning-dashboard {
        color: #172033;
    }

    .learning-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.7fr) minmax(280px, .9fr);
        gap: 18px;
        align-items: stretch;
        margin: 18px 0 20px;
    }

    .learning-hero__main,
    .learning-hero__side,
    .learning-panel,
    .learning-action {
        border: 1px solid rgba(22, 32, 51, .08);
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 14px 32px rgba(22, 32, 51, .06);
    }

    .learning-hero__main {
        position: relative;
        overflow: hidden;
        padding: 28px;
        background:
            linear-gradient(135deg, rgba(11, 116, 222, .94), rgba(13, 148, 136, .90)),
            url("{{ asset('backend/dist/img/photo1.png') }}");
        background-size: cover;
        background-position: center;
        color: #fff;
        min-height: 230px;
    }

    .learning-hero__main h1 {
        max-width: 620px;
        margin: 0;
        font-size: 34px;
        line-height: 1.25;
        font-weight: 800;
        letter-spacing: 0;
    }

    .learning-hero__main p {
        max-width: 700px;
        margin: 12px 0 22px;
        color: rgba(255, 255, 255, .88);
        font-size: 16px;
    }

    .learning-hero__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .learning-hero__side {
        padding: 22px;
        display: grid;
        align-content: space-between;
        gap: 18px;
    }

    .learning-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .84);
    }

    .learning-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 40px;
        padding: 9px 14px;
        border-radius: 6px;
        border: 1px solid transparent;
        font-weight: 700;
        text-decoration: none;
        transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
    }

    .learning-btn:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }

    .learning-btn--light {
        background: #fff;
        color: #0b63ce;
    }

    .learning-btn--outline {
        border-color: rgba(255, 255, 255, .48);
        color: #fff;
        background: rgba(255, 255, 255, .10);
    }

    .learning-btn--outline:hover {
        color: #fff;
        background: rgba(255, 255, 255, .18);
    }

    .learning-health__label,
    .learning-section-label {
        margin: 0;
        color: #697386;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .learning-health__value {
        margin: 8px 0 4px;
        font-size: 42px;
        line-height: 1;
        font-weight: 850;
        color: #111827;
    }

    .learning-health__caption {
        margin: 0;
        color: #697386;
    }

    .learning-progress {
        height: 10px;
        overflow: hidden;
        border-radius: 999px;
        background: #e8edf5;
    }

    .learning-progress span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #0b74de, #10b981);
    }

    .learning-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 20px;
    }

    .learning-stat {
        display: grid;
        grid-template-columns: 52px minmax(0, 1fr);
        gap: 14px;
        align-items: center;
        min-height: 112px;
        padding: 18px;
        border-radius: 8px;
        background: #fff;
        border: 1px solid rgba(22, 32, 51, .08);
        box-shadow: 0 12px 24px rgba(22, 32, 51, .05);
        color: #172033;
    }

    .learning-stat:hover {
        color: #172033;
        text-decoration: none;
        border-color: rgba(11, 116, 222, .28);
    }

    .learning-stat__icon {
        display: grid;
        place-items: center;
        width: 52px;
        height: 52px;
        border-radius: 8px;
        font-size: 22px;
    }

    .learning-stat__icon--blue { background: #e7f1ff; color: #0b63ce; }
    .learning-stat__icon--green { background: #e7f8ef; color: #118853; }
    .learning-stat__icon--amber { background: #fff4db; color: #a15c00; }
    .learning-stat__icon--rose { background: #ffecef; color: #c42d4b; }
    .learning-stat__icon--indigo { background: #eef2ff; color: #4338ca; }
    .learning-stat__icon--cyan { background: #e5fbff; color: #087f91; }
    .learning-stat__icon--slate { background: #eef2f7; color: #334155; }

    .learning-stat__value {
        display: block;
        color: #111827;
        font-size: 29px;
        line-height: 1;
        font-weight: 850;
    }

    .learning-stat__label {
        display: block;
        margin-top: 6px;
        color: #697386;
        font-size: 14px;
        font-weight: 700;
    }

    .learning-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(320px, .8fr);
        gap: 18px;
        align-items: start;
    }

    .learning-panel {
        overflow: hidden;
        margin-bottom: 18px;
    }

    .learning-panel__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 17px 20px;
        border-bottom: 1px solid #edf1f7;
    }

    .learning-panel__header h2 {
        margin: 0;
        color: #111827;
        font-size: 18px;
        font-weight: 800;
    }

    .learning-panel__body {
        padding: 18px 20px;
    }

    .learning-table {
        margin: 0;
    }

    .learning-table th {
        border-top: 0;
        color: #697386;
        font-size: 12px;
        text-transform: uppercase;
    }

    .learning-table td {
        vertical-align: middle;
    }

    .course-list {
        display: grid;
        gap: 16px;
    }

    .course-item {
        display: grid;
        gap: 9px;
    }

    .course-item__top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .course-title {
        margin: 0;
        color: #111827;
        font-size: 15px;
        font-weight: 800;
    }

    .course-meta {
        margin: 3px 0 0;
        color: #697386;
        font-size: 13px;
    }

    .learning-empty {
        padding: 28px 16px;
        color: #697386;
        text-align: center;
    }

    .learning-actions {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 28px;
    }

    .learning-action {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 16px;
        color: #172033;
        text-decoration: none;
    }

    .learning-action:hover {
        color: #172033;
        text-decoration: none;
        border-color: rgba(11, 116, 222, .28);
    }

    .learning-action i {
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        border-radius: 8px;
        background: #eef2f7;
        color: #0b63ce;
        font-size: 18px;
    }

    .learning-action strong {
        display: block;
        font-size: 14px;
        font-weight: 800;
    }

    .learning-action span {
        display: block;
        margin-top: 2px;
        color: #697386;
        font-size: 12px;
    }

    @media (max-width: 1199px) {
        .learning-stat-grid,
        .learning-actions {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px) {
        .learning-hero,
        .learning-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575px) {
        .learning-hero__main {
            padding: 22px;
        }

        .learning-hero__main h1 {
            font-size: 26px;
        }

        .learning-stat-grid,
        .learning-actions {
            grid-template-columns: 1fr;
        }

        .learning-panel__header,
        .course-item__top {
            display: grid;
        }
    }
</style>
@endpush

@section('content')
@php
    $routeTo = function (array $names, string $fallback = '/admin') {
        foreach ($names as $name) {
            if (\Illuminate\Support\Facades\Route::has($name)) {
                return route($name);
            }
        }

        return url($fallback);
    };

    $links = [
        'dashboard' => $routeTo(['dashboard', 'filament.admin.pages.dashboard']),
        'courses' => $routeTo(['course.index', 'filament.admin.resources.course.index']),
        'students' => $routeTo(['students.list', 'filament.admin.resources.students.index']),
        'progress' => $routeTo(['progress.index', 'filament.admin.resources.student-progresses.index']),
        'enrollments' => $routeTo(['enrollments.index', 'filament.admin.resources.enrollments.index']),
        'certificates' => $routeTo(['certificates.index', 'filament.admin.resources.certificates.index']),
        'materials' => $routeTo(['media-files.index', 'filament.admin.resources.content-resources.index']),
        'materialsCreate' => $routeTo(['media-files.create', 'filament.admin.resources.content-resources.create']),
        'notificationsCreate' => $routeTo(['notifications.create'], '/admin'),
        'forumsCreate' => $routeTo(['forums.create'], '/admin'),
        'forums' => $routeTo(['forums.index'], '/admin'),
    ];

    $completionRate = (int) data_get($stats, 'lesson_completion_rate', 0);
    $completionRate = min(100, max(0, $completionRate));
    $recentEnrollmentItems = $recentEnrollments ?? collect();
    $popularCourseItems = $popularCourses ?? collect();

    $primaryStats = [
        ['label' => 'Total Courses', 'value' => data_get($stats, 'courses', 0), 'icon' => 'fas fa-book-open', 'tone' => 'blue', 'url' => $links['courses']],
        ['label' => 'Active Courses', 'value' => data_get($stats, 'active_courses', 0), 'icon' => 'fas fa-check-circle', 'tone' => 'green', 'url' => $links['courses']],
        ['label' => 'Total Students', 'value' => data_get($stats, 'students', 0), 'icon' => 'fas fa-user-graduate', 'tone' => 'amber', 'url' => $links['students']],
        ['label' => 'Lesson Completion', 'value' => $completionRate . '%', 'icon' => 'fas fa-chart-line', 'tone' => 'rose', 'url' => $links['progress']],
    ];

    $learningStats = [
        ['label' => 'Enrollments', 'value' => data_get($stats, 'enrollments', 0), 'icon' => 'fas fa-users', 'tone' => 'indigo', 'url' => $links['enrollments']],
        ['label' => 'Certificates Issued', 'value' => data_get($stats, 'certificates', 0), 'icon' => 'fas fa-certificate', 'tone' => 'green', 'url' => $links['certificates']],
        ['label' => 'Learning Materials', 'value' => data_get($stats, 'media_files', 0), 'icon' => 'fas fa-folder-open', 'tone' => 'cyan', 'url' => $links['materials']],
        ['label' => 'Forum Topics', 'value' => data_get($stats, 'forums', 0), 'icon' => 'fas fa-comments', 'tone' => 'slate', 'url' => $links['forums']],
    ];
@endphp

<div class="learning-dashboard">
    <section class="learning-hero">
        <div class="learning-hero__main">
            <div class="learning-kicker">
                <i class="fas fa-laptop-house"></i>
                Student Learning Center
            </div>
            <h1>Course learning dashboard for students, lessons, progress, and engagement.</h1>
            <p>Monitor active courses, new enrollments, learning materials, certificates, and student completion from one focused view.</p>
            <div class="learning-hero__actions">
                <a href="{{ $links['courses'] }}" class="learning-btn learning-btn--light">
                    <i class="fas fa-layer-group"></i>
                    View Courses
                </a>
                <a href="{{ $links['progress'] }}" class="learning-btn learning-btn--outline">
                    <i class="fas fa-chart-line"></i>
                    Track Progress
                </a>
            </div>
        </div>

        <aside class="learning-hero__side">
            <div>
                <p class="learning-health__label">Learning Completion</p>
                <div class="learning-health__value">{{ $completionRate }}%</div>
                <p class="learning-health__caption">Average lesson completion across tracked student activity.</p>
            </div>
            <div class="learning-progress" aria-label="Lesson completion progress">
                <span style="width: {{ $completionRate }}%;"></span>
            </div>
        </aside>
    </section>

    <section class="learning-stat-grid">
        @foreach ($primaryStats as $item)
            <a href="{{ $item['url'] }}" class="learning-stat">
                <span class="learning-stat__icon learning-stat__icon--{{ $item['tone'] }}">
                    <i class="{{ $item['icon'] }}"></i>
                </span>
                <span>
                    <span class="learning-stat__value">{{ $item['value'] }}</span>
                    <span class="learning-stat__label">{{ $item['label'] }}</span>
                </span>
            </a>
        @endforeach
    </section>

    <section class="learning-stat-grid">
        @foreach ($learningStats as $item)
            <a href="{{ $item['url'] }}" class="learning-stat">
                <span class="learning-stat__icon learning-stat__icon--{{ $item['tone'] }}">
                    <i class="{{ $item['icon'] }}"></i>
                </span>
                <span>
                    <span class="learning-stat__value">{{ $item['value'] }}</span>
                    <span class="learning-stat__label">{{ $item['label'] }}</span>
                </span>
            </a>
        @endforeach
    </section>

    <div class="learning-grid">
        <section class="learning-panel">
            <div class="learning-panel__header">
                <div>
                    <p class="learning-section-label">Student Activity</p>
                    <h2>Recent Enrollments</h2>
                </div>
                <a href="{{ $links['enrollments'] }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-arrow-right mr-1"></i> View All
                </a>
            </div>
            <div class="learning-panel__body p-0">
                <table class="table learning-table table-hover">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentEnrollmentItems as $enrollment)
                            <tr>
                                <td>
                                    <strong>{{ data_get($enrollment, 'student.user.name') ?? data_get($enrollment, 'student.name') ?? 'Unknown Student' }}</strong>
                                </td>
                                <td>{{ data_get($enrollment, 'course.title') ?? data_get($enrollment, 'course.course_name') ?? 'Unknown Course' }}</td>
                                <td>
                                    <span class="badge badge-info">{{ ucfirst(data_get($enrollment, 'status', 'active')) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="learning-empty">
                                    No recent enrollments yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="learning-panel">
            <div class="learning-panel__header">
                <div>
                    <p class="learning-section-label">Course Demand</p>
                    <h2>Popular Courses</h2>
                </div>
                <a href="{{ $links['courses'] }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-arrow-right mr-1"></i> Courses
                </a>
            </div>
            <div class="learning-panel__body">
                <div class="course-list">
                    @forelse ($popularCourseItems as $course)
                        @php
                            $courseTitle = data_get($course, 'title') ?? data_get($course, 'course_name') ?? 'Untitled Course';
                            $enrollmentCount = (int) (data_get($course, 'enrollments_count') ?? data_get($course, 'students_count') ?? 0);
                            $courseProgress = min(100, max(8, $enrollmentCount * 10));
                        @endphp
                        <article class="course-item">
                            <div class="course-item__top">
                                <div>
                                    <h3 class="course-title">{{ $courseTitle }}</h3>
                                    <p class="course-meta">{{ $enrollmentCount }} enrollments</p>
                                </div>
                                <span class="badge badge-light">{{ $enrollmentCount }}</span>
                            </div>
                            <div class="learning-progress">
                                <span style="width: {{ $courseProgress }}%;"></span>
                            </div>
                        </article>
                    @empty
                        <div class="learning-empty">
                            No popular course data yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    <section class="learning-actions">
        <a href="{{ $links['notificationsCreate'] }}" class="learning-action">
            <i class="fas fa-bell"></i>
            <span>
                <strong>Send Notice</strong>
                <span>Update students quickly</span>
            </span>
        </a>
        <a href="{{ $links['materialsCreate'] }}" class="learning-action">
            <i class="fas fa-upload"></i>
            <span>
                <strong>Upload Material</strong>
                <span>Add files for lessons</span>
            </span>
        </a>
        <a href="{{ $links['certificates'] }}" class="learning-action">
            <i class="fas fa-certificate"></i>
            <span>
                <strong>Certificates</strong>
                <span>Review issued awards</span>
            </span>
        </a>
        <a href="{{ $links['forumsCreate'] }}" class="learning-action">
            <i class="fas fa-comments"></i>
            <span>
                <strong>New Forum Topic</strong>
                <span>Start a discussion</span>
            </span>
        </a>
    </section>
</div>
@endsection
