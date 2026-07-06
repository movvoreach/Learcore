@php
    $courseTitle = $courseRecord?->course_name ?? 'Course Not Found';
    $courseImage = !empty($courseRecord?->image) && file_exists(public_path('storage/' . $courseRecord->image))
        ? asset('storage/'.$courseRecord->image)
        : asset('backend/img/course-image-default.png');
    $sidebarLessons = ($lessons ?? collect())->isNotEmpty()
        ? $lessons
        : ($courseRecord?->contentLessons()->publishedForStudents()->orderBy('module_number')->orderBy('position')->get() ?? collect());
    $modules = $sidebarLessons->groupBy(fn ($contentLesson) => $contentLesson->module_title ?: 'Course Lessons');
@endphp

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
