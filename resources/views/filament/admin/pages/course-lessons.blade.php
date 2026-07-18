<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
    @endonce

    @php
        $modules = $lessons
            ->groupBy(fn ($lesson) => ($lesson->module_number ?: 1).'|'.($lesson->module_title ?: 'Course Module'))
            ->map(function ($moduleLessons, string $key) {
                [$moduleNumber, $moduleTitle] = array_pad(explode('|', $key, 2), 2, 'Course Module');

                return [
                    'number' => (int) $moduleNumber,
                    'title' => $moduleTitle ?: 'Course Module',
                    'lessons' => $moduleLessons->values(),
                    'duration' => (int) $moduleLessons->sum('duration_minutes'),
                ];
            })
            ->sortBy('number')
            ->values();
    @endphp

    <style>
        .course-lessons-page {
            width: 100%;
            color: #0f172a;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            letter-spacing: 0;
            padding: 2px 0 22px;
        }

        .course-lessons-page *,
        .course-lessons-page *::before,
        .course-lessons-page *::after {
            box-sizing: border-box;
            letter-spacing: 0;
        }

        .fi-page-content,
        .fi-page,
        .fi-main {
            max-width: none !important;
        }

        .cl-topbar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .cl-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            color: #64748b;
            font-size: 13px;
            font-weight: 800;
        }

        .cl-title {
            margin: 0;
            color: #081426;
            font-size: 30px;
            font-weight: 900;
            line-height: 1.25;
        }

        .cl-subtitle {
            margin: 6px 0 0;
            color: #475569;
            font-size: 15px;
            font-weight: 500;
        }

        .cl-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 8px;
        }

        .cl-btn,
        .cl-mini-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 36px;
            border: 1px solid #d8e0ec;
            border-radius: 6px;
            background: #ffffff;
            color: #334155;
            padding: 0 12px;
            font-size: 13px;
            font-weight: 900;
            text-decoration: none;
            cursor: pointer;
            transition: background-color .2s ease, border-color .2s ease, color .2s ease, box-shadow .2s ease, transform .2s ease;
        }

        .cl-btn:hover,
        .cl-mini-btn:hover {
            border-color: #4db6f2;
            background: #eaf7ff;
            color: #075985;
            box-shadow: 0 8px 18px rgba(77, 182, 242, .14);
            transform: translateY(-1px);
        }

        .cl-btn-primary {
            border-color: #4db6f2;
            background: #4db6f2;
            color: #061826;
        }

        .cl-btn-danger {
            border-color: #fecdd3;
            background: #fff1f2;
            color: #be123c;
        }

        .cl-btn-danger:hover {
            border-color: #e11d48;
            background: #e11d48;
            color: #ffffff;
        }

        .cl-course-strip {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 24px;
        }

        .cl-stat {
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            background: #ffffff;
            padding: 13px 15px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .045);
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
        }

        .cl-stat:hover {
            border-color: #b7dff8;
            box-shadow: 0 14px 30px rgba(77, 182, 242, .12);
            transform: translateY(-1px);
        }

        .cl-stat-label {
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
        }

        .cl-stat-value {
            margin-top: 4px;
            color: #0f172a;
            font-size: 22px;
            font-weight: 900;
            line-height: 1;
        }

        .cl-module-heading {
            margin: 0 0 16px;
        }

        .cl-module-title {
            margin: 0;
            color: #081426;
            font-size: 24px;
            font-weight: 900;
            line-height: 1.25;
        }

        .cl-module-subtitle {
            margin: 5px 0 0;
            color: #475569;
            font-size: 15px;
        }

        .cl-module-list {
            display: grid;
            gap: 16px;
        }

        .cl-module {
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            background: #ffffff;
            overflow: hidden;
            box-shadow: 0 9px 24px rgba(15, 23, 42, .04);
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
        }

        .cl-module:hover {
            border-color: #bfdff4;
            box-shadow: 0 14px 30px rgba(15, 23, 42, .07);
            transform: translateY(-1px);
        }

        .cl-module-summary {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(86px, 24%) 22px;
            align-items: center;
            gap: 14px;
            min-height: 52px;
            padding: 13px 16px;
            cursor: pointer;
            list-style: none;
            color: #0f172a;
            font-weight: 900;
            transition: background-color .2s ease, color .2s ease;
        }

        .cl-module-summary::-webkit-details-marker {
            display: none;
        }

        .cl-module-summary::after {
            content: "\f107";
            justify-self: end;
            color: #020617;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            transition: transform .2s ease;
        }

        .cl-module[open] .cl-module-summary {
            background: #eaf7ff;
            color: #075985;
        }

        .cl-module[open] .cl-module-summary::after {
            color: #075985;
            transform: rotate(180deg);
        }

        .cl-module-name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cl-count {
            min-width: 72px;
            justify-self: center;
            border: 1px solid #d8e0ec;
            border-radius: 6px;
            background: #ffffff;
            color: #020617;
            padding: 5px 10px;
            text-align: center;
            font-size: 12px;
            font-weight: 900;
            line-height: 1;
        }

        .cl-module-body {
            border-top: 1px solid #dbe3ef;
            background: #f8fbff;
            padding: 14px;
        }

        .cl-lesson-list {
            display: grid;
            gap: 10px;
        }

        .cl-lesson-row {
            display: grid;
            grid-template-columns: 42px minmax(0, 1fr) auto;
            gap: 12px;
            align-items: center;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            padding: 12px;
        }

        .cl-lesson-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #eef6ff;
            color: #075985;
            font-weight: 900;
        }

        .cl-lesson-title {
            color: #0f172a;
            font-size: 15px;
            font-weight: 900;
            line-height: 1.35;
        }

        .cl-lesson-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 6px;
        }

        .cl-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 11px;
            font-weight: 900;
            line-height: 1;
        }

        .cl-badge-type {
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            color: #1d4ed8;
        }

        .cl-badge-published {
            border: 1px solid #bbf7d0;
            background: #dcfce7;
            color: #15803d;
        }

        .cl-badge-draft {
            border: 1px solid #fde68a;
            background: #fef3c7;
            color: #b45309;
        }

        .cl-badge-muted {
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #475569;
        }

        .cl-lesson-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 6px;
        }

        .cl-content-tools {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 10px;
        }

        .cl-empty {
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
            color: #64748b;
            padding: 36px 18px;
            text-align: center;
            font-weight: 700;
        }

        @media (max-width: 1200px) {
            .cl-course-strip {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .cl-topbar,
            .cl-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .cl-course-strip {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .cl-module-summary {
                grid-template-columns: minmax(0, 1fr) auto;
            }

            .cl-module-summary::after {
                display: none;
            }

            .cl-lesson-row {
                grid-template-columns: 1fr;
            }

            .cl-lesson-actions {
                justify-content: flex-start;
            }
        }
    </style>

    <div class="course-lessons-page">
        <header class="cl-topbar">
            <div>
                <span class="cl-kicker">
                    <i class="fas fa-book-open"></i>
                    {{ $course->course_code }}
                </span>
                <h1 class="cl-title">Modules & Lessons</h1>
                <p class="cl-subtitle">All lessons grouped by module for {{ $course->course_name }}.</p>
            </div>

            <div class="cl-actions">
                <a class="cl-btn cl-btn-primary" href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('create', ['course_id' => $course->course_id]) }}">
                    <i class="fas fa-plus"></i>
                    បន្ថែមមេរៀន
                </a>
                <a class="cl-btn" href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('index') }}">
                    <i class="fas fa-list"></i>
                    តារាងមេរៀន
                </a>
                <a class="cl-btn" href="{{ \App\Filament\Admin\Resources\Courses\CourseResource::getUrl('edit', ['record' => $course->course_id]) }}">
                    <i class="fas fa-edit"></i>
                    កែវគ្គសិក្សា
                </a>
            </div>
        </header>

        <section class="cl-course-strip">
            <div class="cl-stat">
                <div class="cl-stat-label">សរុបមេរៀន</div>
                <div class="cl-stat-value">{{ $totalLessons }}</div>
            </div>
            <div class="cl-stat">
                <div class="cl-stat-label">បានផ្សាយ</div>
                <div class="cl-stat-value" style="color:#15803d">{{ $publishedCount }}</div>
            </div>
            <div class="cl-stat">
                <div class="cl-stat-label">សេចក្ដីព្រាង</div>
                <div class="cl-stat-value" style="color:#b45309">{{ $draftCount }}</div>
            </div>
            <div class="cl-stat">
                <div class="cl-stat-label">ជំពូក</div>
                <div class="cl-stat-value" style="color:#2563eb">{{ $totalChapters }}</div>
            </div>
            <div class="cl-stat">
                <div class="cl-stat-label">កិច្ចការ</div>
                <div class="cl-stat-value" style="color:#be123c">{{ $totalAssignments }}</div>
            </div>
            <div class="cl-stat">
                <div class="cl-stat-label">សំណួរ</div>
                <div class="cl-stat-value" style="color:#7c3aed">{{ $totalQuizzes }}</div>
            </div>
        </section>

        <section>
            <div class="cl-module-heading">
                <h2 class="cl-module-title">Modules & Lessons</h2>
                <p class="cl-module-subtitle">All lessons grouped by module for this course.</p>
            </div>

            @if($modules->isEmpty())
                <div class="cl-empty">
                    មិនមានមេរៀនក្នុងវគ្គសិក្សានេះទេ។ ចុច "បន្ថែមមេរៀន" ដើម្បីចាប់ផ្ដើម។
                </div>
            @else
                <div class="cl-module-list">
                    @foreach($modules as $module)
                        <details class="cl-module">
                            <summary class="cl-module-summary">
                                <span class="cl-module-name">Module {{ $module['number'] }}: {{ $module['title'] }}</span>
                                <span class="cl-count">{{ $module['lessons']->count() }} lessons</span>
                            </summary>

                            <div class="cl-module-body">
                                <div class="cl-lesson-list">
                                    @foreach($module['lessons'] as $lesson)
                                        <article class="cl-lesson-row">
                                            <span class="cl-lesson-number">{{ $lesson->position ?: $loop->iteration }}</span>

                                            <div>
                                                <div class="cl-lesson-title">{{ $lesson->title }}</div>
                                                <div class="cl-lesson-meta">
                                                    <span class="cl-badge cl-badge-type">{{ ucfirst($lesson->content_type ?? 'lesson') }}</span>
                                                    @if($lesson->is_published)
                                                        <span class="cl-badge cl-badge-published"><i class="fas fa-check"></i> ផ្សាយ</span>
                                                    @else
                                                        <span class="cl-badge cl-badge-draft">ព្រាង</span>
                                                    @endif
                                                    <span class="cl-badge cl-badge-muted"><i class="fas fa-clock"></i> {{ $lesson->duration_minutes ?: 0 }} min</span>
                                                    <span class="cl-badge cl-badge-muted">{{ $lesson->chapters->count() }} chapters</span>
                                                    <span class="cl-badge cl-badge-muted">{{ $lesson->videos->count() }} videos</span>
                                                    <span class="cl-badge cl-badge-muted">{{ $lesson->documents->count() }} docs</span>
                                                </div>

                                                <div class="cl-content-tools">
                                                    <a href="{{ \App\Filament\Admin\Resources\ContentChapters\ContentChapterResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}" class="cl-mini-btn">ជំពូក</a>
                                                    <a href="{{ \App\Filament\Admin\Resources\ContentVideos\ContentVideoResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}" class="cl-mini-btn">វីដេអូ</a>
                                                    <a href="{{ \App\Filament\Admin\Resources\ContentDocuments\ContentDocumentResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}" class="cl-mini-btn">ឯកសារ</a>
                                                    <a href="{{ \App\Filament\Admin\Resources\ContentAssignments\ContentAssignmentResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}" class="cl-mini-btn">កិច្ចការ</a>
                                                    <a href="{{ \App\Filament\Admin\Resources\Quizzes\QuizResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}" class="cl-mini-btn">សំណួរ</a>
                                                    <a href="{{ \App\Filament\Admin\Resources\ContentResources\ContentResourceResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}" class="cl-mini-btn">ធនធាន</a>
                                                </div>
                                            </div>

                                            <div class="cl-lesson-actions">
                                                <a href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('show', ['record' => $lesson->content_lesson_id]) }}" class="cl-btn">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>
                                                <a href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('edit', ['record' => $lesson->content_lesson_id]) }}" class="cl-btn">
                                                    <i class="fas fa-edit"></i>
                                                    កែសម្រួល
                                                </a>
                                                <button type="button"
                                                        class="cl-btn cl-btn-danger"
                                                        wire:click="deleteLesson({{ $lesson->content_lesson_id }})"
                                                        wire:confirm="តើអ្នកប្រាកដថាចង់លុបមេរៀននេះ?">
                                                    <i class="fas fa-trash"></i>
                                                    លុប
                                                </button>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        </details>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
