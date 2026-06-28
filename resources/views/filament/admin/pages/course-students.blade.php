<x-filament-panels::page>
    <style>
        .cs-page {
            color: #172033;
            font-family: "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
        }

        .cs-header {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .05);
        }

        .cs-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 12px;
        }

        .cs-course-title {
            margin: 0;
            color: #0f172a;
            font-size: 24px;
            font-weight: 900;
            line-height: 1.25;
        }

        .cs-course-code {
            display: inline-block;
            margin-top: 6px;
            padding: 3px 10px;
            border-radius: 6px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 13px;
            font-weight: 850;
        }

        .cs-meta-row,
        .cs-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 14px;
        }

        .cs-pill,
        .cs-stat {
            border: 1px solid #dbe3ef;
            border-radius: 999px;
            background: #f8fafc;
            padding: 6px 12px;
            color: #334155;
            font-size: 12px;
            font-weight: 850;
            white-space: nowrap;
        }

        .cs-stat strong {
            color: #0f172a;
            font-weight: 950;
        }

        .cs-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 32px;
            border-radius: 7px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 850;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }

        .cs-btn-save {
            border: 0;
            background: #16a34a;
            color: #fff;
        }

        .cs-btn-save:hover {
            background: #15803d;
        }

        .cs-btn-back {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        .cs-table-wrap {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, .04);
            overflow-x: auto;
        }

        .cs-table {
            width: 100%;
            min-width: 1420px;
            border-collapse: collapse;
            font-size: 12px;
            white-space: nowrap;
        }

        .cs-table th {
            position: sticky;
            top: 0;
            z-index: 1;
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 9px 10px;
            text-align: left;
            color: #475569;
            font-size: 11px;
            font-weight: 900;
        }

        .cs-table td {
            border-bottom: 1px solid #f1f5f9;
            padding: 9px 10px;
            vertical-align: middle;
        }

        .cs-table tbody tr:hover {
            background: #f8fafc;
        }

        .cs-col-center {
            text-align: center;
        }

        .cs-student-name {
            color: #0f172a;
            font-weight: 900;
        }

        .cs-muted {
            color: #64748b;
            font-size: 11px;
            font-weight: 750;
        }

        .cs-score-input {
            width: 72px;
            padding: 6px 5px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: #fff;
            color: #0f172a;
            font-size: 12px;
            font-weight: 850;
            text-align: center;
        }

        .cs-score-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, .15);
        }

        .cs-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 54px;
            border-radius: 999px;
            padding: 3px 8px;
            font-size: 11px;
            font-weight: 900;
        }

        .cs-badge-good {
            background: #dcfce7;
            color: #166534;
        }

        .cs-badge-bad {
            background: #fee2e2;
            color: #991b1b;
        }

        .cs-badge-neutral {
            background: #e0f2fe;
            color: #075985;
        }

        .cs-empty {
            padding: 38px;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            color: #64748b;
            background: #fff;
            font-size: 15px;
            text-align: center;
        }

        .cs-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            border-radius: 8px;
            background: #16a34a;
            color: #fff;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 850;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .15);
        }
    </style>

    <div class="cs-page"
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
        <div class="cs-toast" x-show="showToast" x-transition x-cloak x-text="toastMessage"></div>

        <div class="cs-header">
            <div class="cs-header-top">
                <div>
                    <h1 class="cs-course-title">{{ $course->course_name }}</h1>
                    <span class="cs-course-code">{{ $course->course_code }}</span>
                </div>
                <a href="{{ \App\Filament\Admin\Resources\Courses\CourseResource::getUrl('index') }}" class="cs-btn cs-btn-back">
                    ត្រឡប់ក្រោយ
                </a>
            </div>

            <div class="cs-meta-row">
                @if($course->department)
                    <span class="cs-pill">ដេប៉ាតឺម៉ង់: {{ $course->department->department_name }}</span>
                @endif
                @if($course->academicYear)
                    <span class="cs-pill">ឆ្នាំសិក្សា: {{ $course->academicYear->year_name }}</span>
                @endif
                @if($course->semester)
                    <span class="cs-pill">ឆមាស: {{ $course->semester->semester_name }}</span>
                @endif
                <span class="cs-pill">គ្រូបង្រៀន: {{ $teacherName }}</span>
            </div>

            <div class="cs-stats">
                <span class="cs-stat">និស្សិតសរុប: <strong>{{ $totalStudents }}</strong></span>
                <span class="cs-stat">កិច្ចការ: <strong>{{ $assignments->count() }}</strong></span>
                <span class="cs-stat">តេស្តខ្លី: <strong>{{ $quizzes->count() }}</strong></span>
                <span class="cs-stat">ប្រឡង: <strong>{{ $exams->count() }}</strong></span>
            </div>
        </div>

        @if($enrollments->isEmpty())
            <div class="cs-empty">មិនទាន់មាននិស្សិតចុះឈ្មោះក្នុងវគ្គសិក្សានេះទេ។</div>
        @else
            <div class="cs-table-wrap">
                <table class="cs-table">
                    <thead>
                        <tr>
                            <th class="cs-col-center">ល.រ</th>
                            <th>និស្សិត</th>
                            <th>វគ្គសិក្សា</th>
                            <th class="cs-col-center">វឌ្ឍនភាព</th>
                            <th class="cs-col-center">វត្តមាន</th>
                            <th class="cs-col-center">កិច្ចការ</th>
                            <th class="cs-col-center">តេស្តខ្លី</th>
                            <th class="cs-col-center">ប្រឡងពាក់កណ្តាល</th>
                            <th class="cs-col-center">ប្រឡងចុងក្រោយ</th>
                            <th class="cs-col-center">គម្រោង</th>
                            <th class="cs-col-center">ពិន្ទុសរុបស្វ័យប្រវត្តិ</th>
                            <th class="cs-col-center">និទ្ទេស</th>
                            <th class="cs-col-center">ស្ថានភាពពិន្ទុ</th>
                            <th class="cs-col-center">ស្ថានភាពសិក្សា</th>
                            <th class="cs-col-center">វិញ្ញាបនបត្រ</th>
                            <th class="cs-col-center">សកម្មភាពចុងក្រោយ</th>
                            <th class="cs-col-center">សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                            @php
                                $student = $enrollment->student;
                                $studentId = (int) $enrollment->student_id;
                                $summary = $studentSummaries->get($studentId, []);
                                $totalScore = (float) ($summary['total_score'] ?? 0);
                                $scoreStatus = (string) ($summary['score_status'] ?? 'ធ្លាក់');
                                $scoreStatusClass = $scoreStatus === 'ជាប់' ? 'cs-badge-good' : 'cs-badge-bad';
                            @endphp

                            @if($student)
                                <tr wire:key="student-score-row-{{ $studentId }}">
                                    <td class="cs-col-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="cs-student-name">{{ trim(($student->first_name ?? '').' '.($student->last_name ?? '')) ?: 'គ្មានឈ្មោះ' }}</div>
                                        <div class="cs-muted">{{ $student->student_code ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $course->course_name }}</div>
                                        <div class="cs-muted">{{ $course->course_code }}</div>
                                    </td>
                                    <td class="cs-col-center">{{ $summary['progress'] ?? '-' }}</td>
                                    <td class="cs-col-center">{{ $summary['attendance'] ?? '-' }}</td>

                                    @foreach(['assignments', 'quizzes', 'midterm', 'final', 'project'] as $category)
                                        <td class="cs-col-center">
                                            <input type="number"
                                                   min="0"
                                                   max="100"
                                                   step="0.01"
                                                   class="cs-score-input"
                                                   aria-label="{{ $scoreLabels[$category] }}"
                                                   wire:model.live.debounce.400ms="scores.{{ $studentId }}.{{ $category }}"
                                                   placeholder="0">
                                        </td>
                                    @endforeach

                                    <td class="cs-col-center">
                                        <strong>{{ number_format($totalScore, 2) }}</strong>
                                    </td>
                                    <td class="cs-col-center">
                                        <span class="cs-badge cs-badge-neutral">{{ $summary['grade'] ?? 'F' }}</span>
                                    </td>
                                    <td class="cs-col-center">
                                        <span class="cs-badge {{ $scoreStatusClass }}">{{ $scoreStatus }}</span>
                                    </td>
                                    <td class="cs-col-center">{{ $summary['enrollment_status'] ?? '-' }}</td>
                                    <td class="cs-col-center">{{ $summary['certificate'] ?? 'មិនទាន់មាន' }}</td>
                                    <td class="cs-col-center">{{ $summary['last_activity'] ?? '-' }}</td>
                                    <td class="cs-col-center">
                                        <button type="button"
                                                class="cs-btn cs-btn-save"
                                                wire:click="saveGrade({{ $studentId }})"
                                                wire:loading.attr="disabled"
                                                wire:target="saveGrade({{ $studentId }})">
                                            <span wire:loading.remove wire:target="saveGrade({{ $studentId }})">រក្សាទុក</span>
                                            <span wire:loading wire:target="saveGrade({{ $studentId }})">កំពុងរក្សា...</span>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-filament-panels::page>
