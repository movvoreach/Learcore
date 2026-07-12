@php
    $courseTitle = $courseRecord?->course_name ?? 'Course Not Found';
    $modules = $lessons->groupBy(fn ($lesson) => $lesson->module_title ?: 'Course Lessons');
    $firstLesson = $lessons->first();
    $lessonDisplayTitle = function ($contentLesson, string $fallback): string {
        if (! $contentLesson) {
            return $fallback;
        }

        $title = trim((string) ($contentLesson->title ?? $fallback));
        $title = preg_replace('/^\s*មេរៀនទី\s*[០-៩0-9]+\s*[-–—:]\s*/u', '', $title) ?? $title;
        $title = preg_replace('/^\s*Lesson\s*[0-9]+\s*[-–—:]\s*/i', '', $title) ?? $title;
        $khmerNumber = strtr((string) $contentLesson->module_number, [
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

        return $contentLesson->module_number
            ? 'មេរៀនទី '.$khmerNumber.' - '.$title
            : $title;
    };
    $activeLessonTitle = $lessonDisplayTitle($firstLesson, $courseTitle);
    $activeLessonSummary = $firstLesson?->summary ?? $courseRecord?->description ?? 'No lesson content is available yet.';
    $quizzesCount = $lessons->sum(fn ($contentLesson) => $contentLesson->quizzes->count());
    $assignmentsCount = $lessons->sum(fn ($contentLesson) => $contentLesson->assignments->count());
    $courseImage = !empty($courseRecord?->image) && file_exists(public_path('storage/' . $courseRecord->image))
        ? asset('storage/'.$courseRecord->image)
        : asset('backend/img/course-image-default.png');
    $categoryName = optional($courseRecord?->category)->category_name ?? 'General Course';
    $academicYear = optional($courseRecord?->academicYear)->year_name ?? 'All years';
    $lessonsCount = $lessons->count();
    $durationMinutes = $lessons->sum(fn ($contentLesson) => (int) ($contentLesson->duration_minutes ?? 0));
    $durationLabel = $durationMinutes > 0 ? round($durationMinutes / 60, 1).' hours' : 'Duration not set';
    $courseStatus = $courseRecord?->status ?? 'Active';
    $instructor = $courseRecord?->instructor;
    $teacherName = trim((optional($instructor)->first_name ?? '').' '.(optional($instructor)->last_name ?? ''));
    $instructorName = optional(optional($instructor)->user)->name ?? ($teacherName ?: 'Instructor not assigned');
    $instructorAvatar = optional(optional($instructor)->user)->avatar
        ?: optional($instructor)->avatar
        ?: asset('backend/dist/img/avatar.png');
@endphp

@extends('frontend.layouts.master')

@section('title', $courseTitle.' | Moodle LMS')

@section('content')
    <section class="learning-course-detail course-workspace">
        @include('frontend.partials.course.sidebar', [
            'course' => $course,
            'courseRecord' => $courseRecord,
            'lessons' => $lessons,
            'lesson' => $firstLesson?->slug,
            'compactSidebar' => true,
        ])

        <main class="course-workspace-main">
            <button type="button" class="course-workspace-open-menu js-course-sidebar-open">
                <i class="fas fa-bars"></i>
                <span>Lesson</span>
            </button>

            <nav class="course-workspace-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('frontend.courses') }}">Courses</a>
                <span>/</span>
                <span>{{ $courseTitle }}</span>
            </nav>

            <section class="course-detail-hero">
                <div class="course-detail-hero__copy">
                    <div class="course-detail-eyebrow">
                        <span>{{ $categoryName }}</span>
                        <strong>{{ $courseStatus }}</strong>
                    </div>

                    <h1>{{ $courseTitle }}</h1>
                    <p>{{ $courseRecord?->description ?? 'This course is prepared for structured digital learning with lessons, activities, and progress tracking in LearnCore LMS.' }}</p>

                    <div class="course-detail-hero__meta">
                        <span><i class="far fa-bookmark" aria-hidden="true"></i>{{ $lessonsCount }} lessons</span>
                        <span><i class="far fa-clock" aria-hidden="true"></i>{{ $durationLabel }}</span>
                        <span><i class="fas fa-layer-group" aria-hidden="true"></i>{{ $academicYear }}</span>
                        <span><i class="fas fa-question-circle" aria-hidden="true"></i>{{ $quizzesCount }} quizzes</span>
                        <span><i class="fas fa-clipboard-check" aria-hidden="true"></i>{{ $assignmentsCount }} assignments</span>
                    </div>

                    <div class="course-detail-instructor">
                        <img src="{{ $instructorAvatar }}" alt="{{ $instructorName }}">
                        <div>
                            <span>Your Instructor</span>
                            <strong>{{ $instructorName }}</strong>
                        </div>
                    </div>

                    @if($firstLesson)
                        <a href="{{ route('frontend.courses.lessons.show', ['course' => $course, 'lesson' => $firstLesson->slug]) }}" class="course-detail-hero__start">
                            Start learning
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>

                <div class="course-detail-hero__media">
                    <img src="{{ $courseImage }}" alt="{{ $courseTitle }}">
                </div>
            </section>

            <header class="course-workspace-header">
                <span class="course-workspace-title-icon">
                    <i class="fas fa-play-circle"></i>
                </span>
                <h2>{{ $activeLessonTitle }}</h2>
            </header>

            <div class="course-workspace-tabs" role="tablist" aria-label="Lesson content">
                <button type="button" class="is-active">មេរៀន</button>
                <button type="button">មេរៀនសកម្មភាពដែលដំណើរ</button>
            </div>

            <article class="course-workspace-card">
                <h3>{{ $firstLesson ? $activeLessonTitle : 'No lessons available' }}</h3>

                <div class="course-workspace-frame">
                    <div class="course-workspace-video">
                        <button type="button" class="course-workspace-play" aria-label="Play lesson">
                            <i class="fas fa-play"></i>
                        </button>
                        <span>Lesson preview</span>
                    </div>
                </div>

                <div class="course-workspace-copy">
                    <p>{{ $activeLessonSummary }}</p>

                    @if($firstLesson)
                        <a href="{{ route('frontend.courses.lessons.show', ['course' => $course, 'lesson' => $firstLesson->slug]) }}" class="course-workspace-start">
                            Start lesson
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif
                </div>

                <div class="course-workspace-assessment-summary">
                    <span>
                        <i class="fas fa-question-circle"></i>
                        {{ $quizzesCount }} តេស្តខ្លី
                    </span>
                    <span>
                        <i class="fas fa-clipboard-check"></i>
                        {{ $assignmentsCount }} កិច្ចការ
                    </span>
                </div>
            </article>

            @include('frontend.partials.course.discussion', [
                'discussionAction' => route('frontend.courses.discussion.store', $course),
                'discussionPosts' => $discussionPosts,
            ])
        </main>
    </section>
@endsection

@push('styles')
    <style>
        body:has(.course-workspace) .frontend-main {
            background: #f4f7fd;
        }

        .learning-course-detail.course-workspace {
            min-height: calc(100vh - 82px);
            grid-template-columns: 455px minmax(0, 1fr);
            background: #f4f7fd;
            transition: grid-template-columns .28s ease;
        }

        .course-workspace-sidebar {
            height: calc(100vh - 82px);
            overflow-y: auto;
            border-right: 1px solid #dfe5ef;
            background: #fff;
            color: #26364b;
            scrollbar-color: #d5deeb transparent;
            opacity: 1;
            transform: translateX(0);
            transition: opacity .24s ease, transform .28s ease;
        }

        .learning-course-detail.course-workspace.is-course-sidebar-hidden {
            grid-template-columns: 0 minmax(0, 1fr);
        }

        .learning-course-detail.course-workspace.is-course-sidebar-hidden .course-workspace-sidebar {
            opacity: 0;
            overflow: hidden;
            transform: translateX(-18px);
            pointer-events: none;
        }

        .course-workspace-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 62px;
            padding: 0 30px;
        }

        .course-workspace-more {
            position: relative;
        }

        .course-workspace-icon-btn {
            width: 32px;
            height: 32px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #53657f;
            font-size: 18px;
            transition: background-color .18s ease, color .18s ease, transform .18s ease, box-shadow .18s ease;
        }

        .course-workspace-icon-btn:hover,
        .course-workspace-icon-btn:focus-visible {
            background: #eef4fb;
            color: #237dbe;
            box-shadow: 0 8px 18px rgba(35, 125, 190, .14);
            transform: translateY(-1px) scale(1.06);
        }

        .course-workspace-icon-btn:active {
            transform: translateY(0) scale(.94) rotate(8deg);
        }

        .js-course-sidebar-close:hover i,
        .js-course-sidebar-close:focus-visible i {
            transform: rotate(90deg);
        }

        .js-course-sidebar-close i {
            transition: transform .2s ease;
        }

        .course-workspace-more-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: -8px;
            z-index: 20;
            width: 206px;
            overflow: hidden;
            border: 1px solid #e3ebf5;
            border-radius: 4px;
            background: #fff;
            box-shadow: 0 16px 34px rgba(39, 56, 79, .15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-4px);
            transition: opacity .16s ease, transform .16s ease, visibility .16s ease;
        }

        .course-workspace-more.is-open .course-workspace-more-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .course-workspace-more-menu a {
            min-height: 60px;
            display: flex;
            align-items: center;
            gap: 17px;
            padding: 0 22px;
            background: #fff;
            color: #4b5d75;
            font-size: 17px;
            font-weight: 900;
            text-decoration: none;
        }

        .course-workspace-more-menu a:first-child {
            background: #eef3f8;
        }

        .course-workspace-more-menu a:hover {
            color: #237dbe;
            text-decoration: none;
        }

        .course-workspace-more-menu i {
            width: 22px;
            color: #5e718b;
            font-size: 19px;
            text-align: center;
        }

        .course-workspace-brand {
            margin: 0;
            padding: 6px 30px 18px;
            color: #27384f;
            font-size: 29px;
            line-height: 1.35;
            font-weight: 900;
        }

        .course-workspace-lessons {
            display: grid;
            gap: 1px;
            padding: 0 30px 28px;
        }

        .course-workspace-module {
            width: 100%;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 0;
            background: #fff;
            color: #62718a;
            cursor: pointer;
            font-size: 18px;
            font-weight: 900;
            text-align: left;
        }

        .course-workspace-module i {
            flex: 0 0 auto;
            transition: transform .2s ease;
        }

        .course-workspace-module.is-collapsed i {
            transform: rotate(180deg);
        }

        .course-workspace-module-lessons {
            display: grid;
            gap: 1px;
        }

        .course-workspace-module-lessons.is-collapsed {
            display: none;
        }

        .course-workspace-lesson-node,
        .course-lesson-node {
            display: grid;
            gap: 4px;
        }

        .course-workspace-lessons a,
        .course-workspace-empty {
            min-height: 42px;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 8px 52px;
            border-radius: 8px;
            color: #26364b;
            font-size: 18px;
            line-height: 1.45;
            text-decoration: none;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .course-workspace-lessons a:hover {
            background: #edf5ff;
            color: #0f63b7;
            text-decoration: none;
        }

        .course-workspace-lessons a.is-active {
            background: #237dbe;
            color: #030b16;
            font-weight: 900;
        }

        .course-workspace-topics,
        .course-detail-topics {
            display: grid;
            gap: 4px;
            padding: 0 52px 10px;
            color: #66758c;
            font-size: 15px;
            line-height: 1.45;
        }

        .course-workspace-topics a,
        .course-detail-topics a {
            min-height: auto;
            display: block;
            padding: 0;
            border-radius: 4px;
            color: inherit;
            font-size: inherit;
            line-height: inherit;
            text-decoration: none;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .course-workspace-topics a:hover,
        .course-detail-topics a:hover {
            background: transparent;
            color: #0f63b7;
            text-decoration: none;
        }

        .course-workspace-main {
            min-width: 0;
            padding: 42px 58px 64px;
        }

        .course-workspace-open-menu {
            min-height: 40px;
            display: none;
            align-items: center;
            gap: 9px;
            margin-bottom: 22px;
            border: 1px solid #cdd8e8;
            border-radius: 6px;
            background: #fff;
            color: #237dbe;
            padding: 0 14px;
            font-weight: 900;
        }

        .learning-course-detail.course-workspace.is-course-sidebar-hidden .course-workspace-open-menu {
            display: inline-flex;
        }

        .course-workspace-breadcrumb {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 48px;
            color: #33455f;
            font-size: 16px;
        }

        .course-workspace-breadcrumb a {
            color: #0057ff;
            text-decoration: none;
        }

        .course-workspace-header {
            display: flex;
            align-items: center;
            gap: 22px;
            margin-bottom: 52px;
        }

        .course-workspace-title-icon {
            color: #2d9bff;
            font-size: 28px;
        }

        .course-workspace-header h2 {
            margin: 0;
            color: #26364b;
            font-size: 34px;
            line-height: 1.35;
            font-weight: 900;
        }

        .course-workspace-tabs {
            min-height: 63px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            padding: 0 13px;
            border: 1px solid #ccd7e7;
            border-radius: 7px;
            background: #fff;
        }

        .course-workspace-tabs button {
            min-height: 38px;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: #26364b;
            padding: 0 14px;
            font-size: 16px;
        }

        .course-workspace-tabs button.is-active {
            background: #eef4fb;
            font-weight: 900;
        }

        .course-workspace-card {
            padding: 30px;
            border-radius: 7px;
            background: #fff;
            box-shadow: 0 12px 34px rgba(30, 55, 90, .05);
        }

        .course-workspace-card h3 {
            margin: 0 0 24px;
            color: #26364b;
            font-size: 29px;
            line-height: 1.35;
            font-weight: 900;
        }

        .course-workspace-frame {
            height: min(58vh, 520px);
            min-height: 360px;
            overflow: auto;
            border: 2px solid #a9a9a9;
            background: #fff;
            padding: 10px;
        }

        .course-workspace-video {
            min-height: 500px;
            display: grid;
            place-items: center;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, .04) 25%, transparent 25%) 0 0 / 160px 160px,
                linear-gradient(225deg, rgba(255, 255, 255, .035) 25%, transparent 25%) 0 0 / 160px 160px,
                linear-gradient(180deg, #1499bd, #05667d);
        }

        .course-workspace-play {
            width: 114px;
            height: 62px;
            display: grid;
            place-items: center;
            border: 2px solid #fff;
            border-radius: 9px;
            background: rgba(6, 30, 46, .56);
            color: #fff;
            font-size: 23px;
        }

        .course-workspace-copy {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            margin-top: 24px;
        }

        .course-workspace-copy p {
            margin: 0;
            color: #52627a;
            font-size: 16px;
            line-height: 1.75;
        }

        .course-workspace-start {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            flex: 0 0 auto;
            border-radius: 6px;
            background: #237dbe;
            color: #fff;
            padding: 0 18px;
            font-weight: 900;
            text-decoration: none;
        }

        .course-workspace-start:hover {
            color: #fff;
            text-decoration: none;
        }

        .course-workspace-assessment-summary {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 22px;
        }

        .course-workspace-assessment-summary span {
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            background: #eef4fb;
            color: #36506d;
            padding: 0 14px;
            font-weight: 900;
        }

        .course-workspace-assessment-summary i {
            color: #237dbe;
        }

        .course-workspace-discussion {
            margin-top: 24px;
            padding: 28px 30px;
            border-radius: 7px;
            background: #fff;
            box-shadow: 0 12px 34px rgba(30, 55, 90, .05);
        }

        .course-workspace-discussion-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 22px;
            color: #26364b;
        }

        .course-workspace-discussion-head span {
            font-size: 24px;
            font-weight: 900;
        }

        .course-workspace-discussion-head strong {
            color: #66758c;
            font-size: 15px;
        }

        .course-workspace-comment-form {
            display: grid;
            grid-template-columns: 54px minmax(0, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .course-workspace-comment-form img {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            object-fit: cover;
        }

        .course-workspace-comment-form textarea {
            width: 100%;
            min-height: 118px;
            resize: vertical;
            border: 1px solid #d9e2ef;
            border-radius: 7px;
            background: #f8fafc;
            color: #26364b;
            padding: 14px 16px;
            outline: 0;
        }

        .course-workspace-comment-form textarea:focus {
            border-color: #7ab8f2;
            box-shadow: 0 0 0 3px rgba(35, 125, 190, .12);
        }

        .course-workspace-comment-form button {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            float: right;
            margin-top: 12px;
            border: 0;
            border-radius: 6px;
            background: #237dbe;
            color: #fff;
            padding: 0 16px;
            font-weight: 900;
        }

        .course-workspace-comment-list {
            margin-left: 70px;
        }

        @media (max-width: 992px) {
            .learning-course-detail.course-workspace {
                grid-template-columns: 1fr;
            }

            .course-workspace-sidebar {
                height: auto;
                max-height: 55vh;
                border-right: 0;
                border-bottom: 1px solid #dfe5ef;
            }

            .course-workspace-main {
                padding: 28px 18px 44px;
            }

            .course-workspace-header {
                margin-bottom: 28px;
            }

            .course-workspace-header h2 {
                font-size: 26px;
            }

            .course-workspace-copy {
                align-items: stretch;
                flex-direction: column;
            }

            .course-workspace-open-menu {
                display: inline-flex;
            }
        }

        @media (max-width: 576px) {
            .course-workspace-topbar,
            .course-workspace-brand,
            .course-workspace-lessons {
                padding-left: 20px;
                padding-right: 20px;
            }

            .course-workspace-lessons a,
            .course-workspace-empty,
            .course-workspace-topics,
            .course-detail-topics {
                padding-left: 28px;
                padding-right: 28px;
                font-size: 16px;
            }

            .course-workspace-topics a,
            .course-detail-topics a {
                padding: 0;
            }

            .course-workspace-card {
                padding: 18px;
            }

            .course-workspace-frame {
                height: 360px;
                min-height: 320px;
            }

            .course-workspace-discussion {
                padding: 20px 18px;
            }

            .course-workspace-comment-form {
                grid-template-columns: 1fr;
            }

            .course-workspace-comment-list {
                margin-left: 0;
            }
        }

        body:has(.course-workspace) .frontend-main {
            background:
                radial-gradient(circle at 78% 8%, rgba(8, 114, 129, .10), transparent 30%),
                linear-gradient(180deg, #eef6f8 0%, #f7fafc 44%, #f4f7fb 100%);
        }

        .learning-course-detail.course-workspace {
            grid-template-columns: 390px minmax(0, 1fr);
            align-items: start;
            background: transparent;
        }

        .course-workspace-sidebar {
            position: sticky;
            top: 70px;
            max-height: calc(100vh - 70px);
            height: calc(100vh - 70px);
            border-right: 1px solid rgba(8, 114, 129, .14);
            background: rgba(255, 255, 255, .96);
            box-shadow: 14px 0 34px rgba(15, 23, 42, .05);
        }

        .course-workspace-main {
            padding: 34px clamp(20px, 4vw, 58px) 64px;
        }

        .course-workspace-brand,
        .course-workspace-header h2,
        .course-workspace-card h3,
        .course-workspace-discussion-head span {
            font-weight: 600;
        }

        .course-workspace-more-menu a,
        .course-workspace-module,
        .course-workspace-lessons a.is-active,
        .course-workspace-open-menu,
        .course-workspace-tabs button.is-active,
        .course-workspace-start,
        .course-workspace-assessment-summary span,
        .course-workspace-comment-form button {
            font-weight: 500;
        }

        .course-workspace-brand {
            padding: 6px 24px 18px;
            color: #172033;
            font-size: 25px;
        }

        .course-workspace-topbar {
            padding: 0 24px;
        }

        .course-workspace-icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f2f8fa;
            color: #087281;
            font-size: 16px;
        }

        .course-workspace-icon-btn:hover,
        .course-workspace-icon-btn:focus-visible {
            background: #087281;
            color: #fff;
            box-shadow: 0 10px 18px rgba(8, 114, 129, .18);
        }

        .course-workspace-lessons {
            gap: 8px;
            padding: 0 18px 28px;
        }

        .course-workspace-module {
            border-radius: 10px;
            background: #f6fafc;
            color: #334155;
            padding: 0 12px;
            font-size: 15px;
        }

        .course-workspace-module-lessons {
            gap: 4px;
            padding: 6px 0 2px;
        }

        .course-workspace-lessons a,
        .course-workspace-empty {
            padding: 8px 14px 8px 28px;
            color: #405269;
            font-size: 14px;
        }

        .course-workspace-lessons a:hover {
            background: #eaf6f8;
            color: #075c68;
        }

        .course-workspace-lessons a.is-active {
            background: #087281;
            color: #fff;
        }

        .course-workspace-topics,
        .course-detail-topics {
            padding: 0 18px 10px 38px;
            font-size: 13px;
        }

        .course-workspace-breadcrumb {
            margin-bottom: 22px;
            color: #607086;
            font-size: 14px;
        }

        .course-workspace-breadcrumb a {
            color: #087281;
        }

        .course-detail-hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(260px, 360px);
            gap: 28px;
            align-items: stretch;
            margin-bottom: 30px;
            overflow: hidden;
            border: 1px solid rgba(8, 114, 129, .16);
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(8, 114, 129, .96), rgba(35, 125, 190, .90));
            color: #fff;
            box-shadow: 0 22px 48px rgba(8, 114, 129, .18);
        }

        .course-detail-hero__copy {
            padding: 34px;
        }

        .course-detail-eyebrow {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 18px;
        }

        .course-detail-eyebrow span,
        .course-detail-eyebrow strong,
        .course-detail-hero__meta span {
            min-height: 30px;
            display: inline-flex;
            align-items: center;
            padding: 0 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            color: #fff;
            font-size: 13px;
            font-weight: 400;
        }

        .course-detail-eyebrow strong {
            background: #f59e0b;
            font-weight: 500;
        }

        .course-detail-hero h1 {
            max-width: 760px;
            margin: 0;
            color: #fff;
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.25;
            font-weight: 600;
        }

        .course-detail-hero p {
            max-width: 820px;
            margin: 16px 0 0;
            color: rgba(255, 255, 255, .88);
            font-size: 16px;
            line-height: 1.8;
            font-weight: 400;
        }

        .course-detail-hero__meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 24px;
        }

        .course-detail-hero__meta span {
            gap: 8px;
            min-height: 36px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 10px;
            background: rgba(255, 255, 255, .10);
        }

        .course-detail-instructor {
            width: max-content;
            max-width: 100%;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-top: 20px;
            padding: 10px 14px 10px 10px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 14px;
            background: rgba(255, 255, 255, .12);
        }

        .course-detail-instructor img {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            border: 2px solid rgba(255, 255, 255, .72);
            border-radius: 50%;
            object-fit: cover;
            background: #fff;
        }

        .course-detail-instructor span,
        .course-detail-instructor strong {
            display: block;
            color: #fff;
            line-height: 1.35;
        }

        .course-detail-instructor span {
            font-size: 12px;
            font-weight: 400;
            opacity: .82;
        }

        .course-detail-instructor strong {
            font-size: 15px;
            font-weight: 600;
        }

        .course-detail-hero__start {
            min-height: 46px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 24px;
            border-radius: 10px;
            background: #fff;
            color: #087281;
            padding: 0 18px;
            font-weight: 500;
            text-decoration: none;
            box-shadow: 0 14px 24px rgba(0, 0, 0, .14);
        }

        .course-detail-hero__start:hover {
            color: #087281;
            text-decoration: none;
        }

        .course-detail-hero__media {
            padding: 18px 18px 18px 0;
        }

        .course-detail-hero__media img {
            width: 100%;
            height: 100%;
            min-height: 260px;
            border-radius: 14px;
            object-fit: cover;
            background: #fff;
            box-shadow: 0 16px 32px rgba(0, 0, 0, .18);
        }

        .course-workspace-header {
            gap: 14px;
            margin: 10px 0 20px;
        }

        .course-workspace-title-icon {
            width: 42px;
            height: 42px;
            display: inline-grid;
            place-items: center;
            border-radius: 12px;
            background: #eaf6f8;
            color: #087281;
            font-size: 20px;
        }

        .course-workspace-header h2 {
            color: #172033;
            font-size: 28px;
        }

        .course-workspace-tabs,
        .course-workspace-card,
        .course-workspace-discussion {
            border: 1px solid #dce7f2;
            border-radius: 18px;
            background: rgba(255, 255, 255, .94);
            box-shadow: 0 18px 44px rgba(30, 55, 90, .08);
        }

        .course-workspace-tabs {
            min-height: 60px;
            border-radius: 14px;
        }

        .course-workspace-tabs button {
            color: #334155;
        }

        .course-workspace-tabs button.is-active {
            background: #eaf6f8;
            color: #075c68;
        }

        .course-workspace-card {
            padding: clamp(20px, 3vw, 32px);
        }

        .course-workspace-card h3 {
            color: #172033;
            font-size: 24px;
        }

        .course-workspace-frame {
            overflow: hidden;
            border: 0;
            border-radius: 16px;
            background: #082f49;
            padding: 0;
        }

        .course-workspace-video {
            min-height: 100%;
            gap: 14px;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, .08) 25%, transparent 25%) 0 0 / 160px 160px,
                linear-gradient(225deg, rgba(255, 255, 255, .055) 25%, transparent 25%) 0 0 / 160px 160px,
                linear-gradient(135deg, #0f766e, #075985);
        }

        .course-workspace-play {
            width: 84px;
            height: 84px;
            border: 0;
            border-radius: 50%;
            background: #fff;
            color: #087281;
            box-shadow: 0 18px 34px rgba(0, 0, 0, .2);
        }

        .course-workspace-video span {
            color: rgba(255, 255, 255, .82);
            font-size: 15px;
            font-weight: 400;
        }

        .course-workspace-copy p {
            color: #64748b;
            font-weight: 400;
        }

        .course-workspace-start,
        .course-workspace-comment-form button {
            border-radius: 10px;
            background: #087281;
        }

        .course-workspace-assessment-summary span {
            background: #eaf6f8;
            color: #36506d;
        }

        .course-workspace-assessment-summary i {
            color: #087281;
        }

        @media (max-width: 992px) {
            .course-detail-hero {
                grid-template-columns: 1fr;
            }

            .course-workspace-sidebar {
                position: static;
                max-height: 55vh;
                height: auto;
            }

            .course-detail-hero__media {
                padding: 0 24px 24px;
            }
        }

        @media (max-width: 576px) {
            .course-detail-hero__copy {
                padding: 24px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {
            $('.js-course-sidebar-close').on('click', function() {
                $('.course-workspace').addClass('is-course-sidebar-hidden');
            });

            $('.js-course-sidebar-open').on('click', function() {
                $('.course-workspace').removeClass('is-course-sidebar-hidden');
            });

            $('.js-course-module-toggle').on('click', function() {
                const $button = $(this);
                const $lessons = $('#' + $button.attr('aria-controls'));
                const isOpen = $button.attr('aria-expanded') === 'true';

                $button
                    .toggleClass('is-collapsed', isOpen)
                    .attr('aria-expanded', String(!isOpen));
                $lessons.toggleClass('is-collapsed', isOpen);
            });

            $('.js-course-more-toggle').on('click', function(event) {
                event.stopPropagation();

                const $wrap = $(this).closest('.course-workspace-more');
                const isOpen = $wrap.hasClass('is-open');

                $('.course-workspace-more').removeClass('is-open')
                    .find('.js-course-more-toggle')
                    .attr('aria-expanded', 'false');

                if (!isOpen) {
                    $wrap.addClass('is-open');
                    $(this).attr('aria-expanded', 'true');
                }
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('.course-workspace-more').length) {
                    $('.course-workspace-more').removeClass('is-open')
                        .find('.js-course-more-toggle')
                        .attr('aria-expanded', 'false');
                }
            });

            $('.course-workspace-tabs button').on('click', function() {
                $('.course-workspace-tabs button').removeClass('is-active');
                $(this).addClass('is-active');
            });
        });
    </script>
@endpush
