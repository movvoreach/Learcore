<?php

namespace App\Filament\Admin\Pages;

use App\Models\ContentAssignment;
use App\Models\ContentChapter;
use App\Models\ContentDocument;
use App\Models\ContentLesson;
use App\Models\ContentResource;
use App\Models\ContentVideo;
use App\Models\Course;
use App\Models\Quiz;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;

class CourseLessons extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'course/{course}/lessons';

    protected static ?string $title = 'មេរៀនវគ្គសិក្សា';

    protected string $view = 'filament.admin.pages.course-lessons';

    public Course $courseRecord;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    public function mount(mixed $course): void
    {
        $user = auth()->user();
        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin', 'teacher']), 403);

        $courseId = $course instanceof Course ? (int) $course->getKey() : (int) $course;

        $this->courseRecord = Course::query()
            ->with(['department', 'academicYear', 'semester', 'category', 'courseAssignments.teacher'])
            ->whereKey($courseId)
            ->firstOrFail();
    }

    public function getTitle(): string
    {
        return 'មេរៀន: ' . $this->courseRecord->course_name;
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $lessons = ContentLesson::query()
            ->where('course_id', $this->courseRecord->course_id)
            ->with([
                'chapters' => fn ($query) => $query->orderBy('sort_order'),
                'videos' => fn ($query) => $query->orderBy('sort_order'),
                'documents' => fn ($query) => $query->orderBy('sort_order'),
                'assignments' => fn ($query) => $query->orderBy('due_at'),
                'resources' => fn ($query) => $query->orderBy('sort_order'),
                'quizzes' => fn ($query) => $query->orderBy('available_from'),
            ])
            ->orderBy('module_number')
            ->orderBy('position')
            ->get();

        $teacher = $this->courseRecord->courseAssignments->first()?->teacher;

        return [
            'course' => $this->courseRecord,
            'lessons' => $lessons,
            'teacherName' => $teacher ? trim($teacher->first_name . ' ' . $teacher->last_name) : 'មិនទាន់កំណត់',
            'totalLessons' => $lessons->count(),
            'publishedCount' => $lessons->where('is_published', true)->count(),
            'draftCount' => $lessons->where('is_published', false)->count(),
            'totalChapters' => $lessons->sum(fn (ContentLesson $l): int => $l->chapters->count()),
            'totalAssignments' => $lessons->sum(fn (ContentLesson $l): int => $l->assignments->count()),
            'totalQuizzes' => $lessons->sum(fn (ContentLesson $l): int => $l->quizzes->count()),
        ];
    }

    public function deleteLesson(int $lessonId): void
    {
        $lesson = ContentLesson::query()
            ->where('course_id', $this->courseRecord->course_id)
            ->whereKey($lessonId)
            ->firstOrFail();

        $lesson->delete();

        $this->dispatch('$refresh');
    }

    public function deleteContentItem(string $type, int $id): void
    {
        [$model, $key] = match ($type) {
            'chapter' => [ContentChapter::class, 'content_chapter_id'],
            'video' => [ContentVideo::class, 'content_video_id'],
            'document' => [ContentDocument::class, 'content_document_id'],
            'assignment' => [ContentAssignment::class, 'content_assignment_id'],
            'quiz' => [Quiz::class, 'quiz_id'],
            'resource' => [ContentResource::class, 'content_resource_id'],
            default => abort(404),
        };

        $model::query()
            ->where($key, $id)
            ->whereHas('lesson', fn (Builder $query): Builder => $query->where('course_id', $this->courseRecord->course_id))
            ->firstOrFail()
            ->delete();

        $this->dispatch('$refresh');
    }
}
