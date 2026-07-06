@php
    $lessonTitle = $lessonRecord?->title ?? 'Lesson Not Found';
    $courseTitle = $courseRecord?->course_name ?? 'Course';
    $teacherName = trim((optional($courseRecord?->instructor)->first_name ?? '').' '.(optional($courseRecord?->instructor)->last_name ?? ''));
    $instructorName = optional(optional($courseRecord?->instructor)->user)->name ?? ($teacherName ?: 'Instructor not assigned');
@endphp

@extends('frontend.layouts.master')

@section('title', $lessonTitle.' | Moodle LMS')

@section('content')
    <section class="learning-course-detail is-lesson-view">
        @include('frontend.partials.course.sidebar', [
            'course' => $course,
            'courseRecord' => $courseRecord,
            'lessons' => $lessons,
            'lesson' => $lesson,
        ])

        <main class="course-player">
            <header class="course-player-head">
                <h1><i class="far fa-play-circle"></i> {{ $lessonTitle }}</h1>
            </header>

            <div class="course-player-stage">
                <div class="course-media-toolbar">
                    <div class="course-media-tabs" role="tablist" aria-label="Lesson content type">
                        <button type="button" class="is-active" data-media-panel="video">
                            <i class="far fa-play-circle"></i>
                            Video
                        </button>
                        <button type="button" data-media-panel="document">
                            <i class="far fa-file-alt"></i>
                            Document
                        </button>
                    </div>

                    <div class="course-media-actions">
                        <button type="button" id="toggleLessonSidebar">
                            <i class="fas fa-columns"></i>
                            Hide sidebar
                        </button>
                        <button type="button" id="toggleLessonFullscreen">
                            <i class="fas fa-expand"></i>
                            Full screen
                        </button>
                    </div>
                </div>

                <div class="course-media-shell" id="lessonMediaShell">
                    <div class="course-video-preview course-media-panel is-active" data-media-panel-content="video">
                        <div class="course-video-title">{{ $lessonTitle }}</div>
                        <div class="course-video-line"></div>
                        <div class="course-instructor-preview">
                            <img src="{{ asset('backend/dist/img/user1-128x128.jpg') }}" alt="Instructor">
                            <div>
                                <button type="button" class="course-play-button" aria-label="Play lesson">
                                    <i class="fas fa-play"></i>
                                </button>
                                <h2>{{ $instructorName }}</h2>
                                <p>{{ $courseTitle }}</p>
                                <p>{{ optional($courseRecord?->category)->category_name ?? 'Uncategorized' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="course-document-preview course-media-panel" data-media-panel-content="document">
                        <div class="course-document-page">
                            <span>Lesson Document</span>
                            <h2>{{ $lessonTitle }}</h2>
                            <p>{{ $lessonRecord?->summary ?? $courseRecord?->description ?? 'No lesson document is available yet.' }}</p>
                            @if($lessonRecord?->body)
                                {!! $lessonRecord->body !!}
                            @endif
                        </div>
                    </div>
                </div>

                <div class="course-player-actions">
                    <a href="{{ route('frontend.courses.show', $course) }}" class="course-outline-link">
                        <i class="fas fa-arrow-left"></i>
                        Back to curriculum
                    </a>
                    @if($nextLesson)
                        <a href="{{ route('frontend.courses.lessons.show', ['course' => $course, 'lesson' => $nextLesson->slug]) }}" class="course-outline-link is-next">
                            Next lesson
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif
                </div>

                <section class="course-prerequisites">
                    <h2>Prerequisites</h2>

                    <h3>System Requirement:</h3>
                    <ul>
                        <li>OS: Windows 7 Service Pack 1 or Windows 10 64 bit</li>
                    </ul>

                    <h3>Development Tools:</h3>
                    <ul>
                        <li>Microsoft SQL Server 2008 (Download: <a href="#">https://bit.ly/2DovfP9</a>)</li>
                        <li>Microsoft Visual Studio 2013 (Download: <a href="#">https://bit.ly/2tgQwp4</a>)</li>
                        <li>Chrome Browser</li>
                    </ul>

                    <div class="course-complete-row">
                        @if($nextLesson)
                            <a href="{{ route('frontend.courses.lessons.show', ['course' => $course, 'lesson' => $nextLesson->slug]) }}" class="course-complete-btn">
                                Complete and Continue
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @endif
                    </div>
                </section>

                <section class="course-discussion" id="discussion">
                    <span class="course-discussion-label">Discussion</span>
                    <div class="course-discussion-inner">
                        <h2>Post a comment</h2>

                        <form class="course-comment-form" id="lessonCommentForm">
                            <div class="course-comment-avatar">
                                <img src="{{ Auth::user()->avatar ?? asset('backend/dist/img/avatar.png') }}" alt="">
                            </div>
                            <div class="course-comment-box">
                                <strong>{{ Auth::user()->name ?? 'Student' }}</strong>
                                <textarea id="lessonCommentInput" rows="4" placeholder="Leave a comment or question..."></textarea>
                                <div class="course-comment-actions">
                                    <small>Ask your question for the instructor or classmates.</small>
                                    <button type="submit">Post comment</button>
                                </div>
                            </div>
                        </form>

                        <div class="course-comment-list" id="lessonCommentList">
                            <article class="course-comment">
                                <img src="{{ asset('backend/dist/img/avatar2.png') }}" alt="">
                                <div>
                                    <strong>So Savann</strong>
                                    <p>គ្រូអាចពន្យល់បន្ថែមអំពីការដំឡើង Development Tools បានទេ?</p>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </section>
@endsection
