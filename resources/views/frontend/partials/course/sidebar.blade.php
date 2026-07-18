@php
    $courseTitle = $courseRecord?->course_name ?? 'Course Not Found';
    $courseImage = !empty($courseRecord?->image) && file_exists(public_path('storage/' . $courseRecord->image))
        ? asset('storage/'.$courseRecord->image)
        : asset('backend/img/course-image-default.png');
    $sidebarLessons = ($lessons ?? collect())->isNotEmpty()
        ? $lessons
        : ($courseRecord?->contentLessons()
            ->publishedForStudents()
            ->with([
                'chapters' => fn ($query) => $query->where('is_published', true)->orderBy('sort_order')->orderBy('content_chapter_id'),
                'assignments' => fn ($query) => $query->where('is_published', true)->orderBy('due_at')->orderBy('content_assignment_id'),
                'quizzes' => fn ($query) => $query->where('is_published', true)->orderBy('available_from')->orderBy('quiz_id'),
            ])
            ->orderBy('module_number')
            ->orderBy('position')
            ->get() ?? collect());
    $modules = $sidebarLessons->groupBy(fn ($contentLesson) => ($contentLesson->module_number ?? 0).'|'.($contentLesson->module_title ?: 'Course Lessons'));
    $learningFlow = $learningFlow ?? [
        'completedIds' => [],
        'unlocked' => [],
        'percent' => 0,
        'moduleProgress' => [],
    ];
    $completedLessonIds = $learningFlow['completedIds'] ?? [];
    $unlockedLessons = $learningFlow['unlocked'] ?? [];
    $moduleProgress = $learningFlow['moduleProgress'] ?? [];
    $compactSidebar = $compactSidebar ?? false;
    $toKhmerNumber = fn ($number): string => strtr((string) $number, [
        '0' => '០',
        '1' => '១',
        '2' => '២',
        '3' => '៣',
        '4' => '៤',
        '5' => '៥',
        '6' => '៦',
        '7' => '៧',
        '8' => '៨',
        '9' => '៩',
    ]);
    $cleanOutlineTitle = function (?string $title, string $fallback = 'Lesson'): string {
        $cleanTitle = trim((string) ($title ?: $fallback));
        $cleanTitle = preg_replace('/^\s*មេរៀនទី\s*[០-៩0-9]+\s*[-–—:]\s*/u', '', $cleanTitle) ?? $cleanTitle;
        $cleanTitle = preg_replace('/^\s*Lesson\s*[0-9]+\s*[-–—:]\s*/i', '', $cleanTitle) ?? $cleanTitle;
        $cleanTitle = preg_replace('/^\s*[0-9]+\.[0-9]+\s*[-–—:]\s*/', '', $cleanTitle) ?? $cleanTitle;

        return $cleanTitle;
    };
    $lessonDisplayTitle = function ($contentLesson, int $moduleNumber) use ($cleanOutlineTitle, $toKhmerNumber): string {
        return 'មេរៀនទី '.$toKhmerNumber($moduleNumber).' - '.$cleanOutlineTitle($contentLesson?->title);
    };
    $lessonDisplayParts = function ($contentLesson, int $fallbackNumber) use ($cleanOutlineTitle, $toKhmerNumber): array {
        $lessonNumber = (int) ($contentLesson?->position ?: $fallbackNumber);

        return [
            'number' => 'មេរៀនទី '.$toKhmerNumber($lessonNumber),
            'title' => $cleanOutlineTitle($contentLesson?->title),
        ];
    };
    $lessonTopics = function ($contentLesson) use ($cleanOutlineTitle) {
        $topics = collect();

        foreach (($contentLesson?->chapters ?? collect()) as $chapter) {
            $topics->push([
                'title' => $cleanOutlineTitle($chapter->title, 'Topic'),
                'panel' => 'document',
            ]);
        }

        foreach (($contentLesson?->quizzes ?? collect()) as $quiz) {
            $topics->push([
                'title' => $cleanOutlineTitle($quiz->title, 'Quiz'),
                'panel' => 'quiz',
            ]);
        }

        foreach (($contentLesson?->assignments ?? collect()) as $assignment) {
            $topics->push([
                'title' => $cleanOutlineTitle($assignment->title, 'Assignment'),
                'panel' => 'assignment',
            ]);
        }

        return $topics;
    };
