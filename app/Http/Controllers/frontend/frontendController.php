<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentResult;
use App\Models\AssignmentSubmission;
use App\Models\ContentAssignment;
use App\Models\Course;
use App\Models\DiscussionComment;
use App\Models\DiscussionPost;
use App\Models\Quiz;
use App\Models\Student;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class frontendController extends Controller
{
    public function index()
    {
        $coursesQuery = Course::query()
            ->visibleOnFrontend(auth()->user())
            ->with(['category', 'instructor.user', 'academicYear']);

        $courses = $coursesQuery
            ->withCount([
                'contentLessons as lessons_count',
                'enrollments as students_count',
            ])
            ->withSum('contentLessons as total_duration_minutes', 'duration_minutes')
            ->latest()
            ->paginate(12);

        return view('frontend.frontend', compact('courses'));
    }

    public function courses()
    {
        $coursesQuery = Course::query()
            ->visibleOnFrontend(auth()->user());

        $courses = (clone $coursesQuery)
            ->with(['category', 'instructor.user', 'academicYear'])
            ->withCount([
                'contentLessons as lessons_count',
                'enrollments as students_count',
            ])
            ->withSum('contentLessons as total_duration_minutes', 'duration_minutes')
            ->latest()
            ->paginate(12);

        $categories = \App\Models\CourseCategory::whereHas(
            'courses',
            fn ($query) => $query->visibleOnFrontend(auth()->user())
        )->get();

        return view('frontend.courses', compact('courses', 'categories'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function programs()
    {
        return view('frontend.programs');
    }

    public function courseDetail(string $course = 'web-development')
    {
        $courseRecord = $this->resolveCourse($course);
        $lessons = $courseRecord?->contentLessons()
            ->publishedForStudents()
            ->with([
                'chapters' => fn ($query) => $query
                    ->where('is_published', true)
                    ->orderBy('sort_order')
                    ->orderBy('content_chapter_id'),
                'assignments' => fn ($query) => $query
                    ->where('is_published', true)
                    ->orderBy('due_at')
                    ->orderBy('content_assignment_id'),
                'quizzes' => fn ($query) => $query
                    ->where('is_published', true)
                    ->orderBy('available_from')
                    ->orderBy('quiz_id'),
                'assessmentQuestions' => fn ($query) => $query
                    ->where('is_active', true)
                    ->with(['options' => fn ($optionQuery) => $optionQuery->orderBy('sort_order')]),
            ])
            ->orderBy('module_number')
            ->orderBy('position')
            ->get()
            ?? collect();
        $discussionPosts = $courseRecord
            ? $this->discussionPostsQuery($courseRecord)->whereNull('content_lesson_id')->get()
            : collect();

        return view('frontend.course-detail', [
            'course' => $course,
            'courseRecord' => $courseRecord,
            'lessons' => $lessons,
            'discussionPosts' => $discussionPosts,
        ]);
    }

    public function lesson(string $course, string $lesson)
    {
        $courseRecord = $this->resolveCourse($course);
        $lessons = $courseRecord?->contentLessons()
            ->publishedForStudents()
            ->with([
                'chapters' => fn ($query) => $query
                    ->where('is_published', true)
                    ->orderBy('sort_order')
                    ->orderBy('content_chapter_id'),
                'assignments' => fn ($query) => $query
                    ->where('is_published', true)
                    ->orderBy('due_at')
                    ->orderBy('content_assignment_id'),
                'quizzes' => fn ($query) => $query
                    ->where('is_published', true)
                    ->orderBy('available_from')
                    ->orderBy('quiz_id'),
                'assessmentQuestions' => fn ($query) => $query
                    ->where('is_active', true)
                    ->with(['options' => fn ($optionQuery) => $optionQuery->orderBy('sort_order')]),
            ])
            ->orderBy('module_number')
            ->orderBy('position')
            ->get()
            ?? collect();
        $lessonRecord = $lessons->firstWhere('slug', $lesson);
        $nextLesson = $lessonRecord
            ? $lessons->skipUntil(fn ($contentLesson) => $contentLesson->is($lessonRecord))->skip(1)->first()
            : null;
        $discussionPosts = $courseRecord && $lessonRecord
            ? $this->discussionPostsQuery($courseRecord)->where('content_lesson_id', $lessonRecord->content_lesson_id)->get()
            : collect();
        $student = auth()->user()?->student;
        $quizResults = $student && $lessonRecord
            ? AssessmentResult::query()
                ->where('student_id', $student->student_id)
                ->whereIn('quiz_id', $lessonRecord->quizzes->pluck('quiz_id'))
                ->get()
                ->keyBy('quiz_id')
            : collect();
        $assignmentSubmissions = $student && $lessonRecord
            ? AssignmentSubmission::query()
                ->where('student_id', $student->student_id)
                ->whereIn('content_assignment_id', $lessonRecord->assignments->pluck('content_assignment_id'))
                ->latest('submitted_at')
                ->get()
                ->keyBy('content_assignment_id')
            : collect();

        return view('frontend.lesson', [
            'course' => $course,
            'courseRecord' => $courseRecord,
            'lessons' => $lessons,
            'lessonRecord' => $lessonRecord,
            'nextLesson' => $nextLesson,
            'lesson' => $lesson,
            'discussionPosts' => $discussionPosts,
            'quizResults' => $quizResults,
            'assignmentSubmissions' => $assignmentSubmissions,
        ]);
    }

    public function submitQuiz(Request $request, string $course, string $lesson, Quiz $quiz): RedirectResponse
    {
        $student = $this->studentForSubmission($request);
        $lessonRecord = $this->lessonForSubmission($course, $lesson);

        abort_unless((int) $quiz->content_lesson_id === (int) $lessonRecord->content_lesson_id, 404);
        abort_unless($quiz->is_published, 404);

        $quizOpen = (! $quiz->available_from || $quiz->available_from <= now())
            && (! $quiz->available_until || $quiz->available_until >= now());

        if (! $quizOpen) {
            return redirect()->back()->with('assessment_error', 'តេស្តខ្លីនេះមិនទាន់បើកឱ្យដាក់ចម្លើយទេ។');
        }

        $validated = $request->validate([
            'answers' => ['nullable', 'array'],
            'answers.*' => ['nullable', 'string', 'max:5000'],
        ]);

        $questions = AssessmentQuestion::query()
            ->where('content_lesson_id', $lessonRecord->content_lesson_id)
            ->where('is_active', true)
            ->with('options')
            ->get();

        $answers = collect($validated['answers'] ?? []);
        $totalPoints = max((float) $questions->sum('points'), 1);
        $earnedPoints = 0.0;

        foreach ($questions as $question) {
            $answer = $answers->get((string) $question->assessment_question_id);

            if ($question->options->isNotEmpty()) {
                $selectedOption = $question->options->firstWhere('question_option_id', (int) $answer);

                if ($selectedOption?->is_correct) {
                    $earnedPoints += (float) $question->points;
                }

                continue;
            }

            if ($question->correct_answer && Str::lower(trim((string) $answer)) === Str::lower(trim($question->correct_answer))) {
                $earnedPoints += (float) $question->points;
            }
        }

        $score = round(($earnedPoints / $totalPoints) * 100, 2);

        AssessmentResult::query()->updateOrCreate(
            [
                'student_id' => $student->student_id,
                'quiz_id' => $quiz->quiz_id,
            ],
            [
                'assessment_type' => 'quiz',
                'total_score' => $score,
                'passed' => $score >= (float) $quiz->passing_score,
                'published_at' => now(),
                'remarks' => 'Submitted from public lesson page.',
            ],
        );

        return redirect()->back()->with('assessment_success', 'បានដាក់តេស្តខ្លីរួចរាល់។ ពិន្ទុរបស់អ្នក: '.$score.'%');
    }

    public function submitAssignment(Request $request, string $course, string $lesson, ContentAssignment $assignment): RedirectResponse
    {
        $student = $this->studentForSubmission($request);
        $lessonRecord = $this->lessonForSubmission($course, $lesson);

        abort_unless((int) $assignment->content_lesson_id === (int) $lessonRecord->content_lesson_id, 404);
        abort_unless($assignment->is_published, 404);

        $assignmentOpen = $assignment->allow_late_submission
            || ! $assignment->due_at
            || $assignment->due_at->endOfDay()->gte(now());

        if (! $assignmentOpen) {
            return redirect()->back()->with('assessment_error', 'កិច្ចការនេះផុតកំណត់ដាក់ស្នើហើយ។');
        }

        $validated = $request->validate([
            'response' => ['nullable', 'string', 'max:10000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,zip,rar', 'max:10240'],
        ]);

        if (! $request->filled('response') && ! $request->hasFile('attachment')) {
            return redirect()->back()->withErrors(['response' => 'សូមសរសេរចម្លើយ ឬ Upload ឯកសារ។']);
        }

        $existingSubmission = AssignmentSubmission::query()
            ->where('content_assignment_id', $assignment->content_assignment_id)
            ->where('student_id', $student->student_id)
            ->first();
        $attachmentUrl = $existingSubmission?->attachment_url;

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('assignment-submissions', 'public');
            $attachmentUrl = $path;
        }

        AssignmentSubmission::query()->updateOrCreate(
            [
                'content_assignment_id' => $assignment->content_assignment_id,
                'student_id' => $student->student_id,
            ],
            [
                'response' => $validated['response'] ?? null,
                'attachment_url' => $attachmentUrl,
                'submitted_at' => now(),
                'status' => 'submitted',
            ],
        );

        return redirect()->back()->with('assessment_success', 'បានដាក់កិច្ចការរួចរាល់។ គ្រូអាចពិនិត្យបានហើយ។');
    }

    public function storeCourseDiscussion(Request $request, string $course): RedirectResponse|JsonResponse
    {
        $courseRecord = $this->resolveCourse($course);
        abort_unless($courseRecord, 404);

        $this->createDiscussionPost($request, $courseRecord);

        if ($request->expectsJson()) {
            return $this->discussionJsonResponse($courseRecord);
        }

        return redirect()->back();
    }

    public function storeLessonDiscussion(Request $request, string $course, string $lesson): RedirectResponse|JsonResponse
    {
        $courseRecord = $this->resolveCourse($course);
        abort_unless($courseRecord, 404);

        $lessonRecord = $courseRecord->contentLessons()
            ->publishedForStudents()
            ->where('slug', $lesson)
            ->firstOrFail();

        $this->createDiscussionPost($request, $courseRecord, $lessonRecord->content_lesson_id);

        if ($request->expectsJson()) {
            return $this->discussionJsonResponse($courseRecord, $lessonRecord->content_lesson_id);
        }

        return redirect()->back();
    }

    public function storeDiscussionComment(Request $request, DiscussionPost $discussionPost): RedirectResponse|JsonResponse
    {
        $canSeeCourse = Course::query()
            ->visibleOnFrontend($request->user())
            ->whereKey($discussionPost->course_id)
            ->exists();

        abort_unless($canSeeCourse, 403);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $request->file('image')?->store('discussion-images', 'public');

        DiscussionComment::query()->create([
            'discussion_post_id' => $discussionPost->discussion_post_id,
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
            'image_path' => $imagePath,
            'status' => 'published',
        ]);

        if ($request->expectsJson()) {
            return $this->discussionJsonResponse($discussionPost->course, $discussionPost->content_lesson_id);
        }

        return redirect()->back();
    }

    public function togglePostReaction(Request $request, DiscussionPost $discussionPost): JsonResponse
    {
        $this->authorizeDiscussionCourse($request, $discussionPost->course_id);

        $this->toggleReaction($discussionPost->reactions(), $request->user()->id, 'discussion_post_id');

        return $this->discussionJsonResponse($discussionPost->course, $discussionPost->content_lesson_id);
    }

    public function toggleCommentReaction(Request $request, DiscussionComment $discussionComment): JsonResponse
    {
        $discussionComment->loadMissing('post.course');
        $this->authorizeDiscussionCourse($request, $discussionComment->post->course_id);

        $this->toggleReaction($discussionComment->reactions(), $request->user()->id, 'discussion_comment_id');

        return $this->discussionJsonResponse(
            $discussionComment->post->course,
            $discussionComment->post->content_lesson_id
        );
    }

    private function resolveCourse(string $course): ?Course
    {
        $query = Course::query()
            ->visibleOnFrontend(auth()->user())
            ->with(['category', 'instructor.user', 'academicYear'])
            ->withCount([
                'contentLessons as lessons_count',
                'enrollments as students_count',
            ])
            ->withSum('contentLessons as total_duration_minutes', 'duration_minutes');

        if (is_numeric($course)) {
            return (clone $query)->find((int) $course);
        }

        if (preg_match('/-(\d+)$/', $course, $matches)) {
            return (clone $query)->find((int) $matches[1]);
        }

        $courseByCode = (clone $query)->where('course_code', $course)->first();

        if ($courseByCode) {
            return $courseByCode;
        }

        return (clone $query)
            ->get()
            ->first(fn (Course $courseRecord): bool => Str::slug($courseRecord->course_name) === Str::slug($course));
    }

    private function createDiscussionPost(Request $request, Course $course, ?int $contentLessonId = null): DiscussionPost
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $request->file('image')?->store('discussion-images', 'public');

        return DiscussionPost::query()->create([
            'course_id' => $course->course_id,
            'content_lesson_id' => $contentLessonId,
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
            'image_path' => $imagePath,
            'status' => 'published',
        ]);
    }

    private function discussionPostsQuery(Course $course): HasMany
    {
        $user = auth()->user();

        $query = $course->discussionPosts()
            ->published()
            ->with([
                'author',
                'publishedComments' => function ($query) use ($user): void {
                    $query = $query
                        ->with('author')
                        ->withCount('reactions');

                    if ($user) {
                        $query->withExists([
                            'reactions as reacted_by_current_user' => fn ($query) => $query->where('user_id', $user->id),
                        ]);
                    }
                },
            ])
            ->withCount('reactions');

        if ($user) {
            $query->withExists([
                'reactions as reacted_by_current_user' => fn ($query) => $query->where('user_id', $user->id),
            ]);
        }

        return $query->latest();
    }

    private function discussionJsonResponse(Course $course, ?int $contentLessonId = null): JsonResponse
    {
        $query = $this->discussionPostsQuery($course);

        if ($contentLessonId) {
            $query->where('content_lesson_id', $contentLessonId);
        } else {
            $query->whereNull('content_lesson_id');
        }

        $discussionPosts = $query->get();

        return response()->json([
            'html' => view('frontend.partials.course.discussion-list', compact('discussionPosts'))->render(),
        ]);
    }

    private function authorizeDiscussionCourse(Request $request, int $courseId): void
    {
        $canSeeCourse = Course::query()
            ->visibleOnFrontend($request->user())
            ->whereKey($courseId)
            ->exists();

        abort_unless($canSeeCourse, 403);
    }

    private function studentForSubmission(Request $request): Student
    {
        $student = $request->user()?->student;

        abort_unless($student, 403);

        return $student;
    }

    private function lessonForSubmission(string $course, string $lesson): \App\Models\ContentLesson
    {
        $courseRecord = $this->resolveCourse($course);
        abort_unless($courseRecord, 404);

        return $courseRecord->contentLessons()
            ->publishedForStudents()
            ->where('slug', $lesson)
            ->firstOrFail();
    }

    private function toggleReaction(HasMany $reactions, int $userId, string $targetKey): void
    {
        $reaction = $reactions->where('user_id', $userId)->first();

        if ($reaction) {
            $reaction->delete();

            return;
        }

        $reactions->create([
            'user_id' => $userId,
            $targetKey => $reactions->getParent()->getKey(),
            'type' => 'like',
        ]);
    }

}
