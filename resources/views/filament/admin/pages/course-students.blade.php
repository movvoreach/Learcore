<x-filament-panels::page>
    <style>
        .course-roster-page {
            color: #24304a;
            font-family: "Battambang", "Kantumruy Pro", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 14px;
            line-height: 1.65;
        }

        .course-roster-title {
            margin: 0 0 6px;
            color: #273149;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: 0;
        }

        .course-roster-breadcrumb {
            margin-bottom: 24px;
            color: #929ab0;
            font-size: 12px;
        }

        .course-roster-card {
            border: 1px solid #dce2f0;
            border-radius: 6px;
            background: #fff;
            box-shadow: 0 10px 28px rgba(31, 41, 55, .055);
        }

        .course-roster-summary {
            margin-bottom: 26px;
        }

        .course-roster-summary-main {
            padding: 30px 28px 28px;
            text-align: center;
        }

        .course-roster-summary-main h2 {
            margin: 0;
            color: #1f2a44;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: 0;
        }

        .course-roster-summary-main p {
            margin: 8px 0 0;
            color: #2d3760;
            font-size: 15px;
            font-weight: 500;
        }

        .course-roster-summary-meta {
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

        .course-roster-summary-meta strong {
            color: #47516a;
            font-weight: 700;
        }

        .course-roster-panel-header {
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #e0e5f1;
            padding: 17px 18px;
            color: #4d5872;
            font-size: 15px;
            font-weight: 700;
        }

        .course-roster-add {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 28px;
            border-radius: 4px;
            background: #5865f2;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: 800;
            box-shadow: 0 6px 14px rgba(88, 101, 242, .24);
            transition: background .15s ease, transform .15s ease;
        }

        .course-roster-add:hover {
            background: #4653db;
            transform: translateY(-1px);
        }

        .course-roster-table-wrap {
            padding: 18px;
            overflow-x: auto;
        }

        .course-roster-table {
            width: 100%;
            min-width: 1180px;
            border-collapse: collapse;
            border: 1px solid #1f2937;
            color: #26324d;
            font-size: 12px;
            background: #fff;
        }

        .course-roster-table th {
            border: 1px solid #1f2937;
            background: #e4e7ff;
            padding: 11px 10px;
            text-align: left;
            vertical-align: top;
            color: #303852;
            font-weight: 800;
            line-height: 1.5;
        }

        .course-roster-table td {
            border: 1px solid #1f2937;
            padding: 11px 10px;
            vertical-align: middle;
            line-height: 1.55;
        }

        .course-roster-table tbody tr:hover {
            background: #f8faff;
        }

        .text-center {
            text-align: center;
        }

        .student-link {
            color: #4459f0;
            font-weight: 800;
            text-decoration: none;
        }

        .student-link:hover {
            color: #2738bc;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .muted {
            color: #626b80;
            font-size: 11px;
            line-height: 1.5;
        }

        .score-input {
            width: 68px;
            border: 1px solid #c8d0df;
            border-radius: 5px;
            background: #fff;
            padding: 6px 7px;
            color: #1f2937;
            text-align: center;
            font-weight: 700;
        }

        .score-input:focus {
            outline: none;
            border-color: #5865f2;
            box-shadow: 0 0 0 3px rgba(88, 101, 242, .14);
        }

        .action-row {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 30px;
            min-height: 30px;
            border: 0;
            border-radius: 4px;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: background .15s ease, transform .15s ease, box-shadow .15s ease;
        }

        .action-btn-green {
            min-width: 90px;
            gap: 6px;
            background: #22c55e;
            box-shadow: 0 6px 14px rgba(34, 197, 94, .18);
        }

        .action-btn-red {
            background: #ef233c;
            box-shadow: 0 6px 14px rgba(239, 35, 60, .18);
        }

        .action-btn-blue {
            background: #5865f2;
            box-shadow: 0 6px 14px rgba(88, 101, 242, .18);
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

        .toast {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 9999;
            border-radius: 6px;
            background: #16a34a;
            color: #fff;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 700;
            box-shadow: 0 14px 34px rgba(15, 23, 42, .2);
        }

        @media (max-width: 768px) {
            .course-roster-summary-meta {
                flex-direction: column;
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

        <h1 class="course-roster-title">គ្រប់គ្រងវឌ្ឍនភាព</h1>
        <div class="course-roster-breadcrumb">Home &gt; វគ្គសិក្សា &gt; និស្សិតក្នុងវគ្គ</div>

        <section class="course-roster-card course-roster-summary">
            <div class="course-roster-summary-main">
                <h2>វគ្គសិក្សា</h2>
                <p>ឈ្មោះ: {{ $course->course_name }}</p>
            </div>
            <div class="course-roster-summary-meta">
                <div>
                    <div><strong>លេខកូដវគ្គសិក្សា:</strong> {{ $course->course_code ?? '-' }}</div>
                    <div><strong>កាលបរិច្ឆេទ:</strong> {{ $course->created_at?->format('m/d/Y') ?? '-' }}</div>
                </div>
                <div style="text-align: right;">
                    <div><strong>ឆ្នាំសិក្សា:</strong> {{ $course->academicYear?->year_name ?? '-' }}</div>
                    <div><strong>ឆមាស:</strong> {{ $course->semester?->semester_name ?? '-' }}</div>
                </div>
            </div>
        </section>

        <section class="course-roster-card">
            <div class="course-roster-panel-header">
                <span>និស្សិតក្នុងវគ្គសិក្សា</span>
                <a class="course-roster-add" href="{{ \App\Filament\Admin\Resources\Enrollments\EnrollmentResource::getUrl('create') }}" title="Add enrollment">+</a>
            </div>

            @if($enrollments->isEmpty())
                <div class="empty-state">មិនទាន់មាននិស្សិតចុះឈ្មោះក្នុងវគ្គសិក្សានេះទេ។</div>
            @else
                <div class="course-roster-table-wrap">
                    <table class="course-roster-table">
                        <thead>
                            <tr>
                                <th class="text-center">ល.រ<br><span class="muted">លេខសម្គាល់</span></th>
                                <th>និស្សិត<br><span class="muted">វគ្គសិក្សាអនឡាញ</span></th>
                                <th>គ្រូបង្រៀន<br><span class="muted">លេខកូដ</span></th>
                                <th>ព័ត៌មានវគ្គ<br><span class="muted">វគ្គ / ថ្នាក់</span></th>
                                <th class="text-center">វឌ្ឍនភាព<br><span class="muted">មេរៀនបានរៀន</span></th>
                                <th class="text-center">ពិន្ទុ<br><span class="muted">សរុប</span></th>
                                <th class="text-center">កាលបរិច្ឆេទ<br><span class="muted">ចុះឈ្មោះ</span></th>
                                <th class="text-center">វឌ្ឍនភាព</th>
                                <th class="text-center">លុប</th>
                                <th class="text-center">មើល</th>
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
                                @endphp

                                @if($student)
                                    <tr wire:key="course-roster-row-{{ $enrollment->enrollment_id }}">
                                        <td class="text-center">
                                            <div>{{ $loop->iteration }}</div>
                                            <div class="muted">{{ $student->student_code ?? str_pad((string) $studentId, 4, '0', STR_PAD_LEFT) }}</div>
                                        </td>
                                        <td>
                                            <a class="student-link" href="{{ \App\Filament\Admin\Resources\Students\StudentResource::getUrl('edit', ['record' => $studentId]) }}">
                                                {{ trim(($student->first_name ?? '').' '.($student->last_name ?? '')) ?: 'គ្មានឈ្មោះ' }}
                                            </a>
                                            <div class="muted">{{ $course->course_name }}</div>
                                        </td>
                                        <td>
                                            <a class="student-link" href="#">{{ $teacherName }}</a>
                                            <div class="muted">{{ $course->course_code ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $enrollment->classRoom?->class_name ?? 'Online course' }}</div>
                                            <div class="muted">{{ $course->department?->department_name ?? '-' }}</div>
                                        </td>
                                        <td class="text-center">
                                            <div>{{ $summary['progress'] ?? '0%' }}</div>
                                            <div class="muted">{{ $completedLessons }} / {{ $totalLessons }} មេរៀន</div>
                                        </td>
                                        <td class="text-center">
                                            <input type="number"
                                                   min="0"
                                                   max="100"
                                                   step="0.01"
                                                   class="score-input"
                                                   wire:model.live.debounce.400ms="scores.{{ $studentId }}.assignments"
                                                   title="Assignment score">
                                            <div class="muted">សរុប {{ number_format($totalScore, 0) }}</div>
                                        </td>
                                        <td class="text-center">
                                            <div>{{ $enrollment->enrollment_date?->format('m/d/Y') ?? '-' }}</div>
                                            <div class="muted">{{ $summary['last_activity'] ?? '-' }}</div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button"
                                                    class="action-btn action-btn-green"
                                                    wire:click="saveGrade({{ $studentId }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="saveGrade({{ $studentId }})">
                                                <span wire:loading.remove wire:target="saveGrade({{ $studentId }})">ដាក់ពិន្ទុ</span>
                                                <span wire:loading wire:target="saveGrade({{ $studentId }})">រក្សា...</span>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <a class="action-btn action-btn-red" href="{{ \App\Filament\Admin\Resources\Enrollments\EnrollmentResource::getUrl('edit', ['record' => $enrollment->enrollment_id]) }}" title="Edit enrollment">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-row">
                                                @if($progressId)
                                                    <a class="action-btn action-btn-blue" href="{{ \App\Filament\Admin\Resources\StudentProgresses\StudentProgressResource::getUrl('edit', ['record' => $progressId]) }}" title="Progress detail">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                @else
                                                    <a class="action-btn action-btn-blue" href="{{ \App\Filament\Admin\Resources\StudentProgresses\StudentProgressResource::getUrl('index') }}" title="Progress list">
                                                        <i class="fas fa-ellipsis-v"></i>
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
