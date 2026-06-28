<x-filament-panels::page>
    <style>
        .lc-lms {
            color: #172033;
            font-family: "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
        }

        .lc-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(280px, .8fr);
            gap: 18px;
            align-items: stretch;
            margin-bottom: 18px;
        }

        .lc-hero-main,
        .lc-side-panel,
        .lc-workspace,
        .lc-module-card,
        .lc-content-card,
        .lc-focus-panel,
        .lc-admin-panel {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .06);
        }

        .lc-hero-main {
            padding: 24px;
        }

        .lc-breadcrumb {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-bottom: 14px;
            color: #64748b;
            font-size: 13px;
            font-weight: 750;
        }

        .lc-breadcrumb button {
            color: #2563eb;
            font-weight: 850;
        }

        .lc-title {
            margin: 0;
            color: #0f172a;
            font-size: 30px;
            font-weight: 900;
            line-height: 1.2;
        }

        .lc-description {
            max-width: 860px;
            margin-top: 12px;
            color: #475569;
            font-size: 15px;
            line-height: 1.75;
        }

        .lc-meta-row,
        .lc-action-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 18px;
        }

        .lc-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 30px;
            border: 1px solid #dbe3ef;
            border-radius: 999px;
            background: #f8fafc;
            padding: 5px 11px;
            color: #334155;
            font-size: 12px;
            font-weight: 850;
            white-space: nowrap;
        }

        .lc-side-panel {
            display: grid;
            gap: 14px;
            padding: 18px;
        }

        .lc-progress-head {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            color: #334155;
            font-size: 13px;
            font-weight: 850;
        }

        .lc-progress-track {
            height: 10px;
            overflow: hidden;
            border-radius: 999px;
            background: #e2e8f0;
        }

        .lc-progress-fill {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: #2563eb;
        }

        .lc-stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .lc-stat {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            background: #f8fafc;
        }

        .lc-stat-label {
            color: #64748b;
            font-size: 12px;
            font-weight: 850;
        }

        .lc-stat-value {
            margin-top: 5px;
            color: #0f172a;
            font-size: 22px;
            font-weight: 950;
        }

        .lc-workspace {
            display: grid;
            grid-template-columns: 320px minmax(0, 1fr);
            min-height: 640px;
            overflow: hidden;
        }

        .lc-sidebar {
            border-right: 1px solid #e2e8f0;
            background: #f8fafc;
            padding: 16px;
        }

        .lc-sidebar-title,
        .lc-section-title {
            margin: 0 0 12px;
            color: #0f172a;
            font-size: 15px;
            font-weight: 950;
        }

        .lc-module-list {
            display: grid;
            gap: 10px;
        }

        .lc-module-card {
            width: 100%;
            padding: 13px;
            text-align: left;
            box-shadow: none;
        }

        .lc-module-card[aria-current="true"] {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .lc-module-kicker {
            color: #64748b;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .lc-module-name {
            margin-top: 4px;
            color: #0f172a;
            font-size: 14px;
            font-weight: 900;
            line-height: 1.35;
        }

        .lc-module-meta {
            margin-top: 8px;
            color: #64748b;
            font-size: 12px;
            font-weight: 750;
        }

        .lc-main {
            display: grid;
            gap: 16px;
            align-content: start;
            padding: 20px;
        }

        .lc-empty {
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            padding: 24px;
            color: #64748b;
            text-align: center;
        }

        .lc-content-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .lc-content-card {
            padding: 14px;
            text-align: left;
            box-shadow: none;
        }

        .lc-content-card[aria-current="true"] {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .lc-type {
            color: #2563eb;
            font-size: 11px;
            font-weight: 950;
            text-transform: uppercase;
        }

        .lc-content-title {
            margin-top: 5px;
            color: #0f172a;
            font-size: 15px;
            font-weight: 900;
            line-height: 1.35;
        }

        .lc-content-sub {
            margin-top: 6px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.5;
        }

        .lc-focus-panel,
        .lc-admin-panel {
            padding: 18px;
        }

        .lc-focus-head {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .lc-focus-title {
            margin: 4px 0 0;
            color: #0f172a;
            font-size: 22px;
            font-weight: 950;
            line-height: 1.25;
        }

        .lc-rich {
            color: #334155;
            font-size: 15px;
            line-height: 1.8;
        }

        .lc-video {
            margin-top: 14px;
            overflow: hidden;
            border-radius: 8px;
            background: #0f172a;
            aspect-ratio: 16 / 9;
        }

        .lc-video iframe {
            width: 100%;
            height: 100%;
        }

        .lc-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 36px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background: #fff;
            padding: 8px 13px;
            color: #334155;
            font-size: 13px;
            font-weight: 900;
            text-decoration: none;
            white-space: nowrap;
        }

        .lc-btn-primary {
            border-color: #2563eb;
            background: #2563eb;
            color: #fff;
        }

        .lc-btn-green {
            border-color: #16a34a;
            background: #16a34a;
            color: #fff;
        }

        .lc-btn-danger {
            border-color: #dc2626;
            background: #dc2626;
            color: #fff;
        }

        .lc-btn:hover {
            filter: brightness(.97);
        }

        .lc-form {
            display: grid;
            gap: 12px;
            margin-top: 14px;
        }

        .lc-input,
        .lc-textarea,
        .lc-select {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background: #fff;
            padding: 9px 11px;
            color: #0f172a;
            font-size: 14px;
        }

        .lc-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .lc-question {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 13px;
            background: #f8fafc;
        }

        .lc-question-title {
            color: #0f172a;
            font-weight: 900;
        }

        .lc-options {
            display: grid;
            gap: 8px;
            margin-top: 10px;
        }

        .lc-option {
            display: flex;
            gap: 8px;
            align-items: center;
            color: #334155;
            font-size: 14px;
        }

        .lc-admin-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            margin-top: 14px;
        }

        .dark .lc-lms { color: #e5e7eb; }
        .dark .lc-hero-main,
        .dark .lc-side-panel,
        .dark .lc-workspace,
        .dark .lc-module-card,
        .dark .lc-content-card,
        .dark .lc-focus-panel,
        .dark .lc-admin-panel {
            border-color: rgba(255, 255, 255, .12);
            background: #111827;
        }
        .dark .lc-sidebar,
        .dark .lc-stat,
        .dark .lc-question {
            border-color: rgba(255, 255, 255, .12);
            background: #0f172a;
        }
        .dark .lc-title,
        .dark .lc-focus-title,
        .dark .lc-sidebar-title,
        .dark .lc-section-title,
        .dark .lc-module-name,
        .dark .lc-content-title,
        .dark .lc-stat-value,
        .dark .lc-question-title { color: #f8fafc; }
        .dark .lc-description,
        .dark .lc-rich,
        .dark .lc-content-sub,
        .dark .lc-module-meta,
        .dark .lc-breadcrumb,
        .dark .lc-stat-label { color: #cbd5e1; }
        .dark .lc-input,
        .dark .lc-textarea,
        .dark .lc-select,
        .dark .lc-btn {
            border-color: rgba(255, 255, 255, .14);
            background: #1f2937;
            color: #f8fafc;
        }

        @media (max-width: 1080px) {
            .lc-hero,
            .lc-workspace {
                grid-template-columns: 1fr;
            }

            .lc-sidebar {
                border-right: 0;
                border-bottom: 1px solid #e2e8f0;
            }
        }

        @media (max-width: 760px) {
            .lc-content-grid,
            .lc-admin-grid,
            .lc-stats {
                grid-template-columns: 1fr;
            }

            .lc-focus-head {
                display: grid;
            }
        }
    </style>

    @php
        $progressValue = min(100, max(0, (int) round($progressPercent)));
        $totalLessons = $lessons->count();
        $totalVideos = $lessons->sum(fn ($lesson) => $lesson->videos->count() + $lesson->chapters->sum(fn ($chapter) => $chapter->videos->count()));
        $totalDocuments = $lessons->sum(fn ($lesson) => $lesson->documents->count() + $lesson->resources->count() + $lesson->chapters->sum(fn ($chapter) => $chapter->documents->count() + $chapter->resources->count()));
        $moduleGroups = $lessons
            ->groupBy(fn ($lesson) => (string) ($lesson->module_number ?? '0'))
            ->map(fn ($items, $key) => [
                'key' => (string) $key,
                'number' => $key === '0' ? null : $key,
                'title' => $items->first()->module_title ?: 'Module '.$key,
                'lessons' => $items,
            ]);
        $firstModuleKey = (string) ($moduleGroups->keys()->first() ?? '');
        $firstLessonId = (int) ($lessons->first()?->content_lesson_id ?? 0);
        $lessonOrder = $lessons->pluck('content_lesson_id')->map(fn ($id) => (int) $id)->values();
        $submittedAssignmentIds = $assignmentSubmissions->keys()->map(fn ($id) => (int) $id)->values();
        $quizAnswerState = $quizzes->pluck('quiz_id')->mapWithKeys(fn ($id) => [(int) $id => []]);
        $assignmentResponseState = $assignments->pluck('content_assignment_id')->mapWithKeys(fn ($id) => [(int) $id => ['response' => null, 'url' => null]]);

        $youtubeEmbed = function (?string $url): ?string {
            if (! $url) {
                return null;
            }

            preg_match('/(?:youtu\.be\/|v=|embed\/)([^&?\/]+)/', $url, $matches);

            return filled($matches[1] ?? null) ? 'https://www.youtube.com/embed/'.$matches[1] : null;
        };

        $assetUrl = fn (?string $path): ?string => $path ? (str_starts_with($path, 'http') ? $path : asset('storage/'.$path)) : null;
    @endphp

    <div
        class="lc-lms"
        x-data="{
            view: 'details',
            activeModule: @js($firstModuleKey),
            activeType: 'lesson',
            activeId: @js($firstLessonId),
            progress: @js($progressValue),
            completed: @js(array_map('intval', $completedLessonIds)),
            lessonOrder: @js($lessonOrder),
            answers: @js($quizAnswerState),
            assignmentResponses: @js($assignmentResponseState),
            submittedAssignments: @js($submittedAssignmentIds),
            setDetails() { this.view = 'details' },
            openModule(key) { this.activeModule = String(key); this.view = 'module' },
            openContent(type, id) {
                this.activeType = type;
                this.activeId = Number(id);
                this.view = 'content';

                if (type === 'lesson') {
                    this.markComplete(id);
                }
            },
            markComplete(id) {
                id = Number(id);

                if (! this.completed.includes(id)) {
                    this.completed.push(id);
                    this.progress = Math.round((this.completed.length / Math.max(1, @js($totalLessons))) * 100);
                }

                this.$wire.saveLearningProgress(this.completed, id);
            },
            isComplete(id) { return this.completed.includes(Number(id)) },
            nextLesson() {
                const index = this.lessonOrder.indexOf(Number(this.activeId));
                if (index >= 0 && index < this.lessonOrder.length - 1) {
                    this.openContent('lesson', this.lessonOrder[index + 1]);
                }
            },
            previousLesson() {
                const index = this.lessonOrder.indexOf(Number(this.activeId));
                if (index > 0) {
                    this.openContent('lesson', this.lessonOrder[index - 1]);
                }
            },
            submitQuiz(id) {
                this.$wire.submitQuiz(Number(id), this.answers[id] || {});
            },
            submitAssignment(id) {
                const payload = this.assignmentResponses[id] || {};
                this.$wire.submitAssignment(Number(id), payload.response || null, payload.url || null);
                if (! this.submittedAssignments.includes(Number(id))) {
                    this.submittedAssignments.push(Number(id));
                }
                this.assignmentResponses[id] = {};
            }
        }"
    >
        <section class="lc-hero">
            <div class="lc-hero-main">
                <div class="lc-breadcrumb">
                    <button type="button" @click="setDetails()">Course List</button>
                    <span>/</span>
                    <button type="button" @click="setDetails()">Course Details</button>
                    <span>/</span>
                    <span x-text="view === 'content' ? 'Content' : (view === 'module' ? 'Module' : 'Overview')"></span>
                </div>

                <h1 class="lc-title">{{ $course->course_name }}</h1>

                <div class="lc-description">
                    {{ $course->description ?: 'This course is organized into modules with lessons, videos, documents, quizzes, and assignments for a complete student learning path.' }}
                </div>

                <div class="lc-meta-row">
                    <span class="lc-pill">{{ $course->course_code }}</span>
                    <span class="lc-pill">{{ $teacherName }}</span>
                    <span class="lc-pill">{{ $course->department?->department_name ?? 'Department N/A' }}</span>
                    <span class="lc-pill">{{ $course->academicYear?->year_name ?? 'Year N/A' }}</span>
                    <span class="lc-pill">{{ $course->semester?->semester_name ?? 'Semester N/A' }}</span>
                </div>

                <div class="lc-action-row">
                    <a class="lc-btn" href="{{ \App\Filament\Admin\Resources\Courses\CourseResource::getUrl('index') }}">Back to courses</a>
                    @if ($isContentManager)
                        <a class="lc-btn lc-btn-primary" href="{{ \App\Filament\Admin\Resources\Courses\CourseResource::getUrl('edit', ['record' => $course]) }}">Manage course</a>
                    @else
                        <button type="button" class="lc-btn lc-btn-primary" @click="openModule(activeModule)">Continue learning</button>
                    @endif
                </div>
            </div>

            <aside class="lc-side-panel">
                <div>
                    <div class="lc-progress-head">
                        <span>{{ $isContentManager ? 'Published content' : 'Course progress' }}</span>
                        <strong x-text="progress + '%'"></strong>
                    </div>
                    <div class="lc-progress-track" style="margin-top: 8px;">
                        <span class="lc-progress-fill" :style="'width:' + progress + '%'"></span>
                    </div>
                </div>

                <div class="lc-stats">
                    <div class="lc-stat">
                        <div class="lc-stat-label">Modules</div>
                        <div class="lc-stat-value">{{ $moduleGroups->count() }}</div>
                    </div>
                    <div class="lc-stat">
                        <div class="lc-stat-label">Lessons</div>
                        <div class="lc-stat-value">{{ $totalLessons }}</div>
                    </div>
                    <div class="lc-stat">
                        <div class="lc-stat-label">Quizzes</div>
                        <div class="lc-stat-value">{{ $quizzes->count() }}</div>
                    </div>
                    <div class="lc-stat">
                        <div class="lc-stat-label">Assignments</div>
                        <div class="lc-stat-value">{{ $assignments->count() }}</div>
                    </div>
                </div>
            </aside>
        </section>

        @if ($isContentManager)
            <section class="lc-admin-panel">
                <h2 class="lc-section-title">Admin Content Management</h2>
                <div class="lc-description" style="margin-top: 0;">
                    Admins and teachers can manage course structure, modules, lessons, content, quizzes, assignments, submissions, grades, and student progress from these tools.
                </div>
                <div class="lc-admin-grid">
                    <a class="lc-btn lc-btn-primary" href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('create') }}">Add lesson</a>
                    <a class="lc-btn" href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('index') }}">Manage lessons</a>
                    <a class="lc-btn" href="{{ \App\Filament\Admin\Resources\ContentChapters\ContentChapterResource::getUrl('index') }}">Manage modules</a>
                    <a class="lc-btn" href="{{ \App\Filament\Admin\Resources\ContentVideos\ContentVideoResource::getUrl('index') }}">Manage videos</a>
                    <a class="lc-btn" href="{{ \App\Filament\Admin\Resources\ContentDocuments\ContentDocumentResource::getUrl('index') }}">Manage documents</a>
                    <a class="lc-btn" href="{{ \App\Filament\Admin\Resources\ContentAssignments\ContentAssignmentResource::getUrl('index') }}">Manage assignments</a>
                    <a class="lc-btn" href="{{ \App\Filament\Admin\Resources\Quizzes\QuizResource::getUrl('index') }}">Manage quizzes</a>
                    <a class="lc-btn" href="{{ \App\Filament\Admin\Resources\AssignmentSubmissions\AssignmentSubmissionResource::getUrl('index') }}">Review submissions</a>
                    <a class="lc-btn" href="{{ \App\Filament\Admin\Resources\AssessmentResults\AssessmentResultResource::getUrl('index') }}">Quiz results</a>
                    <a class="lc-btn" href="{{ \App\Filament\Admin\Resources\AssessmentGrades\AssessmentGradeResource::getUrl('index') }}">Grades</a>
                    <a class="lc-btn" href="{{ \App\Filament\Admin\Resources\StudentProgresses\StudentProgressResource::getUrl('index') }}">Student progress</a>
                </div>
            </section>
        @endif

        <section class="lc-workspace" style="margin-top: 18px;">
            <aside class="lc-sidebar">
                <h2 class="lc-sidebar-title">Modules / Chapters</h2>
                <div class="lc-module-list">
                    @forelse ($moduleGroups as $module)
                        <button type="button" class="lc-module-card" @click="openModule(@js($module['key']))" :aria-current="activeModule === @js($module['key'])">
                            <div class="lc-module-kicker">Module {{ $module['number'] ?? $loop->iteration }}</div>
                            <div class="lc-module-name">{{ $module['title'] }}</div>
                            <div class="lc-module-meta">
                                {{ $module['lessons']->count() }} lessons ·
                                {{ $module['lessons']->sum(fn ($lesson) => $lesson->chapters->count()) }} chapters
                            </div>
                        </button>
                    @empty
                        <div class="lc-empty">No published modules are available yet.</div>
                    @endforelse
                </div>
            </aside>

            <main class="lc-main">
                <div x-show="view === 'details'">
                    <h2 class="lc-section-title">Course Details</h2>
                    <div class="lc-content-grid">
                        @foreach ($moduleGroups as $module)
                            <button type="button" class="lc-content-card" @click="openModule(@js($module['key']))">
                                <div class="lc-type">Module {{ $module['number'] ?? $loop->iteration }}</div>
                                <div class="lc-content-title">{{ $module['title'] }}</div>
                                <div class="lc-content-sub">
                                    {{ $module['lessons']->count() }} lessons,
                                    {{ $module['lessons']->sum(fn ($lesson) => $lesson->quizzes->count()) }} quizzes,
                                    {{ $module['lessons']->sum(fn ($lesson) => $lesson->assignments->count()) }} assignments
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>

                @foreach ($moduleGroups as $module)
                    <div x-show="view === 'module' && activeModule === @js($module['key'])">
                        <h2 class="lc-section-title">{{ $module['title'] }}</h2>
                        <div class="lc-content-grid">
                            @foreach ($module['lessons'] as $lesson)
                                @php
                                    $lessonId = (int) $lesson->content_lesson_id;
                                    $lessonQuestions = $quizQuestionsByLesson->get($lessonId, collect());
                                @endphp

                                <button type="button" class="lc-content-card" @click="openContent('lesson', {{ $lessonId }})" :aria-current="activeType === 'lesson' && activeId === {{ $lessonId }}">
                                    <div class="lc-type">Lesson</div>
                                    <div class="lc-content-title">{{ $lesson->title }}</div>
                                    <div class="lc-content-sub">
                                        {{ $lesson->duration_minutes ?? 0 }} min ·
                                        <span x-show="isComplete({{ $lessonId }})">Completed</span>
                                        <span x-show="! isComplete({{ $lessonId }})">Not started</span>
                                    </div>
                                </button>

                                @foreach ($lesson->chapters as $chapter)
                                    <button type="button" class="lc-content-card" @click="openContent('chapter', {{ (int) $chapter->content_chapter_id }})" :aria-current="activeType === 'chapter' && activeId === {{ (int) $chapter->content_chapter_id }}">
                                        <div class="lc-type">Chapter</div>
                                        <div class="lc-content-title">{{ $chapter->title }}</div>
                                        <div class="lc-content-sub">{{ $chapter->summary ?: 'Open chapter content and linked learning materials.' }}</div>
                                    </button>
                                @endforeach

                                @foreach ($lesson->videos as $video)
                                    <button type="button" class="lc-content-card" @click="openContent('video', {{ (int) $video->content_video_id }})" :aria-current="activeType === 'video' && activeId === {{ (int) $video->content_video_id }}">
                                        <div class="lc-type">Video</div>
                                        <div class="lc-content-title">{{ $video->title }}</div>
                                        <div class="lc-content-sub">{{ $video->description ?: 'Watch the course video.' }}</div>
                                    </button>
                                @endforeach

                                @foreach ($lesson->documents as $document)
                                    <button type="button" class="lc-content-card" @click="openContent('document', {{ (int) $document->content_document_id }})" :aria-current="activeType === 'document' && activeId === {{ (int) $document->content_document_id }}">
                                        <div class="lc-type">Document</div>
                                        <div class="lc-content-title">{{ $document->title }}</div>
                                        <div class="lc-content-sub">{{ $document->description ?: 'Read or download the document.' }}</div>
                                    </button>
                                @endforeach

                                @foreach ($lesson->resources as $resource)
                                    <button type="button" class="lc-content-card" @click="openContent('resource', {{ (int) $resource->content_resource_id }})" :aria-current="activeType === 'resource' && activeId === {{ (int) $resource->content_resource_id }}">
                                        <div class="lc-type">Resource</div>
                                        <div class="lc-content-title">{{ $resource->title }}</div>
                                        <div class="lc-content-sub">{{ $resource->description ?: 'Open supporting learning resource.' }}</div>
                                    </button>
                                @endforeach

                                @foreach ($lesson->quizzes as $quiz)
                                    <button type="button" class="lc-content-card" @click="openContent('quiz', {{ (int) $quiz->quiz_id }})" :aria-current="activeType === 'quiz' && activeId === {{ (int) $quiz->quiz_id }}">
                                        <div class="lc-type">Quiz</div>
                                        <div class="lc-content-title">{{ $quiz->title }}</div>
                                        <div class="lc-content-sub">{{ $lessonQuestions->count() }} questions · Passing {{ number_format((float) $quiz->passing_score, 0) }}%</div>
                                    </button>
                                @endforeach

                                @foreach ($lesson->assignments as $assignment)
                                    <button type="button" class="lc-content-card" @click="openContent('assignment', {{ (int) $assignment->content_assignment_id }})" :aria-current="activeType === 'assignment' && activeId === {{ (int) $assignment->content_assignment_id }}">
                                        <div class="lc-type">Assignment</div>
                                        <div class="lc-content-title">{{ $assignment->title }}</div>
                                        <div class="lc-content-sub">Due {{ $assignment->due_at?->format('M j, Y') ?? 'Anytime' }} · {{ number_format((float) $assignment->max_score, 0) }} pts</div>
                                    </button>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div x-show="view === 'content'">
                    @foreach ($lessons as $lesson)
                        @php
                            $lessonId = (int) $lesson->content_lesson_id;
                            $embedUrl = $youtubeEmbed($lesson->video_url);
                            $lessonEditUrl = \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('edit', ['record' => $lesson]);
                        @endphp
                        <article class="lc-focus-panel" x-show="activeType === 'lesson' && activeId === {{ $lessonId }}">
                            <div class="lc-focus-head">
                                <div>
                                    <div class="lc-type">Lesson</div>
                                    <h2 class="lc-focus-title">{{ $lesson->title }}</h2>
                                </div>
                                <div class="lc-action-row" style="margin-top: 0;">
                                    @if ($isContentManager)
                                        <a class="lc-btn lc-btn-primary" href="{{ $lessonEditUrl }}">Edit lesson</a>
                                    @else
                                        <span class="lc-pill" x-show="isComplete({{ $lessonId }})">Completed</span>
                                    @endif
                                </div>
                            </div>
                            <div class="lc-rich">{!! $lesson->body ?: e($lesson->summary ?: 'No lesson content has been added yet.') !!}</div>
                            @if ($embedUrl)
                                <div class="lc-video">
                                    <iframe src="{{ $embedUrl }}" title="{{ $lesson->title }}" frameborder="0" allowfullscreen></iframe>
                                </div>
                            @endif
                            @unless ($isContentManager)
                                <div class="lc-action-row">
                                    <button type="button" class="lc-btn" @click="previousLesson()">Previous</button>
                                    <button type="button" class="lc-btn lc-btn-primary" @click="nextLesson()">Next</button>
                                </div>
                            @endunless
                        </article>

                        @foreach ($lesson->chapters as $chapter)
                            @php
                                $chapterEmbed = $youtubeEmbed($chapter->video_url ?? null);
                                $chapterEditUrl = \App\Filament\Admin\Resources\ContentChapters\ContentChapterResource::getUrl('edit', ['record' => $chapter]);
                            @endphp
                            <article class="lc-focus-panel" x-show="activeType === 'chapter' && activeId === {{ (int) $chapter->content_chapter_id }}">
                                <div class="lc-focus-head">
                                    <div>
                                        <div class="lc-type">Chapter</div>
                                        <h2 class="lc-focus-title">{{ $chapter->title }}</h2>
                                    </div>
                                    @if ($isContentManager)
                                        <a class="lc-btn lc-btn-primary" href="{{ $chapterEditUrl }}">Edit chapter</a>
                                    @endif
                                </div>
                                <div class="lc-rich">{!! $chapter->content ?: e($chapter->summary ?: 'No chapter content has been added yet.') !!}</div>
                                @if ($chapterEmbed)
                                    <div class="lc-video">
                                        <iframe src="{{ $chapterEmbed }}" title="{{ $chapter->title }}" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                @endif
                            </article>
                        @endforeach

                        @foreach ($lesson->videos as $video)
                            @php $videoEmbed = $youtubeEmbed($video->video_url); @endphp
                            <article class="lc-focus-panel" x-show="activeType === 'video' && activeId === {{ (int) $video->content_video_id }}">
                                <div class="lc-type">Video</div>
                                <h2 class="lc-focus-title">{{ $video->title }}</h2>
                                <div class="lc-rich">{{ $video->description }}</div>
                                @if ($videoEmbed)
                                    <div class="lc-video"><iframe src="{{ $videoEmbed }}" title="{{ $video->title }}" frameborder="0" allowfullscreen></iframe></div>
                                @elseif ($assetUrl($video->video_path))
                                    <div class="lc-video"><video src="{{ $assetUrl($video->video_path) }}" controls style="width: 100%; height: 100%;"></video></div>
                                @endif
                            </article>
                        @endforeach

                        @foreach ($lesson->documents as $document)
                            <article class="lc-focus-panel" x-show="activeType === 'document' && activeId === {{ (int) $document->content_document_id }}">
                                <div class="lc-type">Document</div>
                                <h2 class="lc-focus-title">{{ $document->title }}</h2>
                                <div class="lc-rich">{{ $document->description ?: 'Open the attached document to continue learning.' }}</div>
                                @if ($assetUrl($document->file_path))
                                    <div class="lc-action-row"><a class="lc-btn lc-btn-primary" href="{{ $assetUrl($document->file_path) }}" target="_blank" rel="noopener">Open document</a></div>
                                @endif
                            </article>
                        @endforeach

                        @foreach ($lesson->resources as $resource)
                            <article class="lc-focus-panel" x-show="activeType === 'resource' && activeId === {{ (int) $resource->content_resource_id }}">
                                <div class="lc-type">Resource</div>
                                <h2 class="lc-focus-title">{{ $resource->title }}</h2>
                                <div class="lc-rich">{{ $resource->description ?: 'Open the supporting learning resource.' }}</div>
                                <div class="lc-action-row">
                                    @if ($assetUrl($resource->file_path))
                                        <a class="lc-btn lc-btn-primary" href="{{ $assetUrl($resource->file_path) }}" target="_blank" rel="noopener">Open file</a>
                                    @endif
                                    @if ($resource->external_url)
                                        <a class="lc-btn" href="{{ $resource->external_url }}" target="_blank" rel="noopener">Open link</a>
                                    @endif
                                </div>
                            </article>
                        @endforeach

                        @foreach ($lesson->quizzes as $quiz)
                            @php
                                $questions = $quizQuestionsByLesson->get($lessonId, collect());
                                $quizResult = $quizResults->get($quiz->quiz_id);
                                $quizOpen = (! $quiz->available_from || $quiz->available_from <= now()) && (! $quiz->available_until || $quiz->available_until >= now());
                            @endphp
                            <article class="lc-focus-panel" x-show="activeType === 'quiz' && activeId === {{ (int) $quiz->quiz_id }}">
                                <div class="lc-type">Quiz</div>
                                <h2 class="lc-focus-title">{{ $quiz->title }}</h2>
                                <div class="lc-rich">{!! $quiz->instructions ?: 'Answer the questions and submit your quiz attempt.' !!}</div>

                                @if ($quizResult)
                                    <div class="lc-pill" style="margin-top: 14px;">Submitted · Score {{ number_format((float) $quizResult->total_score, 0) }}%</div>
                                @elseif (! $quizOpen)
                                    <div class="lc-empty" style="margin-top: 14px;">This quiz is not open right now.</div>
                                @elseif ($questions->isEmpty())
                                    <div class="lc-empty" style="margin-top: 14px;">No questions are available for this quiz yet.</div>
                                @elseif (! $isContentManager)
                                    <div class="lc-form">
                                        @foreach ($questions as $question)
                                            <div class="lc-question">
                                                <div class="lc-question-title">{{ $loop->iteration }}. {!! $question->question_text !!}</div>
                                                <div class="lc-options">
                                                    @if ($question->options->isNotEmpty())
                                                        @foreach ($question->options as $option)
                                                            <label class="lc-option">
                                                                <input type="radio" name="quiz_{{ $quiz->quiz_id }}_question_{{ $question->assessment_question_id }}" value="{{ $option->question_option_id }}" x-model="answers[{{ $quiz->quiz_id }}][{{ $question->assessment_question_id }}]">
                                                                <span>{{ $option->option_text }}</span>
                                                            </label>
                                                        @endforeach
                                                    @else
                                                        <input class="lc-input" type="text" x-model="answers[{{ $quiz->quiz_id }}][{{ $question->assessment_question_id }}]">
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                        <button type="button" class="lc-btn lc-btn-primary" @click="submitQuiz({{ (int) $quiz->quiz_id }})">Submit quiz</button>
                                    </div>
                                @endif
                            </article>
                        @endforeach

                        @foreach ($lesson->assignments as $assignment)
                            @php
                                $submission = $assignmentSubmissions->get($assignment->content_assignment_id);
                                $assignmentOpen = $assignment->allow_late_submission || ! $assignment->due_at || $assignment->due_at->endOfDay()->gte(now());
                            @endphp
                            <article class="lc-focus-panel" x-show="activeType === 'assignment' && activeId === {{ (int) $assignment->content_assignment_id }}">
                                <div class="lc-type">Assignment</div>
                                <h2 class="lc-focus-title">{{ $assignment->title }}</h2>
                                <div class="lc-rich">{!! $assignment->instructions ?: 'Complete the task and submit your response.' !!}</div>
                                <div class="lc-meta-row">
                                    <span class="lc-pill">Due {{ $assignment->due_at?->format('M j, Y g:i A') ?? 'Anytime' }}</span>
                                    <span class="lc-pill">{{ number_format((float) $assignment->max_score, 0) }} points</span>
                                </div>
                                @if ($assetUrl($assignment->attachment_path))
                                    <div class="lc-action-row"><a class="lc-btn" href="{{ $assetUrl($assignment->attachment_path) }}" target="_blank" rel="noopener">Open attachment</a></div>
                                @endif

                                @if ($submission)
                                    <div class="lc-pill" style="margin-top: 14px;">Submitted · {{ ucfirst($submission->status) }}</div>
                                @elseif (! $assignmentOpen)
                                    <div class="lc-empty" style="margin-top: 14px;">The submission window has closed.</div>
                                @elseif (! $isContentManager)
                                    <div class="lc-form">
                                        <textarea class="lc-textarea" placeholder="Write your response" x-model="assignmentResponses[{{ $assignment->content_assignment_id }}].response"></textarea>
                                        <input class="lc-input" type="url" placeholder="Attachment link" x-model="assignmentResponses[{{ $assignment->content_assignment_id }}].url">
                                        <button type="button" class="lc-btn lc-btn-green" @click="submitAssignment({{ (int) $assignment->content_assignment_id }})">Submit assignment</button>
                                    </div>
                                @endif
                            </article>
                        @endforeach
                    @endforeach
                </div>
            </main>
        </section>
    </div>
</x-filament-panels::page>
