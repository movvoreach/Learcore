<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    @endonce

    @php
        $averageProgress = $enrollments->count() > 0
            ? round($enrollments->avg(function ($enrollment) use ($studentSummaries) {
                $summary = $studentSummaries->get((int) $enrollment->student_id, []);
                return (float) str_replace('%', '', (string) ($summary['progress'] ?? 0));
            }))
            : 0;

        $completedStudents = $enrollments->filter(function ($enrollment) use ($studentSummaries) {
            $summary = $studentSummaries->get((int) $enrollment->student_id, []);
            return (float) str_replace('%', '', (string) ($summary['progress'] ?? 0)) >= 100;
        })->count();

        $averageScore = $enrollments->count() > 0
            ? round($enrollments->avg(fn ($enrollment) => (float) ($studentSummaries->get((int) $enrollment->student_id, [])['total_score'] ?? 0)))
            : 0;
    @endphp

    <style>
        .course-roster-page {
            color: #0f172a;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 14px;
            line-height: 1.65;
        }

        .cr-hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 18px;
            align-items: end;
            margin-bottom: 20px;
            padding: 22px;
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            background: linear-gradient(135deg, #ffffff 0%, #eef8ff 100%);
            box-shadow: 0 16px 40px rgba(15, 23, 42, .07);
        }

        .cr-breadcrumb {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 8px;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
        }

        .cr-title {
            margin: 0;
            color: #0f172a;
            font-size: 30px;
            font-weight: 900;
            letter-spacing: 0;
            line-height: 1.35;
        }

        .cr-subtitle {
            margin: 8px 0 0;
            color: #475569;
            font-size: 14px;
        }

        .cr-hero-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 10px;
        }

        .cr-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 40px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #fff;
            color: #0f172a;
            padding: 0 14px;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
        }

        .cr-btn:hover {
            color: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(15, 23, 42, .12);
        }

        .cr-btn-primary {
            border-color: #5866f5;
            background: #5866f5;
            color: #fff;
        }

        .cr-btn-primary:hover {
            background: #4351e6;
            color: #fff;
        }

        .cr-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .cr-stat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            min-height: 104px;
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            background: #fff;
            padding: 18px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, .055);
        }

        .cr-stat span {
            display: block;
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .cr-stat strong {
            display: block;
            margin-top: 4px;
            color: #0f172a;
            font-size: 28px;
            font-weight: 900;
            line-height: 1;
        }

        .cr-stat-icon {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 20px;
            flex: 0 0 auto;
        }

        .cr-card {
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 16px 40px rgba(15, 23, 42, .06);
            overflow: hidden;
        }

        .cr-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 16px 18px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fbff;
        }

        .cr-card-title {
            margin: 0;
            color: #0f172a;
            font-size: 18px;
            font-weight: 900;
        }

        .cr-card-subtitle {
            margin: 3px 0 0;
            color: #64748b;
            font-size: 12px;
        }

        .cr-table-wrap {
            overflow-x: auto;
        }

        .cr-table {
            width: 100%;
            min-width: 1180px;
            border-collapse: separate;
            border-spacing: 0;
            color: #26324d;
            font-size: 13px;
        }

        .cr-table th {
            position: sticky;
            top: 0;
            z-index: 1;
            border-bottom: 1px solid #dbe3ef;
            background: #f8fafc;
            padding: 13px 14px;
            color: #475569;
            font-size: 12px;
            font-weight: 900;
            text-align: left;
            white-space: nowrap;
        }

        .cr-table td {
            border-bottom: 1px solid #eef2f7;
            padding: 14px;
            vertical-align: middle;
        }

        .cr-table tbody tr:hover {
            background: #f8fbff;
        }

        .text-center {
            text-align: center;
        }

        .cr-student {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 220px;
        }

        .cr-avatar {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 13px;
            font-weight: 900;
            flex: 0 0 auto;
        }

        .student-link {
            color: #0f172a;
            font-weight: 900;
            text-decoration: none;
        }

        .student-link:hover {
            color: #2563eb;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .muted {
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.5;
        }

        .cr-progress {
            display: grid;
            gap: 6px;
            min-width: 130px;
        }

        .cr-progress-top {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            color: #0f172a;
            font-size: 12px;
            font-weight: 900;
        }

        .cr-progress-bar {
            height: 8px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .cr-progress-bar span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: #00b390;
        }

        .cr-score {
            display: grid;
            justify-items: center;
            gap: 6px;
        }

        .score-input {
            width: 82px;
            min-height: 38px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #fff;
            padding: 6px 8px;
            color: #0f172a;
            text-align: center;
            font-weight: 900;
        }

        .score-input:focus {
            outline: none;
            border-color: #5866f5;
            box-shadow: 0 0 0 3px rgba(88, 101, 242, .16);
        }

        .cr-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 28px;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 900;
            white-space: nowrap;
        }

        .cr-badge-success {
            background: #dcfce7;
            color: #15803d;
        }

        .cr-badge-warning {
            background: #fff7ed;
            color: #c2410c;
        }

        .action-row {
            display: inline-flex;
            justify-content: center;
            gap: 8px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-width: 36px;
            min-height: 36px;
            border: 0;
            border-radius: 6px;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 900;
            cursor: pointer;
            transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
        }

        .action-btn-green {
            min-width: 88px;
            padding: 0 12px;
            background: #16a34a;
            box-shadow: 0 8px 18px rgba(22, 163, 74, .18);
        }

        .action-btn-red {
            background: #dc3545;
            box-shadow: 0 8px 18px rgba(220, 53, 69, .18);
        }

        .action-btn-blue {
            background: #5866f5;
            box-shadow: 0 8px 18px rgba(88, 102, 245, .18);
        }

        .action-btn:hover {
            color: #fff;
            transform: translateY(-1px);
            filter: brightness(.97);
        }

        .empty-state {
            display: grid;
            justify-items: center;
            gap: 10px;
            padding: 54px 18px;
            color: #64748b;
            text-align: center;
            font-size: 15px;
        }

        .empty-state i {
            color: #94a3b8;
            font-size: 38px;
        }

        .toast {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 9999;
            border-radius: 8px;
            background: #16a34a;
            color: #fff;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 800;
            box-shadow: 0 18px 44px rgba(15, 23, 42, .22);
        }

        .dark .cr-hero,
        .dark .cr-card,
        .dark .cr-stat {
            border-color: #334155;
            background: #1e293b;
        }

        .dark .cr-card-header,
        .dark .cr-table th {
            border-color: #334155;
            background: #0f172a;
        }

        .dark .cr-title,
        .dark .cr-card-title,
        .dark .cr-stat strong,
        .dark .student-link,
        .dark .cr-progress-top {
            color: #f8fafc;
        }

        .dark .cr-subtitle,
        .dark .cr-card-subtitle,
        .dark .muted,
        .dark .cr-breadcrumb {
            color: #94a3b8;
        }

        .dark .cr-table td {
            border-color: #334155;
        }

        .dark .score-input {
            border-color: #334155;
            background: #0f172a;
            color: #f8fafc;
        }

        @media (max-width: 1100px) {
            .cr-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .cr-hero {
                grid-template-columns: 1fr;
            }

            .cr-hero-actions {
                justify-content: flex-start;
            }

            .cr-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="course-roster-page"
         x-data="{
            toastMessage: '',
            showToast: false,
            showNotification(message) {
                this.toastMessage = message;
                this.showToast = true;
                setTimeout(() => this.showToast = false, 3000);
            }
         }"
         @notify.window="showNotification($event.detail.message)">
        <div class="toast" x-show="showToast" x-transition x-cloak x-text="toastMessage"></div>

        <section class="cr-hero">
            <div>
                <div class="cr-breadcrumb">
                    <span>Home</span>
                    <span>/</span>
                    <span>Courses</span>
                    <span>/</span>
                    <span>Students</span>
                </div>
                <h1 class="cr-title">{{ $course->course_name }}</h1>
                <p class="cr-subtitle">
                    {{ $course->course_code ?? '-' }} · {{ $course->department?->department_name ?? '-' }} · {{ $course->academicYear?->year_name ?? '-' }} · {{ $course->semester?->semester_name ?? '-' }}
                </p>
            </div>
            <div class="cr-hero-actions">
                <a class="cr-btn" href="{{ \App\Filament\Admin\Resources\Courses\CourseResource::getUrl('index') }}">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
                <a class="cr-btn cr-btn-primary" href="{{ \App\Filament\Admin\Resources\Enrollments\EnrollmentResource::getUrl('create') }}">
                    <i class="fas fa-user-plus"></i>
                    Add Enrollment
                </a>
            </div>
        </section>

        <section class="cr-stats">
            <article class="cr-stat">
                <div>
                    <span>Total Students</span>
                    <strong>{{ $totalStudents }}</strong>
                </div>
                <div class="cr-stat-icon"><i class="fas fa-users"></i></div>
            </article>
            <article class="cr-stat">
                <div>
                    <span>Completed</span>
                    <strong>{{ $completedStudents }}</strong>
                </div>
                <div class="cr-stat-icon"><i class="fas fa-check-circle"></i></div>
            </article>
            <article class="cr-stat">
                <div>
                    <span>Average Progress</span>
                    <strong>{{ $averageProgress }}%</strong>
                </div>
                <div class="cr-stat-icon"><i class="fas fa-chart-line"></i></div>
            </article>
            <article class="cr-stat">
                <div>
                    <span>Average Score</span>
                    <strong>{{ $averageScore }}</strong>
                </div>
                <div class="cr-stat-icon"><i class="fas fa-star"></i></div>
            </article>
        </section>

        <section class="cr-card">
            <div class="cr-card-header">
                <div>
                    <h2 class="cr-card-title">Course Student Roster</h2>
                    <p class="cr-card-subtitle">Teacher: {{ $teacherName }} · Track lessons, grades, enrollment, and progress from one place.</p>
                </div>
            </div>

            @if($enrollments->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-user-graduate"></i>
                    <strong>No students enrolled in this course yet.</strong>
                    <span>Add an enrollment to start tracking learning progress.</span>
                </div>
            @else
                <div class="cr-table-wrap">
                    <table class="cr-table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Student</th>
                                <th>Teacher</th>
                                <th>Class / Department</th>
                                <th>Lesson Progress</th>
                                <th class="text-center">Assignment Score</th>
                                <th class="text-center">Enrollment</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Save</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $enrollment)
                                @php
                                    $student = $enrollment->student;
                                    $studentId = (int) $enrollment->student_id;
                                    $summary = $studentSummaries->get($studentId, []);
                                    $progressId = $summary['progress_id'] ?? null;
                                    $totalScore = (float) ($summary['total_score'] ?? 0);
                                    $completedLessons = (int) ($summary['completed_lessons'] ?? 0);
                                    $totalLessons = (int) ($summary['total_lessons'] ?? 0);
                                    $progressPercent = (float) str_replace('%', '', (string) ($summary['progress'] ?? 0));
                                    $studentName = trim(($student->first_name ?? '').' '.($student->last_name ?? ''));
                                    $initials = mb_substr($student->first_name ?? 'S', 0, 1).mb_substr($student->last_name ?? '', 0, 1);
                                @endphp

                                @if($student)
                                    <tr wire:key="course-roster-row-{{ $enrollment->enrollment_id }}">
                                        <td class="text-center">
                                            <strong>{{ $loop->iteration }}</strong>
                                            <div class="muted">{{ $student->student_code ?? str_pad((string) $studentId, 4, '0', STR_PAD_LEFT) }}</div>
                                        </td>
                                        <td>
                                            <div class="cr-student">
                                                <div class="cr-avatar">{{ $initials }}</div>
                                                <div>
                                                    <a class="student-link" href="{{ \App\Filament\Admin\Resources\Students\StudentResource::getUrl('edit', ['record' => $studentId]) }}">
                                                        {{ $studentName ?: 'No name' }}
                                                    </a>
                                                    <div class="muted">{{ $student->email ?? $student->phone ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $teacherName }}</strong>
                                            <div class="muted">{{ $course->course_code ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <strong>{{ $enrollment->classRoom?->class_name ?? 'Online course' }}</strong>
                                            <div class="muted">{{ $course->department?->department_name ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <div class="cr-progress">
                                                <div class="cr-progress-top">
                                                    <span>{{ number_format($progressPercent, 0) }}%</span>
                                                    <span>{{ $completedLessons }}/{{ $totalLessons }}</span>
                                                </div>
                                                <div class="cr-progress-bar">
                                                    <span style="width: {{ min(100, max(0, $progressPercent)) }}%"></span>
                                                </div>
                                                <div class="muted">lessons completed</div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="cr-score">
                                                <input type="number"
                                                       min="0"
                                                       max="100"
                                                       step="0.01"
                                                       class="score-input"
                                                       wire:model.live.debounce.400ms="scores.{{ $studentId }}.assignments"
                                                       title="Assignment score">
                                                <div class="muted">Total {{ number_format($totalScore, 0) }}</div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ $enrollment->enrollment_date?->format('M d, Y') ?? '-' }}</strong>
                                            <div class="muted">{{ $summary['last_activity'] ?? '-' }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="cr-badge {{ $progressPercent >= 100 ? 'cr-badge-success' : 'cr-badge-warning' }}">
                                                {{ $progressPercent >= 100 ? 'Completed' : ($summary['enrollment_status'] ?? 'In Progress') }}
                                            </span>
                                            <div class="muted">{{ $summary['grade'] ?? '-' }} · {{ $summary['score_status'] ?? '-' }}</div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button"
                                                    class="action-btn action-btn-green"
                                                    wire:click="saveGrade({{ $studentId }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="saveGrade({{ $studentId }})">
                                                <span wire:loading.remove wire:target="saveGrade({{ $studentId }})">Save</span>
                                                <span wire:loading wire:target="saveGrade({{ $studentId }})">Saving...</span>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-row">
                                                <a class="action-btn action-btn-red" href="{{ \App\Filament\Admin\Resources\Enrollments\EnrollmentResource::getUrl('edit', ['record' => $enrollment->enrollment_id]) }}" title="Edit enrollment">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($progressId)
                                                    <a class="action-btn action-btn-blue" href="{{ \App\Filament\Admin\Resources\StudentProgresses\StudentProgressResource::getUrl('edit', ['record' => $progressId]) }}" title="Progress detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @else
                                                    <a class="action-btn action-btn-blue" href="{{ \App\Filament\Admin\Resources\StudentProgresses\StudentProgressResource::getUrl('index') }}" title="Progress list">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
