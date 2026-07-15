@php
    $lessonRawTitle = trim((string) ($lessonRecord?->title ?? 'Lesson Not Found'));
    $lessonCleanTitle = preg_replace('/^\s*មេរៀនទី\s*[០-៩0-9]+\s*[-–—:]\s*/u', '', $lessonRawTitle) ?? $lessonRawTitle;
    $lessonCleanTitle = preg_replace('/^\s*Lesson\s*[0-9]+\s*[-–—:]\s*/i', '', $lessonCleanTitle) ?? $lessonCleanTitle;
    $lessonKhmerNumber = strtr((string) $lessonRecord?->module_number, [
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
    $lessonTitle = $lessonRecord?->module_number
        ? 'មេរៀនទី '.$lessonKhmerNumber.' - '.$lessonCleanTitle
        : $lessonCleanTitle;
    $courseTitle = $courseRecord?->course_name ?? 'Course';
    $lessonSummary = $lessonRecord?->summary ?? $courseRecord?->description ?? 'No lesson content is available yet.';
    $lessonQuizzes = $lessonRecord?->quizzes ?? collect();
    $lessonAssignments = $lessonRecord?->assignments ?? collect();
    $lessonQuestions = $lessonRecord?->assessmentQuestions ?? collect();
    $quizResults = $quizResults ?? collect();
    $assignmentSubmissions = $assignmentSubmissions ?? collect();
    $assignmentAttachmentUrl = fn (?string $path): ?string => $path
        ? (str_starts_with($path, 'http') ? $path : asset('storage/'.$path))
        : null;
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

            @if(session('assessment_success'))
                <div class="course-workspace-alert course-workspace-alert--success">
                    {{ session('assessment_success') }}
                </div>
            @endif

            @if(session('assessment_error') || $errors->any())
                <div class="course-workspace-alert course-workspace-alert--danger">
                    {{ session('assessment_error') ?? $errors->first() }}
                </div>
            @endif

            <div class="course-workspace-tabs" role="tablist" aria-label="Lesson content">
                <button type="button" class="is-active" data-workspace-panel="video">មេរៀន</button>
                <button type="button" data-workspace-panel="document">ឯកសារ</button>
                <button type="button" data-workspace-panel="quiz">
                    តេស្តខ្លី
                    @if($lessonQuizzes->isNotEmpty())
                        <span>{{ $lessonQuizzes->count() }}</span>
                    @endif
                </button>
                <button type="button" data-workspace-panel="assignment">
                    កិច្ចការ
                    @if($lessonAssignments->isNotEmpty())
                        <span>{{ $lessonAssignments->count() }}</span>
                    @endif
                </button>
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

                <div class="course-workspace-panel" data-workspace-panel-content="quiz">
                    <div class="course-workspace-assessment-list">
                        @forelse($lessonQuizzes as $quiz)
                            @php
                                $quizOpen = (! $quiz->available_from || $quiz->available_from <= now())
                                    && (! $quiz->available_until || $quiz->available_until >= now());
                                $quizResult = $quizResults->get($quiz->quiz_id);
                            @endphp

                            <section class="course-workspace-assessment course-workspace-assessment--quiz">
                                <div class="course-workspace-assessment-icon">
                                    <i class="fas fa-question-circle"></i>
                                </div>

                                <div class="course-workspace-assessment-body">
                                    <div class="course-workspace-assessment-kicker">តេស្តខ្លី</div>
                                    <h4>{{ $quiz->title }}</h4>

                                    <div class="course-workspace-assessment-meta">
                                        <span>{{ $lessonQuestions->count() }} សំណួរ</span>
                                        <span>ពិន្ទុជាប់ {{ number_format((float) $quiz->passing_score, 0) }}%</span>
                                        <span>{{ $quiz->time_limit_minutes ? $quiz->time_limit_minutes.' នាទី' : 'គ្មានកំណត់ពេល' }}</span>
                                        <span>{{ $quizOpen ? 'កំពុងបើក' : 'មិនទាន់បើក' }}</span>
                                    </div>

                                    @if($quiz->instructions)
                                        <div class="course-workspace-assessment-copy">{!! $quiz->instructions !!}</div>
                                    @else
                                        <p>សូមអានមេរៀន និងត្រៀមខ្លួនសម្រាប់តេស្តខ្លីនេះ។</p>
                                    @endif

                                    @if($quiz->available_from || $quiz->available_until)
                                        <div class="course-workspace-assessment-window">
                                            @if($quiz->available_from)
                                                <span>ចាប់ផ្តើម: {{ $quiz->available_from->format('d/m/Y H:i') }}</span>
                                            @endif
                                            @if($quiz->available_until)
                                                <span>បញ្ចប់: {{ $quiz->available_until->format('d/m/Y H:i') }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    @if($quizResult)
                                        <div class="course-workspace-done">
                                            <i class="fas fa-check-circle"></i>
                                            <span>បានដាក់រួចរាល់។ ពិន្ទុ: {{ number_format((float) $quizResult->total_score, 2) }}%</span>
                                        </div>
                                    @elseif(! auth()->check())
                                        <a class="course-workspace-assessment-link" href="{{ route('login') }}">
                                            <i class="fas fa-lock"></i>
                                            ចូលប្រើ ដើម្បីដាក់តេស្តខ្លី
                                        </a>
                                    @elseif(! auth()->user()?->student)
                                        <div class="course-workspace-empty-state is-compact">
                                            <i class="fas fa-user-graduate"></i>
                                            <span>ត្រូវការគណនីសិស្ស ដើម្បីដាក់តេស្តខ្លី។</span>
                                        </div>
                                    @elseif(! $quizOpen)
                                        <div class="course-workspace-empty-state is-compact">
                                            <i class="fas fa-clock"></i>
                                            <span>តេស្តខ្លីនេះមិនទាន់បើក ឬបានបិទហើយ។</span>
                                        </div>
                                    @elseif($lessonQuestions->isEmpty())
                                        <div class="course-workspace-empty-state is-compact">
                                            <i class="fas fa-question-circle"></i>
                                            <span>មិនទាន់មានសំណួរសម្រាប់តេស្តនេះទេ។</span>
                                        </div>
                                    @else
                                        <form
                                            class="course-workspace-submit-form"
                                            action="{{ route('frontend.courses.lessons.quizzes.submit', ['course' => $course, 'lesson' => $lesson, 'quiz' => $quiz]) }}"
                                            method="POST"
                                        >
                                            @csrf

                                            @foreach($lessonQuestions as $question)
                                                <div class="course-workspace-question">
                                                    <strong>{{ $loop->iteration }}. {!! $question->question_text !!}</strong>

                                                    @if($question->options->isNotEmpty())
                                                        <div class="course-workspace-options">
                                                            @foreach($question->options as $option)
                                                                <label class="course-workspace-option">
                                                                    <input type="radio" name="answers[{{ $question->assessment_question_id }}]" value="{{ $option->question_option_id }}">
                                                                    <span>{{ $option->option_text }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <textarea name="answers[{{ $question->assessment_question_id }}]" class="course-workspace-text-answer" placeholder="សរសេរចម្លើយរបស់អ្នក..."></textarea>
                                                    @endif
                                                </div>
                                            @endforeach
                                            <button type="submit" class="course-workspace-submit-btn">ដាក់ស្នើចម្លើយ</button>
                                        </form>
                                    @endif
                                </div>
                            </section>
                        @empty
                            <div class="course-workspace-empty-state">
                                <i class="fas fa-question-circle"></i>
                                <span>មិនទាន់មានតេស្តខ្លីសម្រាប់មេរៀននេះទេ។</span>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="course-workspace-panel" data-workspace-panel-content="assignment">
                    <div class="course-workspace-assessment-list">
                        @forelse($lessonAssignments as $assignment)
                            @php
                                $assignmentOpen = ! $assignment->due_at || $assignment->due_at->endOfDay()->gte(now()) || $assignment->allow_late_submission;
                                $submission = $assignmentSubmissions->get($assignment->content_assignment_id);
                            @endphp

                            <section class="course-workspace-assessment course-workspace-assessment--assignment">
                                <div class="course-workspace-assessment-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>

                                <div class="course-workspace-assessment-body">
                                    <div class="course-workspace-assessment-kicker">កិច្ចការ</div>
                                    <h4>{{ $assignment->title }}</h4>

                                    <div class="course-workspace-assessment-meta">
                                        <span>ពិន្ទុអតិបរមា: {{ number_format((float) $assignment->max_score, 0) }}</span>
                                        @if($assignment->due_at)
                                            <span>កាលបរិច្ឆេទកំណត់: {{ $assignment->due_at->format('d/m/Y H:i') }}</span>
                                        @else
                                            <span>គ្មានកាលកំណត់</span>
                                        @endif
                                        <span>{{ $assignmentOpen ? 'កំពុងបើក' : 'បានបិទ' }}</span>
                                    </div>

                                    @if($assignment->instructions)
                                        <div class="course-workspace-assessment-copy">{!! $assignment->instructions !!}</div>
                                    @else
                                        <p>សូមបំពេញកិច្ចការខាងក្រោម និងដាក់ស្នើតាមទម្រង់។</p>
                                    @endif

                                    @if($submission)
                                        <div class="course-workspace-done">
                                            <i class="fas fa-check-circle"></i>
                                            <span>បានដាក់ស្នើរួចហើយនៅថ្ងៃទី {{ $submission->submitted_at->format('d/m/Y H:i') }}</span>
                                            @if($submission->status === 'graded' || filled($submission->score))
                                                <strong>ពិន្ទុ: {{ $submission->score }} / {{ $assignment->max_score }}</strong>
                                                @if(filled($submission->feedback))
                                                    <span>Feedback: {{ $submission->feedback }}</span>
                                                @endif
                                            @else
                                                <span class="badge badge-info">កំពុងរង់ចាំការកែ</span>
                                            @endif
                                        </div>
                                    @elseif(! auth()->check())
                                        <a class="course-workspace-assessment-link" href="{{ route('login') }}">
                                            <i class="fas fa-lock"></i>
                                            ចូលប្រើ ដើម្បីដាក់កិច្ចការ
                                        </a>
                                    @elseif(! auth()->user()?->student)
                                        <div class="course-workspace-empty-state is-compact">
                                            <i class="fas fa-user-graduate"></i>
                                            <span>ត្រូវការគណនីសិស្ស ដើម្បីដាក់កិច្ចការ។</span>
                                        </div>
                                    @elseif(! $assignmentOpen)
                                        <div class="course-workspace-empty-state is-compact">
                                            <i class="fas fa-clock"></i>
                                            <span>កិច្ចការនេះបានបិទការដាក់ចម្លើយហើយ។</span>
                                        </div>
                                    @else
                                        <form
                                            class="course-workspace-submit-form"
                                            action="{{ route('frontend.courses.lessons.assignments.submit', ['course' => $course, 'lesson' => $lesson, 'assignment' => $assignment]) }}"
                                            method="POST"
                                            enctype="multipart/form-data"
                                        >
                                            @csrf
                                            <div class="form-group">
                                                <label for="response_{{ $assignment->content_assignment_id }}">ចម្លើយ/កំណត់ចំណាំ (បើមាន):</label>
                                                <textarea name="response" id="response_{{ $assignment->content_assignment_id }}" class="form-control" rows="5" placeholder="សរសេរចម្លើយ ឬការកត់សម្គាល់របស់អ្នកនៅទីនេះ..."></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="attachment_{{ $assignment->content_assignment_id }}">ឯកសារភ្ជាប់ (PDF, Image, Word, Zip...):</label>
                                                <input type="file" name="attachment" id="attachment_{{ $assignment->content_assignment_id }}" class="form-control-file">
                                            </div>
                                            <button type="submit" class="course-workspace-submit-btn">ដាក់ស្នើកិច្ចការ</button>
                                        </form>
                                    @endif
                                </div>
                            </section>
                        @empty
                            <div class="course-workspace-empty-state">
                                <i class="fas fa-tasks"></i>
                                <span>មិនទាន់មានកិច្ចការសម្រាប់មេរៀននេះទេ។</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </article>

            @if($lessonRecord?->allow_comments)
                <section class="course-workspace-discussion">
                    <div class="course-workspace-discussion-head">
                        <span>ការពិភាក្សា</span>
                        <strong>{{ $discussionPosts->count() }} មតិយោបល់</strong>
                    </div>

                    @auth
                        <form
                            class="course-workspace-comment-form"
                            action="{{ route('frontend.courses.lessons.discussion.store', ['course' => $course, 'lesson' => $lesson]) }}"
                            method="POST"
                        >
                            @csrf
                            <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('backend/img/avatar.png') }}" alt="{{ auth()->user()->name }}">
                            <div>
                                <textarea name="content" placeholder="សរសេរមតិយោបល់ ឬសួរដេញដោលនៅទីនេះ..." required></textarea>
                                <button type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                    ផ្ញើមតិ
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="course-workspace-empty-state is-compact">
                            <i class="fas fa-lock"></i>
                            <span><a href="{{ route('login') }}">ចូលប្រើប្រាស់</a> ដើម្បីចូលរួមការពិភាក្សា។</span>
                        </div>
                    @endauth

                    <div class="course-workspace-comment-list">
                        @forelse($discussionPosts as $post)
                            <article class="course-workspace-comment" id="comment-{{ $post->discussion_post_id }}">
                                <img src="{{ $post->user?->avatar ? asset('storage/'.$post->user->avatar) : asset('backend/img/avatar.png') }}" alt="{{ $post->user?->name }}">
                                <div>
                                    <strong>{{ $post->user?->name ?? 'User' }} <small>{{ $post->created_at->diffForHumans() }}</small></strong>
                                    <p>{!! nl2br(e($post->content)) !!}</p>
                                </div>
                            </article>
                        @empty
                            <div class="course-workspace-empty-state is-compact">
                                <i class="far fa-comments"></i>
                                <span>មិនទាន់មានការពិភាក្សាសម្រាប់មេរៀននេះនៅឡើយទេ។ ផ្ដើមការពិភាក្សាដំបូងគេ!</span>
                            </div>
                        @endforelse
                    </div>
                </section>
            @endif
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
            align-items: start;
            background: #f4f7fd;
            transition: grid-template-columns .28s ease;
        }

        .course-workspace-sidebar {
            position: sticky;
            top: 70px;
            height: calc(100vh - 70px);
            max-height: calc(100vh - 70px);
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
            display: grid;
            gap: 4px;
            width: 224px;
            padding: 8px;
            border: 1px solid #d9e2ef;
            border-radius: 7px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(38, 54, 75, .08);
            opacity: 0;
            transform: translateY(8px);
            pointer-events: none;
            transition: opacity .18s ease, transform .18s ease;
        }

        .course-workspace-more.is-open .course-workspace-more-menu {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .course-workspace-more-menu a {
            min-height: 40px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 14px;
            border-radius: 5px;
            color: #53657f;
            font-size: 15px;
            text-decoration: none;
            transition: background-color .15s ease, color .15s ease;
        }

        .course-workspace-more-menu a:hover {
            background: #f4f7fd;
            color: #237dbe;
        }

        .course-workspace-brand {
            display: flex;
            align-items: center;
            min-height: 52px;
            margin: 0;
            padding: 0 30px 10px;
            color: #1a2a3e;
            font-size: 18px;
            font-weight: 900;
            letter-spacing: .02em;
        }

        .course-workspace-lessons {
            padding: 10px 30px 42px;
        }

        .course-workspace-module {
            min-height: 52px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            width: 100%;
            margin-top: 14px;
            padding: 0;
            border: 0;
            background: transparent;
            color: #1a2a3e;
            font-size: 16px;
            font-weight: 900;
            text-align: left;
            cursor: pointer;
        }

        .course-workspace-module i {
            color: #66758c;
            font-size: 14px;
            transition: transform .24s ease;
        }

        .course-workspace-module.is-collapsed i {
            transform: rotate(180deg);
        }

        .course-workspace-module-lessons {
            display: grid;
            gap: 4px;
            max-height: 2000px;
            overflow: hidden;
            transition: max-height .32s cubic-bezier(0, 1, 0, 1);
        }

        .course-workspace-module-lessons.is-collapsed {
            max-height: 0;
        }

        .course-workspace-lesson-node {
            display: grid;
            gap: 4px;
        }

        .course-workspace-lessons a {
            min-height: 48px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-radius: 6px;
            color: #53657f;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color .18s ease, color .18s ease, font-weight .18s ease;
        }

        .course-workspace-lessons a:hover {
            background: #edf5ff;
            color: #0f63b7;
            text-decoration: none;
        }

        .course-workspace-lessons a.is-active {
            background: #237dbe;
            color: #fff;
            font-weight: 900;
        }

        .course-workspace-topics,
        .course-detail-topics {
            display: grid;
            gap: 4px;
            padding: 0 20px 10px;
            color: #66758c;
            font-size: 14px;
            line-height: 1.45;
        }

        .course-workspace-topics a,
        .course-detail-topics a {
            min-height: auto;
            display: block;
            padding: 4px 8px;
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

        .course-workspace-topics a.is-active,
        .course-detail-topics a.is-active {
            background: #eaf1ff;
            color: #0f63b7;
            font-weight: 800;
            padding: 4px 8px;
            margin: 0 -8px;
        }

        .course-workspace-main {
            min-width: 0;
            padding: 42px 58px 64px;
        }

        .course-workspace-open-menu {
            display: none;
            align-items: center;
            gap: 8px;
            height: 38px;
            margin-bottom: 24px;
            padding: 0 14px;
            border: 1px solid #237dbe;
            border-radius: 6px;
            background: transparent;
            color: #237dbe;
            font-size: 15px;
            font-weight: 900;
            cursor: pointer;
            transition: background-color .15s ease, color .15s ease;
        }

        .course-workspace-open-menu:hover {
            background: #237dbe;
            color: #fff;
        }

        .course-workspace-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 16px;
            color: #66758c;
            font-size: 14px;
        }

        .course-workspace-breadcrumb a {
            color: inherit;
            text-decoration: none;
        }

        .course-workspace-breadcrumb a:hover {
            color: #237dbe;
        }

        .course-workspace-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 38px;
        }

        .course-workspace-title-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: #237dbe;
            color: #fff;
            font-size: 20px;
        }

        .course-workspace-header h2 {
            margin: 0;
            color: #1a2a3e;
            font-size: 32px;
            font-weight: 900;
        }

        .course-workspace-alert {
            margin-bottom: 24px;
            padding: 14px 20px;
            border-radius: 6px;
            font-size: 15px;
        }

        .course-workspace-alert--success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .course-workspace-alert--danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .course-workspace-tabs {
            display: flex;
            align-items: center;
            height: 52px;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 28px;
        }

        .course-workspace-tabs button {
            position: relative;
            height: 100%;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0 24px;
            border: 0;
            background: transparent;
            color: #64748b;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: color .2s ease;
        }

        .course-workspace-tabs button::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 3px;
            background: #237dbe;
            transform: scaleX(0);
            transition: transform .2s ease;
        }

        .course-workspace-tabs button.is-active {
            color: #237dbe;
            font-weight: 800;
        }

        .course-workspace-tabs button.is-active::after {
            transform: scaleX(1);
        }

        .course-workspace-tabs button span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            border-radius: 10px;
            background: #cbd5e1;
            color: #1e293b;
            font-size: 11px;
            font-weight: 700;
        }

        .course-workspace-tabs button.is-active span {
            background: #237dbe;
            color: #fff;
        }

        .course-workspace-card {
            padding: 30px;
            border-radius: 7px;
            background: #fff;
            box-shadow: 0 12px 34px rgba(30, 55, 90, .05);
        }

        .course-workspace-card h3 {
            margin: 0 0 24px;
            color: #1a2a3e;
            font-size: 20px;
            font-weight: 900;
        }

        .course-workspace-panel {
            display: none;
        }

        .course-workspace-panel.is-active {
            display: block;
        }

        .course-workspace-frame {
            position: relative;
            width: 100%;
            height: 480px;
            border-radius: 6px;
            background: #09121d;
            overflow: hidden;
        }

        .course-workspace-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, #1a2e46 0%, #080f18 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .course-workspace-play {
            width: 72px;
            height: 72px;
            border: 0;
            border-radius: 50%;
            background: #237dbe;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px rgba(35, 125, 190, .4);
            transition: transform .2s ease, background-color .2s ease, box-shadow .2s ease;
        }

        .course-workspace-play:hover {
            background: #2a8ad0;
            transform: scale(1.08);
            box-shadow: 0 12px 28px rgba(35, 125, 190, .5);
        }

        .course-workspace-play i {
            margin-left: 4px;
        }

        .course-workspace-document {
            padding: 10px 0;
        }

        .course-workspace-document span {
            color: #66758c;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .course-workspace-document h4 {
            margin: 8px 0 16px;
            color: #1a2a3e;
            font-size: 24px;
            font-weight: 900;
        }

        .course-workspace-document p {
            color: #53657f;
            font-size: 16px;
            line-height: 1.6;
        }

        .course-workspace-assessment-list {
            display: grid;
            gap: 20px;
        }

        .course-workspace-assessment {
            display: grid;
            grid-template-columns: 54px minmax(0, 1fr);
            gap: 20px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: #fff;
        }

        .course-workspace-assessment-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: #edf5ff;
            color: #237dbe;
            font-size: 20px;
        }

        .course-workspace-assessment-body {
            display: grid;
            gap: 8px;
        }

        .course-workspace-assessment-kicker {
            color: #237dbe;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .course-workspace-assessment-body h4 {
            margin: 0;
            color: #1a2a3e;
            font-size: 18px;
            font-weight: 900;
        }

        .course-workspace-assessment-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            color: #64748b;
            font-size: 13px;
        }

        .course-workspace-assessment-copy {
            margin-top: 8px;
            color: #53657f;
            font-size: 15px;
            line-height: 1.5;
        }

        .course-workspace-assessment-window {
            display: flex;
            align-items: center;
            gap: 16px;
            color: #e53e3e;
            font-size: 13px;
            font-weight: 600;
        }

        .course-workspace-done {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
            padding: 10px 16px;
            border-radius: 5px;
            background: #def7ec;
            color: #03543f;
            font-size: 14px;
            font-weight: 600;
        }

        .course-workspace-done i {
            font-size: 18px;
        }

        .course-workspace-assessment-link {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            justify-self: start;
            margin-top: 12px;
            border-radius: 5px;
            background: #237dbe;
            color: #fff;
            padding: 0 16px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: background-color .15s ease;
        }

        .course-workspace-assessment-link:hover {
            background: #2a8ad0;
            color: #fff;
            text-decoration: none;
        }

        .course-workspace-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            padding: 42px 24px;
            border: 2px dashed #cbd5e1;
            border-radius: 6px;
            color: #64748b;
            text-align: center;
        }

        .course-workspace-empty-state i {
            font-size: 32px;
        }

        .course-workspace-empty-state.is-compact {
            padding: 20px;
            border: 0;
            background: #f8fafc;
            border-radius: 6px;
            flex-direction: row;
            justify-content: start;
            gap: 12px;
            text-align: left;
        }

        .course-workspace-empty-state.is-compact i {
            font-size: 20px;
        }

        .course-workspace-submit-form {
            display: grid;
            gap: 16px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px dashed #cbd5e1;
        }

        .course-workspace-question {
            display: grid;
            gap: 10px;
        }

        .course-workspace-question strong {
            color: #1e293b;
            font-size: 15px;
        }

        .course-workspace-options {
            display: grid;
            gap: 8px;
            padding-left: 14px;
        }

        .course-workspace-option {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-size: 14px;
            cursor: pointer;
        }

        .course-workspace-text-answer {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            resize: vertical;
        }

        .course-workspace-submit-btn {
            justify-self: start;
            height: 38px;
            padding: 0 20px;
            border: 0;
            border-radius: 5px;
            background: #237dbe;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color .15s ease;
        }

        .course-workspace-submit-btn:hover {
            background: #2a8ad0;
        }

        .course-workspace-secondary {
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 6px;
            background: #fff;
            border: 1px solid #cbd5e1;
            color: #53657f;
            padding: 0 20px;
            font-weight: 900;
            text-decoration: none;
            transition: background-color .15s ease, color .15s ease;
        }

        .course-workspace-secondary:hover {
            background: #f8fafc;
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
                position: static;
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

            .course-workspace-tabs {
                align-items: stretch;
                flex-direction: column;
                height: auto;
                padding: 12px;
            }

            .course-workspace-tabs button {
                justify-content: center;
                width: 100%;
            }

            .course-workspace-assessment {
                grid-template-columns: 1fr;
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
            // Function to open the specified panel
            const openWorkspacePanel = function(panel) {
                const $targetTab = $(`[data-workspace-panel="${panel}"]`);

                if (! $targetTab.length) {
                    return;
                }

                $('[data-workspace-panel]').removeClass('is-active');
                $targetTab.addClass('is-active');
                $('[data-workspace-panel-content]').removeClass('is-active');
                $(`[data-workspace-panel-content="${panel}"]`).addClass('is-active');

                // Update active state in sidebar topic links
                $('.js-workspace-topic-link').removeClass('is-active');
                $(`.js-workspace-topic-link[data-panel="${panel}"]`).addClass('is-active');
            };

            // AJAX loader function
            const loadLessonViaAjax = function(url, pushState = true) {
                const $main = $('.course-workspace-main');
                // Premium micro-animation: fade out
                $main.animate({ opacity: 0.35 }, 150, function() {
                    fetch(url)
                        .then(response => {
                            if (!response.ok) throw new Error('Response error');
                            return response.text();
                        })
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            // Swap workspace main content
                            const newMain = doc.querySelector('.course-workspace-main');
                            if (newMain) {
                                $main.html(newMain.innerHTML);
                            }

                            // Swap sidebar
                            const newSidebar = doc.querySelector('.course-workspace-sidebar');
                            if (newSidebar) {
                                $('.course-workspace-sidebar').html(newSidebar.innerHTML);
                            } else {
                                const newDetailSidebar = doc.querySelector('.course-detail-sidebar');
                                if (newDetailSidebar) {
                                    $('.course-detail-sidebar').html(newDetailSidebar.innerHTML);
                                }
                            }

                            // Update Page Title
                            document.title = doc.title;

                            // Update address bar
                            if (pushState) {
                                window.history.pushState(null, '', url);
                            }

                            // Activate correct panel tab if specified
                            const panel = new URLSearchParams(window.location.search).get('panel') || 'video';
                            openWorkspacePanel(panel);

                            // Premium fade-in animation
                            $main.animate({ opacity: 1 }, 150);
                        })
                        .catch(error => {
                            console.error('AJAX loading failed:', error);
                            window.location.href = url;
                        });
                });
            };

            // Event delegation for sidebar toggle controls
            $(document).on('click', '.js-course-sidebar-close', function() {
                $('.course-workspace').addClass('is-course-sidebar-hidden');
            });

            $(document).on('click', '.js-course-sidebar-open', function() {
                $('.course-workspace').removeClass('is-course-sidebar-hidden');
            });

            $(document).on('click', '.js-course-module-toggle', function() {
                const $button = $(this);
                const $lessons = $('#' + $button.attr('aria-controls'));
                const isOpen = $button.attr('aria-expanded') === 'true';

                $button
                    .toggleClass('is-collapsed', isOpen)
                    .attr('aria-expanded', String(!isOpen));
                $lessons.toggleClass('is-collapsed', isOpen);
            });

            $(document).on('click', '.js-course-more-toggle', function(event) {
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

            // Tab switching panel
            $(document).on('click', '[data-workspace-panel]', function() {
                const panel = $(this).data('workspace-panel');
                openWorkspacePanel(panel);

                // Update URL search parameters without reloading
                const url = new URL(window.location.href);
                url.searchParams.set('panel', panel);
                window.history.pushState(null, '', url.toString());
            });

            // Intercept clicks on lesson and topic links
            $(document).on('click', '.course-workspace-lesson-link, .course-lesson-node > a, .js-workspace-topic-link', function(event) {
                const url = new URL(this.href);
                const currentUrl = new URL(window.location.href);

                // If it is a topic link pointing to the current lesson (same pathname)
                if ($(this).hasClass('js-workspace-topic-link') && url.pathname === currentUrl.pathname) {
                    event.preventDefault();
                    const panel = $(this).data('panel') || url.searchParams.get('panel');
                    if (panel) {
                        openWorkspacePanel(panel);
                        window.history.pushState(null, '', this.href);
                    }
                    return;
                }

                // If it points to a lesson/page inside our workspace (same origin and contains "/lessons/")
                if (url.origin === currentUrl.origin && url.pathname.includes('/lessons/')) {
                    event.preventDefault();
                    loadLessonViaAjax(this.href, true);
                }
            });

            // Listen for browser back/forward buttons (popstate)
            window.addEventListener('popstate', function() {
                loadLessonViaAjax(window.location.href, false);
            });

            // Initial panel activation on page load
            const initialPanel = new URLSearchParams(window.location.search).get('panel');
            if (initialPanel) {
                openWorkspacePanel(initialPanel);
            }
        });
    </script>
@endpush
