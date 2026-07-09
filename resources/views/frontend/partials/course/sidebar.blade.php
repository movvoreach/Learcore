@php
    $courseTitle = $courseRecord?->course_name ?? 'Course Not Found';
    $courseImage = !empty($courseRecord?->image) && file_exists(public_path('storage/' . $courseRecord->image))
        ? asset('storage/'.$courseRecord->image)
        : asset('backend/img/course-image-default.png');
    $sidebarLessons = ($lessons ?? collect())->isNotEmpty()
        ? $lessons
        : ($courseRecord?->contentLessons()->publishedForStudents()->orderBy('module_number')->orderBy('position')->get() ?? collect());
    $modules = $sidebarLessons->groupBy(fn ($contentLesson) => $contentLesson->module_title ?: 'Course Lessons');
    $compactSidebar = $compactSidebar ?? false;
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
        @forelse($modules as $moduleTitle => $moduleLessons)
            <button type="button" class="course-workspace-module">
                <span>{{ $moduleTitle }}</span>
                <i class="fas fa-chevron-up"></i>
            </button>

            @foreach($moduleLessons as $index => $contentLesson)
                <a href="{{ route('frontend.courses.lessons.show', ['course' => $course ?? $courseRecord?->getKey(), 'lesson' => $contentLesson->slug]) }}"
                   class="{{ ($lesson ?? '') === $contentLesson->slug ? 'is-active' : '' }}">
                    {{ $contentLesson->title }}
                </a>
            @endforeach
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
        @forelse($modules as $moduleTitle => $moduleLessons)
            <h2>{{ $moduleTitle }}</h2>
            @foreach($moduleLessons as $index => $contentLesson)
                <a href="{{ route('frontend.courses.lessons.show', ['course' => $course ?? $courseRecord?->getKey(), 'lesson' => $contentLesson->slug]) }}" class="{{ ($lesson ?? '') === $contentLesson->slug ? 'is-active' : '' }}">
                    <span class="course-check"><i class="fas fa-check"></i></span>
                    <span class="course-video"><i class="far fa-play-circle"></i></span>
                    <strong>
                        {{ $index + 1 }}- {{ $contentLesson->title }}
                        @if($contentLesson->duration_minutes)
                            <small>({{ $contentLesson->duration_minutes }} min)</small>
                        @endif
                    </strong>
                </a>
            @endforeach
        @empty
            <h2>No lessons available</h2>
        @endforelse
    </nav>
</aside>
@endif
