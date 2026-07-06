@php
    $courseTitle = $courseRecord?->course_name ?? 'Course Not Found';
    $modules = $lessons->groupBy(fn ($lesson) => $lesson->module_title ?: 'Course Lessons');
    $firstLesson = $lessons->first();
@endphp

@extends('frontend.layouts.master')

@section('title', $courseTitle.' | Moodle LMS')

@section('content')
    <section class="learning-course-detail">
        @include('frontend.partials.course.sidebar', [
            'course' => $course,
            'courseRecord' => $courseRecord,
            'lessons' => $lessons,
            'lesson' => null,
        ])

        <div class="course-detail-content" id="curriculum">
            <h2>{{ $courseTitle }} Curriculum</h2>

            @if($firstLesson)
                <a href="{{ route('frontend.courses.lessons.show', ['course' => $course, 'lesson' => $firstLesson->slug]) }}" class="course-next-btn">
                    Start next lesson
                    <i class="fas fa-chevron-right"></i>
                </a>
            @endif

            @forelse($modules as $moduleTitle => $moduleLessons)
                <div class="course-module">
                    <h3>{{ $moduleTitle }}</h3>
                    <div class="course-lesson-list">
                        @foreach($moduleLessons as $index => $contentLesson)
                            <a href="{{ route('frontend.courses.lessons.show', ['course' => $course, 'lesson' => $contentLesson->slug]) }}" @if($loop->parent->first && $loop->first) id="lesson-1" @endif class="course-lesson">
                                <span class="course-check"><i class="fas fa-check"></i></span>
                                <span class="course-video"><i class="far fa-play-circle"></i></span>
                                <strong>
                                    {{ $index + 1 }}- {{ $contentLesson->title }}
                                    @if($contentLesson->duration_minutes)
                                        ({{ $contentLesson->duration_minutes }} min)
                                    @endif
                                </strong>
                            </a>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="course-module">
                    <h3>No lessons available</h3>
                    <div class="course-lesson-list">
                        <div class="course-lesson">
                            <span class="course-check"><i class="fas fa-info"></i></span>
                            <span class="course-video"><i class="far fa-folder-open"></i></span>
                            <strong>Please check back later.</strong>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </section>
@endsection
