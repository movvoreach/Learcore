<x-filament-panels::page>
    @once
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
    @endonce

    <style>
        :root {
            --lc-blue: #4db6f2;
            --lc-ink: #1f2937;
            --lc-muted: #64748b;
            --lc-border: #e2e8f0;
            --lc-soft: #f6f9fc;
        }

        .fi-resource-enrollments .fi-page,
        .fi-resource-enrollments .fi-page-content {
            max-width: none !important;
            width: 100% !important;
        }

        .enrollment-detail-show {
            width: 100%;
            min-height: calc(100vh - 7rem);
            background: var(--lc-soft);
            color: var(--lc-ink);
            font-family: "Battambang", "Noto Sans Khmer", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            letter-spacing: 0;
            border-radius: 0;
            padding: 1.5rem;
        }

        .lc-page {
            max-width: none;
            width: 100%;
        }

        .enrollment-detail-show *,
        .enrollment-detail-show *::before,
        .enrollment-detail-show *::after {
            box-sizing: border-box;
        }

        .enrollment-detail-show a {
            color: #2563eb;
            text-decoration: none;
        }

        .enrollment-detail-show a:hover {
            color: #1d4ed8;
        }

        .lc-flex {
            display: flex;
        }

        .lc-stack {
            display: flex;
            flex-direction: column;
        }

        .lc-wrap {
            flex-wrap: wrap;
        }

        .lc-align-start {
            align-items: flex-start;
        }

        .lc-align-center {
            align-items: center;
        }

        .lc-justify-between {
            justify-content: space-between;
        }

        .lc-justify-end {
            justify-content: flex-end;
        }

        .lc-gap-2 {
            gap: .5rem;
        }

        .lc-gap-3 {
            gap: 1rem;
        }

        .lc-gap-4 {
            gap: 1.5rem;
        }

        .lc-mb-0 {
            margin-bottom: 0;
        }

        .lc-mb-1 {
            margin-bottom: .25rem;
        }

        .lc-mb-2 {
            margin-bottom: .5rem;
        }

        .lc-mb-3 {
            margin-bottom: 1rem;
        }

        .lc-mb-4 {
            margin-bottom: 1.5rem;
        }

        .lc-mt-1 {
            margin-top: .25rem;
        }

        .lc-mt-3 {
            margin-top: 1rem;
        }

        .lc-grow {
            flex: 1 1 auto;
            min-width: 0;
        }

        .lc-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 1.5rem;
        }

        .lc-col-12 {
            grid-column: span 12;
        }

        .lc-inner-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .lc-card-body {
            padding: 1rem;
        }

        .lc-card-full {
            height: 100%;
        }

        .lc-detail-card {
            position: relative;
            overflow: hidden;
            min-height: 250px;
            border-color: #d9e5f3;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, .98) 0%, rgba(247, 252, 255, .98) 55%, rgba(235, 247, 255, .96) 100%);
            box-shadow: 0 18px 46px rgba(15, 23, 42, .08);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .lc-detail-card::before {
            position: absolute;
            inset: 0 auto 0 0;
            width: 5px;
            content: "";
            background: linear-gradient(180deg, var(--lc-blue), #00b390);
        }

        .lc-detail-card::after {
            position: absolute;
            right: -72px;
            top: -88px;
            width: 190px;
            height: 190px;
            border-radius: 50%;
            content: "";
            background: rgba(77, 182, 242, .13);
            pointer-events: none;
        }

        .lc-detail-card:hover {
            border-color: #b8dff7;
            box-shadow: 0 22px 54px rgba(15, 23, 42, .12);
            transform: translateY(-2px);
        }

        .lc-detail-card .lc-card-body {
            position: relative;
            z-index: 1;
            padding: 1.25rem 1.35rem 1.35rem;
        }

        .lc-detail-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .75rem;
            margin-bottom: 1rem;
        }

        .lc-detail-kicker {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            color: #0f5f8f;
            font-size: .78rem;
            font-weight: 900;
            line-height: 1;
            text-transform: uppercase;
        }

        .lc-detail-kicker i {
            color: var(--lc-blue);
            font-size: .9rem;
        }

        .lc-detail-title {
            margin-top: .35rem;
            font-size: 1.25rem;
        }

        .lc-info-tile {
            min-height: 66px;
            border: 1px solid #e3edf7;
            border-radius: 8px;
            background: rgba(255, 255, 255, .78);
            padding: .7rem .78rem;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .035);
        }

        .lc-info-tile .lc-label {
            margin-bottom: .18rem;
        }

        .lc-progress-panel {
            margin-top: 1rem;
            border: 1px solid #d9e8f5;
            border-radius: 8px;
            background: rgba(255, 255, 255, .82);
            padding: .85rem;
        }

        .lc-text-secondary {
            color: #64748b;
        }

        .lc-text-end {
            text-align: right;
        }

        .lc-text-break {
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .lc-small {
            font-size: .875rem;
        }

        .lc-fw-bold {
            font-weight: 800;
        }

        .lc-title-sm {
            color: #0f172a;
            font-size: 1.15rem;
            font-weight: 900;
            line-height: 1.35;
            margin: 0;
        }

        .lc-section-title {
            color: #0f172a;
            font-size: 1.45rem;
            font-weight: 900;
            line-height: 1.35;
            margin: 0 0 .25rem;
        }

        .lc-breadcrumb {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .5rem;
            list-style: none;
            margin: 0;
            padding: 0;
            color: #64748b;
            font-size: .875rem;
        }

        .lc-breadcrumb li + li::before {
            content: "/";
            margin-right: .5rem;
            color: #94a3b8;
        }

        .enrollment-detail-title {
            color: #0f172a;
            font-size: 2rem;
            font-weight: 900;
            line-height: 1.25;
            margin: 0 0 1.5rem;
        }

        .lc-card {
            border: 1px solid var(--lc-border);
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 16px 34px rgba(15, 23, 42, .06);
        }

        .lc-media {
            width: 104px;
            height: 104px;
            border: 4px solid #ffffff;
            border-radius: 10px;
            object-fit: cover;
            background: #edf2f7;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .12);
        }

        .lc-course-media {
            width: 132px;
            height: 104px;
            border: 4px solid #ffffff;
            border-radius: 10px;
            object-fit: cover;
            background: #dbeafe;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .12);
        }

        .lc-label {
            color: var(--lc-muted);
            font-size: .8rem;
            font-weight: 700;
        }

        .lc-value {
            color: var(--lc-ink);
            font-weight: 800;
        }

        .lc-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            padding: .35rem .55rem;
            font-size: .75rem;
            font-weight: 900;
            line-height: 1;
            white-space: nowrap;
        }

        .lc-border {
            border: 1px solid var(--lc-border);
        }

        .progress {
            height: 13px;
            border-radius: 999px;
            background: #e8eef6;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #28a745, var(--lc-blue));
            color: #fff;
            text-align: center;
            font-size: .75rem;
            font-weight: 900;
        }

        .status-badge,
        .lesson-badge {
            border-radius: 6px;
            padding: .42rem .62rem;
            font-weight: 800;
            line-height: 1;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            min-height: 34px;
            padding-inline: .8rem;
            box-shadow: 0 10px 20px rgba(15, 23, 42, .12);
        }

        .status-studying,
        .lesson-completed {
            background: #28a745;
            color: #fff;
        }

        .status-completed,
        .lesson-locked {
            background: #dc3545;
            color: #fff;
        }

        .status-cancelled {
            background: #6c757d;
            color: #fff;
        }

        .lesson-progressing {
            background: #4db6f2;
            color: #061826;
        }

        .lesson-not-started {
            background: #e5e7eb;
            color: #374151;
        }

        .type-badge {
            background: #eef6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            border-radius: 6px;
            font-weight: 800;
        }

        .summary-pill {
            min-width: 64px;
            border-radius: 6px;
            padding: .74rem .75rem;
            font-size: .8rem;
            font-weight: 900;
            line-height: 1;
            text-align: center;
        }

        .summary-total {
            background: #ffffff;
            border: 1px solid var(--lc-border);
        }

        .summary-completed {
            background: #198754;
            color: #fff;
        }

        .summary-remaining {
            background: #6c757d;
            color: #fff;
        }

        .module-list {
            display: grid;
            gap: 1rem;
        }

        .module-item {
            border: 1px solid var(--lc-border);
            border-radius: 8px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .035);
        }

        .module-summary {
            min-height: 52px;
            display: flex;
            align-items: center;
            gap: .75rem;
            background: #fff;
            color: var(--lc-ink);
            font-weight: 900;
            padding: .82rem 1.1rem;
            cursor: pointer;
            list-style: none;
            transition: background-color .3s ease, color .3s ease;
        }

        .module-summary::-webkit-details-marker {
            display: none;
        }

        .module-summary::after {
            content: "\f107";
            margin-left: auto;
            color: #0f172a;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            transition: transform .3s ease;
        }

        .module-item[open] .module-summary {
            background: #eaf7ff;
            color: #075985;
        }

        .module-item[open] .module-summary::after {
            transform: rotate(180deg);
            color: #075985;
        }

        .module-title {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .module-count {
            min-width: 76px;
            color: #111827;
            background: #ffffff;
            margin-left: auto;
        }

        .lesson-table-wrap {
            overflow-x: auto;
        }

        .lesson-table {
            width: 100%;
            border-collapse: collapse;
            color: #1f2937;
            background: #ffffff;
            font-size: .9rem;
        }

        .lesson-table th,
        .lesson-table td {
            border-bottom: 1px solid var(--lc-border);
            padding: .85rem .75rem;
            vertical-align: middle;
        }

        .lesson-table thead th {
            background: #f8fafc;
            color: #334155;
            font-size: .78rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .lesson-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .lesson-row {
            transition: background-color .3s ease, transform .3s ease;
        }

        .lesson-row:hover {
            background: #f8fbff;
        }

        .btn-lc-blue {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .25rem;
            background: var(--lc-blue);
            border: 1px solid var(--lc-blue);
            border-radius: 6px;
            color: #061826;
            padding: .38rem .68rem;
            font-size: .85rem;
            font-weight: 900;
        }

        .btn-lc-blue:hover,
        .btn-lc-blue:focus {
            background: #31a8eb;
            border-color: #31a8eb;
            color: #061826;
        }

        .btn-lc-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .25rem;
            border: 1px solid #94a3b8;
            border-radius: 6px;
            background: #ffffff;
            color: #475569;
            padding: .5rem .65rem;
            font-size: .85rem;
            font-weight: 900;
        }

        .btn-lc-outline:disabled {
            cursor: not-allowed;
            opacity: .65;
        }

        .lc-empty {
            padding: 3rem 1.5rem;
            text-align: center;
        }

        @media (min-width: 1200px) {
            .lc-col-xl-6 {
                grid-column: span 6;
            }
        }

        @media (min-width: 992px) {
            .lc-flex-lg-row {
                flex-direction: row;
            }

            .lc-justify-lg-end {
                justify-content: flex-end;
            }
        }

        @media (min-width: 576px) {
            .lc-col-sm-6 {
                grid-column: span 6;
            }
        }

        @media (max-width: 767.98px) {
            .lc-media,
            .lc-course-media {
                width: 78px;
                height: 78px;
            }

            .lc-detail-card {
                min-height: auto;
            }

            .summary-pill {
                flex: 1 1 45%;
            }

            .lesson-actions {
                min-width: 150px;
            }

            .lc-inner-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @php
        $enrollment = $record;
        $student = $enrollment->student;
        $course = $enrollment->course;
        $detail = $this->getDetailData();
        $modules = $detail['modules'];
        $totalLessons = $detail['totalLessons'];
        $completedLessons = $detail['completedLessons'];
        $remainingLessons = $detail['remainingLessons'];
        $progressPercent = $detail['progressPercent'];
        $totalDuration = $detail['totalDuration'];
        $studentPhotoUrl = $detail['studentPhotoUrl'];
        $courseImageUrl = $detail['courseImageUrl'];
        $studentName = trim(($student?->first_name ?? '').' '.($student?->last_name ?? '')) ?: 'Unknown student';
        $instructorName = trim(($course?->instructor?->first_name ?? '').' '.($course?->instructor?->last_name ?? '')) ?: 'Not assigned';
        $enrollmentStatusClass = match ($enrollment->status) {
            'completed' => 'status-completed',
            'cancelled' => 'status-cancelled',
            default => 'status-studying',
        };
        $enrollmentStatusLabel = match ($enrollment->status) {
            'completed' => 'ចប់',
            'cancelled' => 'បានបោះបង់',
            default => 'កំពុងរៀន',
        };
        $completionStatus = $progressPercent >= 100 ? 'Completed' : ($progressPercent > 0 ? 'In Progress' : 'Not Started');
    @endphp

    <main class="enrollment-detail-show lc-page">
        <div class="lc-stack lc-flex-lg-row lc-align-center lc-justify-between lc-gap-3 lc-mb-4">
            <div>
                <nav aria-label="breadcrumb" class="lc-mb-2">
                    <ol class="lc-breadcrumb">
                        <li><a href="{{ url('/admin/enrollments') }}">ការចុះឈ្មោះចូលរៀន</a></li>
                        <li aria-current="page">Detail</li>
                    </ol>
                </nav>
                <h1 class="enrollment-detail-title">Enrollment Detail</h1>
            </div>
        </div>

        <section class="lc-grid lc-mb-4">
            <div class="lc-col-12 lc-col-xl-6">
                <div class="lc-card lc-card-full lc-detail-card">
                    <div class="lc-card-body">
                        <div class="lc-flex lc-gap-3">
                            <img src="{{ $studentPhotoUrl }}" alt="{{ $studentName }}" class="lc-media">
                            <div class="lc-grow">
                                <div class="lc-detail-header">
                                    <div>
                                        <div class="lc-detail-kicker">
                                            <i class="fas fa-user-graduate"></i>
                                            Student Information
                                        </div>
                                        <h2 class="lc-title-sm lc-detail-title">{{ $studentName }}</h2>
                                    </div>
                                    <span class="status-badge {{ $enrollmentStatusClass }}">
                                        <i class="fas fa-circle-check"></i>
                                        {{ $enrollmentStatusLabel }}
                                    </span>
                                </div>
                                <div class="lc-inner-grid lc-mt-1">
                                    <div class="lc-col-12 lc-col-sm-6 lc-info-tile">
                                        <div class="lc-label">Student ID</div>
                                        <div class="lc-value">{{ $student?->student_code ?? '-' }}</div>
                                    </div>
                                    <div class="lc-col-12 lc-col-sm-6 lc-info-tile">
                                        <div class="lc-label">Enrollment Date</div>
                                        <div class="lc-value">{{ $enrollment->enrollment_date?->format('M d, Y') ?? '-' }}</div>
                                    </div>
                                    <div class="lc-col-12 lc-col-sm-6 lc-info-tile">
                                        <div class="lc-label">Email</div>
                                        <div class="lc-value lc-text-break">{{ $student?->email ?? $student?->user?->email ?? '-' }}</div>
                                    </div>
                                    <div class="lc-col-12 lc-col-sm-6 lc-info-tile">
                                        <div class="lc-label">Phone</div>
                                        <div class="lc-value">{{ $student?->phone ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lc-col-12 lc-col-xl-6">
                <div class="lc-card lc-card-full lc-detail-card">
                    <div class="lc-card-body">
                        <div class="lc-flex lc-gap-3">
                            <img src="{{ $courseImageUrl }}" alt="{{ $course?->course_name ?? 'Course' }}" class="lc-course-media">
                            <div class="lc-grow">
                                <div class="lc-detail-header">
                                    <div>
                                        <div class="lc-detail-kicker">
                                            <i class="fas fa-book-open"></i>
                                            Course Information
                                        </div>
                                        <h2 class="lc-title-sm lc-detail-title">{{ $course?->course_name ?? 'No course assigned' }}</h2>
                                    </div>
                                </div>
                                <div class="lc-inner-grid">
                                    <div class="lc-col-12 lc-col-sm-6 lc-info-tile">
                                        <div class="lc-label">Instructor</div>
                                        <div class="lc-value">{{ $instructorName }}</div>
                                    </div>
                                    <div class="lc-col-12 lc-col-sm-6 lc-info-tile">
                                        <div class="lc-label">Category</div>
                                        <div class="lc-value">{{ $course?->category?->category_name ?? '-' }}</div>
                                    </div>
                                    <div class="lc-col-12 lc-col-sm-6 lc-info-tile">
                                        <div class="lc-label">Duration</div>
                                        <div class="lc-value">{{ $totalDuration }} min</div>
                                    </div>
                                    <div class="lc-col-12 lc-col-sm-6 lc-info-tile">
                                        <div class="lc-label">Completion Status</div>
                                        <div class="lc-value">{{ $completionStatus }}</div>
                                    </div>
                                </div>
                                <div class="lc-progress-panel">
                                    <div class="lc-flex lc-justify-between lc-mb-1">
                                        <span class="lc-label">Course Progress</span>
                                        <span class="lc-value">{{ $progressPercent }}%</span>
                                    </div>
                                    <div class="progress" role="progressbar" aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: {{ $progressPercent }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="lc-card lc-mb-4">
            <div class="lc-card-body">
                <div class="lc-stack lc-flex-lg-row lc-justify-between lc-gap-3 lc-mb-3">
                    <div>
                        <h2 class="lc-title-sm lc-mb-1">Course Progress</h2>
                        <p class="lc-text-secondary lc-mb-0">Completed lessons, remaining work, and total course progress.</p>
                    </div>
                    <div class="lc-flex lc-wrap lc-justify-lg-end lc-gap-2">
                        <a href="{{ url('/admin/enrollments') }}" class="btn-lc-outline">
                            <i class="fas fa-arrow-left"></i>Back
                        </a>
                        <span class="summary-pill summary-total">Total: {{ $totalLessons }}</span>
                        <span class="summary-pill summary-completed">Completed: {{ $completedLessons }}</span>
                        <span class="summary-pill summary-remaining">Remaining: {{ $remainingLessons }}</span>
                    </div>
                </div>
                <div class="progress" role="progressbar" aria-label="Course progress" aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" style="width: {{ $progressPercent }}%">{{ $progressPercent }}%</div>
                </div>
            </div>
        </section>

        <section>
            <div class="lc-flex lc-align-center lc-justify-between lc-gap-3 lc-mb-3">
                <div>
                    <h2 class="lc-section-title">Modules & Lessons</h2>
                    <p class="lc-text-secondary lc-mb-0">All lessons grouped by module for this enrolled course.</p>
                </div>
            </div>

            @if($modules->isEmpty())
                <div class="lc-card">
                    <div class="lc-empty">
                        <i class="fas fa-folder-open lc-text-secondary lc-mb-3"></i>
                        <h3 class="lc-title-sm">No lessons found</h3>
                        <p class="lc-text-secondary lc-mb-0">This course does not have published lesson content yet.</p>
                    </div>
                </div>
            @else
                <div class="module-list">
                    @foreach($modules as $module)
                        @php
                            $moduleDomId = 'module-'.$loop->iteration;
                        @endphp
                        <details class="module-item" id="{{ $moduleDomId }}">
                            <summary class="module-summary">
                                <span>Module {{ $module['number'] }}:</span>
                                <span class="module-title">{{ $module['title'] }}</span>
                                <span class="lc-badge module-count lc-border">{{ $module['lessons']->count() }} lessons</span>
                            </summary>
                            <div class="lesson-table-wrap">
                                        <table class="lesson-table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Lesson</th>
                                                    <th>Type</th>
                                                    <th>Duration</th>
                                                    <th>Status</th>
                                                    <th class="lc-text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($module['lessons'] as $lessonItem)
                                                    @php
                                                        $lesson = $lessonItem['model'];
                                                        $lessonStatus = $lessonItem['status'];
                                                        $lessonUrl = \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('show', ['record' => $lesson->content_lesson_id]);
                                                    @endphp
                                                    <tr class="lesson-row">
                                                        <td class="lc-fw-bold">{{ $lessonItem['number'] }}</td>
                                                        <td>
                                                            <div class="lc-fw-bold">{{ $lesson->title }}</div>
                                                            <div class="lc-small lc-text-secondary">{{ $lesson->summary ? \Illuminate\Support\Str::limit(strip_tags($lesson->summary), 90) : 'No summary provided.' }}</div>
                                                        </td>
                                                        <td><span class="lc-badge type-badge">{{ $lessonItem['type'] }}</span></td>
                                                        <td>{{ $lessonItem['duration'] ?: '-' }} min</td>
                                                        <td>
                                                            <span class="lesson-badge lesson-{{ $lessonStatus['class'] }}">
                                                                <i class="fas {{ $lessonStatus['icon'] }}"></i> {{ $lessonStatus['label'] }}
                                                            </span>
                                                        </td>
                                                        <td class="lc-text-end lesson-actions">
                                                            @if($lessonStatus['class'] === 'locked')
                                                                <button class="btn-lc-outline" type="button" disabled>
                                                                    <i class="fas fa-lock"></i>Locked
                                                                </button>
                                                            @else
                                                                <a href="{{ $lessonUrl }}" class="btn-lc-blue">
                                                                    <i class="fas fa-eye"></i>View Lesson
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                            </div>
                        </details>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
</x-filament-panels::page>
