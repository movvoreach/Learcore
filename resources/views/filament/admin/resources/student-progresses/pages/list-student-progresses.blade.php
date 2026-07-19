<x-filament-panels::page>
    <style>
        .progress-course-page {
            color: #24304a;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 14px;
            line-height: 1.65;
        }

        .progress-course-title {
            margin: 0 0 6px;
            color: #273149;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: 0;
        }

        .progress-course-breadcrumb {
            margin-bottom: 24px;
            color: #929ab0;
            font-size: 12px;
        }

        .progress-course-card {
            border: 1px solid #dce2f0;
            border-radius: 6px;
            background: #fff;
            box-shadow: 0 10px 28px rgba(31, 41, 55, .055);
        }

        .progress-course-summary {
            margin-bottom: 26px;
        }

        .progress-course-summary-main {
            padding: 30px 28px 28px;
            text-align: center;
        }

        .progress-course-summary-main h2 {
            margin: 0;
            color: #1f2a44;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: 0;
        }

        .progress-course-summary-main p {
            margin: 8px 0 0;
            color: #2d3760;
            font-size: 15px;
            font-weight: 500;
        }

        .progress-course-summary-meta {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            border-top: 1px solid #e0e5f1;
            background: #fbfcff;
            padding: 18px 22px;
            color: #626b83;
            font-size: 14px;
            line-height: 1.75;
        }

        .progress-course-summary-meta strong {
            color: #47516a;
            font-weight: 700;
        }

        .progress-course-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid #e0e5f1;
            padding: 17px 18px;
            color: #4d5872;
            font-size: 15px;
            font-weight: 700;
        }

        .progress-course-table-wrap {
            padding: 18px;
            overflow-x: auto;
        }

        .progress-course-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid #e0e5f1;
            padding: 14px 18px 18px;
            color: #4d5872;
            font-size: 13px;
        }

        .pagination-actions {
            display: block;
        }

        .pagination {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .page-item {
            margin-left: -1px;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            min-height: 34px;
            border: 1px solid #cfd6e6;
            background: #fff;
            color: #34405b;
            text-decoration: none;
            font-weight: 800;
            line-height: 1;
            transition: background .15s ease, border-color .15s ease, color .15s ease;
        }

        .page-item:first-child .page-link {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .page-item:last-child .page-link {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .page-link:hover {
            border-color: #5865f2;
            background: #f4f6ff;
            color: #2738bc;
            position: relative;
            z-index: 1;
        }

        .page-item.active .page-link {
            border-color: #5865f2;
            background: #5865f2;
            color: #fff;
            position: relative;
            z-index: 2;
        }

        .page-item.disabled .page-link {
            cursor: not-allowed;
            background: #f8fafc;
            color: #98a2b3;
        }

        .progress-course-table {
            width: 100%;
            min-width: 1120px;
            border-collapse: collapse;
            border: 1px solid #1f2937;
            background: #fff;
            color: #26324d;
            font-size: 12px;
        }

        .progress-course-table th {
            border: 1px solid #1f2937;
            background: #e4e7ff;
            padding: 11px 10px;
            color: #303852;
            text-align: left;
            vertical-align: top;
            font-weight: 800;
            line-height: 1.5;
        }

        .progress-course-table td {
            border: 1px solid #1f2937;
            padding: 11px 10px;
            vertical-align: middle;
            line-height: 1.55;
        }

        .progress-course-table tbody tr:hover {
            background: #f8faff;
        }

        .text-center {
            text-align: center;
        }

        .course-link {
            color: #4459f0;
            font-weight: 800;
            text-decoration: none;
        }

        .course-link:hover {
            color: #2738bc;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .muted {
            color: #626b80;
            font-size: 11px;
            line-height: 1.5;
        }

        .progress-meter {
            display: grid;
            gap: 5px;
            min-width: 130px;
        }

        .progress-meter-track {
            height: 7px;
            overflow: hidden;
            border-radius: 999px;
            background: #e5e7eb;
        }

        .progress-meter-fill {
            height: 100%;
            border-radius: inherit;
            background: #22c55e;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 100px;
            min-height: 30px;
            border: 0;
            border-radius: 4px;
            background: #22c55e;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 800;
            box-shadow: 0 6px 14px rgba(34, 197, 94, .18);
            transition: background .15s ease, transform .15s ease, box-shadow .15s ease;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            filter: brightness(.96);
        }

        .empty-state {
            padding: 42px 18px;
            color: #68738a;
            text-align: center;
            font-size: 15px;
        }

        @media (max-width: 768px) {
            .progress-course-summary-meta {
                flex-direction: column;
            }
        }
    </style>

    <div class="progress-course-page">
        <h1 class="progress-course-title">វឌ្ឍនភាពនិស្សិត</h1>
        <div class="progress-course-breadcrumb">Home &gt; វគ្គសិក្សា &gt; វឌ្ឍនភាព</div>

        <section class="progress-course-card progress-course-summary">
            <div class="progress-course-summary-main">
                <h2>សង្ខេបវឌ្ឍនភាពសិក្សា</h2>
                <p>តាមដានវឌ្ឍនភាពនិស្សិតតាមវគ្គសិក្សា មេរៀន និងការចូលរួមសិក្សា។</p>
            </div>
            <div class="progress-course-summary-meta">
                <div>
                    <div><strong>វគ្គសិក្សាសរុប:</strong> {{ $totalCourses }}</div>
                    <div><strong>និស្សិតសរុប:</strong> {{ $totalStudents }}</div>
                </div>
                <div style="text-align: right;">
                    <div><strong>ប្រភេទសិក្សា:</strong> Website learning</div>
                    <div><strong>កាលបរិច្ឆេទ:</strong> {{ now()->format('m/d/Y') }}</div>
                </div>
            </div>
        </section>

        <section class="progress-course-card">
            <div class="progress-course-panel-header">
                <span>បញ្ជីវគ្គសិក្សា</span>
                <span class="muted">មើលវឌ្ឍនភាព និងចំនួននិស្សិតតាមវគ្គ</span>
            </div>

            @if($courses->isEmpty())
                <div class="empty-state">មិនមានវគ្គសិក្សាត្រូវបង្ហាញទេ</div>
            @else
                <div class="progress-course-table-wrap">
                    <table class="progress-course-table">
                        <thead>
                            <tr>
                                <th class="text-center">ល.រ<br><span class="muted">លេខកូដ</span></th>
                                <th>វគ្គសិក្សា<br><span class="muted">ដេប៉ាតឺម៉ង់</span></th>
                                <th>គ្រូបង្រៀន<br><span class="muted">លេខកូដវគ្គ</span></th>
                                <th>ឆ្នាំសិក្សា / ឆមាស<br><span class="muted">ព័ត៌មានសិក្សា</span></th>
                                <th class="text-center">និស្សិត<br><span class="muted">ចុះឈ្មោះ</span></th>
                                <th class="text-center">មេរៀន<br><span class="muted">Online</span></th>
                                <th class="text-center">វឌ្ឍនភាព<br><span class="muted">មធ្យមភាគ</span></th>
                                <th class="text-center">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                                @php
                                    $teacher = $course->courseAssignments->first()?->teacher;
                                    $teacherName = $teacher ? trim($teacher->first_name.' '.$teacher->last_name) : 'មិនទាន់កំណត់';
                                    $averageProgress = round((float) ($course->average_progress_percent ?? 0));
                                @endphp

                                <tr>
                                    <td class="text-center">
                                        <div>{{ $courses->firstItem() + $loop->index }}</div>
                                        <div class="muted">{{ $course->course_code ?? str_pad((string) $course->course_id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </td>
                                    <td>
                                        <a class="course-link" href="{{ \App\Filament\Admin\Pages\CourseStudents::getUrl(['course' => $course->course_id]) }}">
                                            {{ $course->course_name }}
                                        </a>
                                        <div class="muted">{{ $course->department?->department_name ?? 'Online course' }}</div>
                                    </td>
                                    <td>
                                        <a class="course-link" href="#">{{ $teacherName }}</a>
                                        <div class="muted">{{ $course->course_code ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $course->academicYear?->year_name ?? '-' }}</div>
                                        <div class="muted">{{ $course->semester?->semester_name ?? '-' }}</div>
                                    </td>
                                    <td class="text-center">{{ $course->enrollments_count }}</td>
                                    <td class="text-center">{{ $course->published_lessons_count }}</td>
                                    <td class="text-center">
                                        <div class="progress-meter">
                                            <strong>{{ $averageProgress }}%</strong>
                                            <span class="progress-meter-track">
                                                <span class="progress-meter-fill" style="width: {{ min($averageProgress, 100) }}%;"></span>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a class="action-btn" href="{{ \App\Filament\Admin\Pages\CourseStudents::getUrl(['course' => $course->course_id]) }}">
                                            មើលនិស្សិត
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="progress-course-pagination">
                    <div>
                        បង្ហាញ {{ $courses->firstItem() }} ដល់ {{ $courses->lastItem() }} នៃ {{ $courses->total() }} វគ្គសិក្សា
                    </div>
                    <nav class="pagination-actions" aria-label="Course pagination">
                        <ul class="pagination">
                        @if($courses->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $courses->previousPageUrl() }}">Previous</a></li>
                        @endif

                        @foreach($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
                            @if($page === $courses->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        @if($courses->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $courses->nextPageUrl() }}">Next</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Next</span></li>
                        @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
