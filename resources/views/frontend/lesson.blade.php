@php
    $lessonTitle = $lessonRecord?->title ?? 'Lesson Not Found';
    $courseTitle = $courseRecord?->course_name ?? 'Course';
    $lessonSummary = $lessonRecord?->summary ?? $courseRecord?->description ?? 'No lesson content is available yet.';
@endphp

@extends('frontend.layouts.master')

@section('title', $lessonTitle.' | Moodle LMS')

@section('content')
    <section class="learning-course-detail course-workspace">
        @include('frontend.partials.course.sidebar', [
            'course' => $course,
            'courseRecord' => $courseRecord,
            'lessons' => $lessons,
            'lesson' => $lesson,
            'compactSidebar' => true,
        ])

        <main class="course-workspace-main">
            <button type="button" class="course-workspace-open-menu js-course-sidebar-open">
                <i class="fas fa-bars"></i>
                <span>Lesson</span>
            </button>

            <nav class="course-workspace-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('frontend.courses') }}">LMS Teacher</a>
                <span>/</span>
                <a href="{{ route('frontend.courses.show', $course) }}">{{ $courseTitle }}</a>
                <span>/</span>
                <span>{{ $lessonTitle }}</span>
            </nav>

            <header class="course-workspace-header">
                <span class="course-workspace-title-icon">
                    <i class="fas fa-bezier-curve"></i>
                </span>
                <h2>{{ $lessonTitle }}</h2>
            </header>

            <div class="course-workspace-tabs" role="tablist" aria-label="Lesson content">
                <button type="button" class="is-active" data-workspace-panel="video">មេរៀន</button>
                <button type="button" data-workspace-panel="document">ឯកសារ</button>
            </div>

            <article class="course-workspace-card">
                <h3>{{ $lessonTitle }}</h3>

                <div class="course-workspace-panel is-active" data-workspace-panel-content="video">
                    <div class="course-workspace-frame" id="lessonMediaShell">
                        <div class="course-workspace-video">
                            <button type="button" class="course-workspace-play" aria-label="Play lesson">
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="course-workspace-panel" data-workspace-panel-content="document">
                    <div class="course-workspace-document">
                        <span>Lesson Document</span>
                        <h4>{{ $lessonTitle }}</h4>
                        <p>{{ $lessonSummary }}</p>
                        @if($lessonRecord?->body)
                            {!! $lessonRecord->body !!}
                        @endif
                    </div>
                </div>

                <div class="course-workspace-copy">
                    <p>{{ $lessonSummary }}</p>

                    <div class="course-workspace-actions">
                        <a href="{{ route('frontend.courses.show', $course) }}" class="course-workspace-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </a>
                        @if($nextLesson)
                            <a href="{{ route('frontend.courses.lessons.show', ['course' => $course, 'lesson' => $nextLesson->slug]) }}" class="course-workspace-start">
                                Next lesson
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </article>

            @include('frontend.partials.course.discussion', [
                'discussionAction' => route('frontend.courses.lessons.discussion.store', ['course' => $course, 'lesson' => $lesson]),
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
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 0;
            background: #fff;
            color: #62718a;
            font-size: 18px;
            font-weight: 900;
            text-align: left;
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

        .course-workspace-panel {
            display: none;
        }

        .course-workspace-panel.is-active {
            display: block;
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

        .course-workspace-document {
            min-height: 360px;
            border: 1px solid #d9e2ef;
            border-radius: 7px;
            background: #f8fafc;
            padding: 28px;
        }

        .course-workspace-document span {
            color: #237dbe;
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .course-workspace-document h4 {
            margin: 12px 0 16px;
            color: #26364b;
            font-size: 24px;
            font-weight: 900;
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

        .course-workspace-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 0 0 auto;
        }

        .course-workspace-start,
        .course-workspace-secondary {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border-radius: 6px;
            padding: 0 18px;
            font-weight: 900;
            text-decoration: none;
        }

        .course-workspace-start {
            background: #237dbe;
            color: #fff;
        }

        .course-workspace-secondary {
            border: 1px solid #cdd8e8;
            background: #fff;
            color: #52627a;
        }

        .course-workspace-start:hover {
            color: #fff;
            text-decoration: none;
        }

        .course-workspace-secondary:hover {
            color: #237dbe;
            text-decoration: none;
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

            .course-workspace-copy,
            .course-workspace-actions {
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
            .course-workspace-empty {
                padding-left: 28px;
                padding-right: 28px;
                font-size: 16px;
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

            $('[data-workspace-panel]').on('click', function() {
                const panel = $(this).data('workspace-panel');

                $('[data-workspace-panel]').removeClass('is-active');
                $(this).addClass('is-active');
                $('[data-workspace-panel-content]').removeClass('is-active');
                $(`[data-workspace-panel-content="${panel}"]`).addClass('is-active');
            });
        });
    </script>
@endpush