@endphp

@if($compactSidebar)
<aside class="course-workspace-sidebar">
    <div class="course-workspace-topbar">
        <button type="button" class="course-workspace-icon-btn js-course-sidebar-close" aria-label="Close lesson menu">
            <i class="fas fa-times"></i>
        </button>
        <div class="course-workspace-more">
            <button type="button" class="course-workspace-icon-btn js-course-more-toggle" aria-label="More options" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="course-workspace-more-menu" aria-hidden="true">
                <a href="{{ route('frontend.courses.show', $course ?? $courseRecord?->getKey()) }}">
                    <i class="fas fa-angle-double-down"></i>
                    <span>មេរៀនទាំងអស់</span>
                </a>
                <a href="{{ route('frontend.courses') }}">
                    <i class="fas fa-angle-double-right"></i>
                    <span>វគ្គសិក្សាទាំងអស់</span>
                </a>
            </div>
        </div>
    </div>

    <h1 class="course-workspace-brand">មេរៀនសិក្សា</h1>

    <nav class="course-workspace-lessons" aria-label="Course lessons">
        @forelse($modules as $moduleKey => $moduleLessons)
            @php
                $parts = explode('|', $moduleKey);
                $moduleNumber = (int) ($parts[0] ?? $loop->iteration);
                $moduleTitle = $parts[1] ?? 'Course Lessons';
                $moduleId = 'course-workspace-module-'.$loop->iteration;
                $progressKey = $moduleLessons->first()?->course_module_id ?: $moduleNumber;
                $progress = $moduleProgress[$progressKey] ?? ['completed' => 0, 'total' => $moduleLessons->count(), 'percent' => 0];
            @endphp

            <button
                type="button"
                class="course-workspace-module js-course-module-toggle"
                aria-expanded="true"
                aria-controls="{{ $moduleId }}"
            >
                <span>
                    Module {{ $moduleNumber }} - {{ $moduleTitle }}
                    <small>{{ $progress['completed'] }}/{{ $progress['total'] }} lessons completed ({{ $progress['percent'] }}%)</small>
                </span>
                <i class="fas fa-chevron-up"></i>
            </button>

            <div id="{{ $moduleId }}" class="course-workspace-module-lessons">
                @foreach($moduleLessons as $contentLesson)
                    @php
                        $topics = $lessonTopics($contentLesson);
                        $lessonUrl = route('frontend.courses.lessons.show', ['course' => $course ?? $courseRecord?->getKey(), 'lesson' => $contentLesson->slug]);
                        $lessonId = (int) $contentLesson->content_lesson_id;
                        $isCompleted = in_array($lessonId, $completedLessonIds, true);
                        $isUnlocked = $unlockedLessons[$lessonId] ?? $loop->first;
                        $displayTitle = $lessonDisplayParts($contentLesson, $loop->iteration);
                    @endphp
                    <div class="course-workspace-lesson-node">
                        <a href="{{ $isUnlocked ? $lessonUrl : '#' }}"
                           class="course-workspace-lesson-link {{ ($lesson ?? '') === $contentLesson->slug ? 'is-active' : '' }} {{ $isCompleted ? 'is-completed' : '' }} {{ ! $isUnlocked ? 'is-locked' : '' }}"
                           data-no-loading
                           @if(! $isUnlocked) aria-disabled="true" data-locked="true" @endif>
                            <i class="fas {{ $isCompleted ? 'fa-check-circle' : (($lesson ?? '') === $contentLesson->slug ? 'fa-play-circle' : ($isUnlocked ? 'fa-circle' : 'fa-lock')) }}"></i>
                            <span class="course-workspace-lesson-text">
                                <small>{{ $displayTitle['number'] }}</small>
                                <strong>{{ $displayTitle['title'] }}</strong>
                            </span>
                        </a>

                        @if($topics->isNotEmpty() && $isUnlocked)
                            <div class="course-workspace-topics" aria-label="Lesson topics">
                                @foreach($topics as $topic)
                                    <a href="{{ $lessonUrl }}?panel={{ $topic['panel'] }}"
                                       class="js-workspace-topic-link {{ request('panel') === $topic['panel'] ? 'is-active' : '' }}"
                                       data-panel="{{ $topic['panel'] }}">
                                        {{ $moduleNumber }}.{{ $loop->iteration }} - {{ $topic['title'] }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @empty
            <button type="button" class="course-workspace-module">
                <span>Lesson</span>
                <i class="fas fa-chevron-up"></i>
            </button>
            <span class="course-workspace-empty">No lessons available</span>
        @endforelse
    </nav>
</aside>
@else
<aside class="course-detail-sidebar">
    <div class="course-detail-cover">
        <img src="{{ $courseImage }}" alt="{{ $courseTitle }}">
    </div>

    <div class="course-detail-summary">
        <h1>{{ $courseTitle }}</h1>
        <div class="course-detail-progress">
            <span></span>
        </div>
        <strong>{{ $courseRecord ? '0%' : 'N/A' }} <small>COMPLETE</small></strong>
    </div>

    <nav class="course-detail-menu course-lesson-menu" aria-label="Course lessons">
        @forelse($modules as $moduleKey => $moduleLessons)
            @php
                $parts = explode('|', $moduleKey);
                $moduleNumber = (int) ($parts[0] ?? $loop->iteration);
                $moduleTitle = $parts[1] ?? 'Course Lessons';
                $progressKey = $moduleLessons->first()?->course_module_id ?: $moduleNumber;
                $progress = $moduleProgress[$progressKey] ?? ['completed' => 0, 'total' => $moduleLessons->count(), 'percent' => 0];
            @endphp
            <h2>
                Module {{ $moduleNumber }} - {{ $moduleTitle }}
                <small>{{ $progress['completed'] }}/{{ $progress['total'] }} lessons completed ({{ $progress['percent'] }}%)</small>
            </h2>
            @foreach($moduleLessons as $contentLesson)
                @php
                    $topics = $lessonTopics($contentLesson);
                    $lessonUrl = route('frontend.courses.lessons.show', ['course' => $course ?? $courseRecord?->getKey(), 'lesson' => $contentLesson->slug]);
                    $lessonId = (int) $contentLesson->content_lesson_id;
                    $isCompleted = in_array($lessonId, $completedLessonIds, true);
                    $isUnlocked = $unlockedLessons[$lessonId] ?? $loop->first;
                    $displayTitle = $lessonDisplayParts($contentLesson, $loop->iteration);
                @endphp
                <div class="course-lesson-node">
                    <a href="{{ $isUnlocked ? $lessonUrl : '#' }}"
                       class="{{ ($lesson ?? '') === $contentLesson->slug ? 'is-active' : '' }} {{ $isCompleted ? 'is-completed' : '' }} {{ ! $isUnlocked ? 'is-locked' : '' }}"
                       data-no-loading
                       @if(! $isUnlocked) aria-disabled="true" data-locked="true" @endif>
                        <span class="course-check"><i class="fas {{ $isCompleted ? 'fa-check' : ($isUnlocked ? 'fa-play' : 'fa-lock') }}"></i></span>
                        <span class="course-video"><i class="far {{ $isUnlocked ? 'fa-play-circle' : 'fa-lock' }}"></i></span>
                        <strong>
                            <small>{{ $displayTitle['number'] }}</small>
                            {{ $displayTitle['title'] }}
                            @if($contentLesson->duration_minutes)
                                <small>({{ $contentLesson->duration_minutes }} min)</small>
                            @endif
                        </strong>
                    </a>

                    @if($topics->isNotEmpty() && $isUnlocked)
                        <div class="course-detail-topics" aria-label="Lesson topics">
                            @foreach($topics as $topic)
                                <a href="{{ $lessonUrl }}?panel={{ $topic['panel'] }}"
                                   class="js-workspace-topic-link {{ request('panel') === $topic['panel'] ? 'is-active' : '' }}"
                                   data-panel="{{ $topic['panel'] }}">
                                    {{ $moduleNumber }}.{{ $loop->iteration }} - {{ $topic['title'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @empty
            <h2>No lessons available</h2>
        @endforelse
    </nav>
</aside>
@endif
