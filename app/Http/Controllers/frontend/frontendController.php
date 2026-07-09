<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\DiscussionComment;
use App\Models\DiscussionPost;
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

        return view('frontend.lesson', [
            'course' => $course,
            'courseRecord' => $courseRecord,
            'lessons' => $lessons,
            'lessonRecord' => $lessonRecord,
            'nextLesson' => $nextLesson,
            'lesson' => $lesson,
            'discussionPosts' => $discussionPosts,
        ]);
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
