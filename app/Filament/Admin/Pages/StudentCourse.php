<?php

namespace App\Filament\Admin\Pages;

use App\Models\AssessmentGrade;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentResult;
use App\Models\AssignmentSubmission;
use App\Models\ContentLesson;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class StudentCourse extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'my-courses/{course}';

    protected static ?string $title = 'Course';

    protected string $view = 'filament.admin.pages.student-course';

    public Course $courseRecord;

    public ?Student $student = null;

    public bool $isContentManager = false;

    /**
     * @var array<int>
     */
    public array $completedLessonIds = [];

    public ?int $lastViewedLessonId = null;

    public float $progressPercent = 0.0;

    /**
     * @var array<int, mixed>
     */
    public array $quizAnswers = [];

    public ?string $assignmentResponse = null;

    public ?string $assignmentAttachmentUrl = null;

    public function mount(mixed $course): void
    {
        $user = auth()->user();
        $student = $user?->student;

        abort_unless($user, 403);

        $this->student = $student;
        $this->isContentManager = $this->userCanManageContent($user);

        $courseQuery = Course::query()
            ->with(['department', 'academicYear', 'semester', 'courseAssignments.teacher'])
            ->whereKey($this->courseIdFromRouteParameter($course));

        if ($this->isContentManager) {
            if ($user->hasRole('teacher') && ! $user->hasAnyRole(['super_admin', 'admin'])) {
                abort_unless($user->teacher, 403);

                $courseQuery->whereHas('courseAssignments', fn (Builder $query): Builder => $query
                    ->where('teacher_id', $user->teacher->teacher_id));
            }
        } else {
            abort_unless($student, 403);

            $courseQuery->availableToStudent($student);
        }

        $this->courseRecord = $courseQuery->firstOrFail();

        $progress = $this->progressRecord();
        $this->progressPercent = (float) ($progress?->progress_percent ?? 0);
        $note = $this->decodeProgressNote($progress?->note);

        $this->completedLessonIds = Arr::wrap($note['completed_lesson_ids'] ?? []);
        $this->lastViewedLessonId = $note['last_lesson_id'] ?? null;
    }

    public function getTitle(): string
    {
        return $this->courseRecord->course_name;
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $lessons = ContentLesson::query()
            ->where('course_id', $this->courseRecord->course_id)
            ->with([
                'chapters' => fn ($query) => $query
                    ->when(! $this->isContentManager, fn ($query) => $query->where('is_published', true))
                    ->orderBy('sort_order'),
                'chapters.videos' => fn ($query) => $query
                    ->when(! $this->isContentManager, fn ($query) => $query->where('is_published', true))
                    ->orderBy('sort_order'),
                'chapters.documents' => fn ($query) => $query
                    ->when(! $this->isContentManager, fn ($query) => $query->where('is_published', true))
                    ->orderBy('sort_order'),
                'chapters.resources' => fn ($query) => $query
                    ->when(! $this->isContentManager, fn ($query) => $query->where('is_published', true))
                    ->orderBy('sort_order'),
                'videos' => fn ($query) => $query
                    ->when(! $this->isContentManager, fn ($query) => $query->where('is_published', true))
                    ->orderBy('sort_order'),
                'documents' => fn ($query) => $query
                    ->when(! $this->isContentManager, fn ($query) => $query->where('is_published', true))
                    ->orderBy('sort_order'),
                'assignments' => fn ($query) => $query
                    ->when(! $this->isContentManager, fn ($query) => $query->where('is_published', true))
                    ->orderBy('due_at'),
                'resources' => fn ($query) => $query
                    ->when(! $this->isContentManager, fn ($query) => $query->where('is_published', true))
                    ->orderBy('sort_order'),
                'quizzes' => fn ($query) => $query
                    ->when(! $this->isContentManager, fn ($query) => $query->where('is_published', true))
                    ->orderBy('available_from'),
                'quizzes.lesson',
            ])
            ->when(! $this->isContentManager, fn (Builder $query): Builder => $query->publishedForStudents())
            ->orderBy('module_number')
            ->orderBy('position')
            ->get();

        $lessonIds = $lessons->pluck('content_lesson_id');
        $assignments = $lessons
            ->flatMap->assignments
            ->sortBy('due_at')
            ->values();
        $quizzes = $lessons
            ->flatMap->quizzes
            ->sortBy('available_from')
            ->values();
        $assignmentIds = $assignments->pluck('content_assignment_id');
        $quizIds = $quizzes->pluck('quiz_id');
        $exams = Exam::query()
            ->where('course_id', $this->courseRecord->course_id)
            ->orderBy('exam_date')
            ->get();
        $examIds = $exams->pluck('exam_id');
        $hasAssessableItems = $examIds->isNotEmpty() || $quizIds->isNotEmpty() || $assignmentIds->isNotEmpty();
        $teacher = $this->courseRecord->courseAssignments->first()?->teacher;

        return [
            'course' => $this->courseRecord,
            'student' => $this->student,
            'lessons' => $lessons,
            'progressPercent' => $this->progressPercent,
            'completedLessonIds' => $this->completedLessonIds,
            'lastViewedLessonId' => $this->lastViewedLessonId,
            'isContentManager' => $this->isContentManager,
            'publishedLessonsCount' => $lessons->where('is_published', true)->count(),
            'draftLessonsCount' => $lessons->where('is_published', false)->count(),
            'chaptersCount' => $lessons->sum(fn (ContentLesson $lesson): int => $lesson->chapters->count()),
            'teacherName' => $teacher ? trim($teacher->first_name.' '.$teacher->last_name) : 'Teacher not assigned',
            'assignments' => $assignments,
            'quizzes' => $quizzes,
            'exams' => $exams,
            'grades' => $this->student && $hasAssessableItems
                ? AssessmentGrade::query()
                    ->where('student_id', $this->student->student_id)
                    ->where(function (Builder $query) use ($examIds, $quizIds, $assignmentIds): void {
                        $query
                            ->when($examIds->isNotEmpty(), fn (Builder $query): Builder => $query->whereIn('exam_id', $examIds))
                            ->when($quizIds->isNotEmpty(), fn (Builder $query): Builder => $query->orWhereIn('quiz_id', $quizIds))
                            ->when($assignmentIds->isNotEmpty(), fn (Builder $query): Builder => $query->orWhereIn('content_assignment_id', $assignmentIds));
                    })
                    ->with(['exam', 'quiz.lesson', 'assignment.lesson'])
                    ->latest('graded_at')
                    ->get()
                : collect(),
            'quizResults' => $this->student
                ? AssessmentResult::query()
                    ->where('student_id', $this->student->student_id)
                    ->whereIn('quiz_id', $quizIds)
                    ->get()
                    ->keyBy('quiz_id')
                : collect(),
            'assignmentSubmissions' => $this->student && class_exists(AssignmentSubmission::class)
                ? AssignmentSubmission::query()
                    ->where('student_id', $this->student->student_id)
                    ->whereIn('content_assignment_id', $assignmentIds)
                    ->latest('submitted_at')
                    ->get()
                    ->keyBy('content_assignment_id')
                : collect(),
            'quizQuestionsByLesson' => AssessmentQuestion::query()
                ->whereIn('content_lesson_id', $lessonIds)
                ->where('is_active', true)
                ->with(['options' => fn ($query) => $query->orderBy('sort_order')])
                ->get()
                ->groupBy('content_lesson_id'),
        ];
    }

    /**
     * @param  array<int, int|string>  $completedLessonIds
     */
    public function saveLearningProgress(array $completedLessonIds, ?int $lastLessonId = null): void
    {
        abort_unless($this->student && ! $this->isContentManager, 403);

        $validLessonIds = ContentLesson::query()
            ->where('course_id', $this->courseRecord->course_id)
            ->publishedForStudents()
            ->pluck('content_lesson_id')
            ->map(fn ($id): int => (int) $id)
            ->all();

        $completedLessonIds = collect($completedLessonIds)
            ->map(fn ($id): int => (int) $id)
            ->intersect($validLessonIds)
            ->values()
            ->all();

        $totalLessons = max(count($validLessonIds), 1);
        $progressPercent = round((count($completedLessonIds) / $totalLessons) * 100, 2);

        if ($lastLessonId && ! in_array($lastLessonId, $validLessonIds, true)) {
            $lastLessonId = null;
        }

        StudentProgress::query()->updateOrCreate(
            [
                'student_id' => $this->student->student_id,
                'course_id' => $this->courseRecord->course_id,
            ],
            [
                'progress_date' => now()->toDateString(),
                'progress_percent' => $progressPercent,
                'status' => $progressPercent >= 100 ? 'completed' : 'in_progress',
                'note' => json_encode([
                    'completed_lesson_ids' => $completedLessonIds,
                    'last_lesson_id' => $lastLessonId,
                ]),
            ],
        );

        $this->completedLessonIds = $completedLessonIds;
        $this->lastViewedLessonId = $lastLessonId;
        $this->progressPercent = $progressPercent;
    }

    /**
     * @param  array<int|string, int|string|null>  $answers
     */
    public function submitQuiz(int $quizId, array $answers = []): void
    {
        abort_unless($this->student && ! $this->isContentManager, 403);

        $quiz = Quiz::query()
            ->whereKey($quizId)
            ->where('is_published', true)
            ->whereHas('lesson', fn (Builder $query): Builder => $query
                ->where('course_id', $this->courseRecord->course_id)
                ->publishedForStudents())
            ->firstOrFail();

        abort_unless($this->quizIsOpen($quiz), 403);

        $questions = AssessmentQuestion::query()
            ->where('content_lesson_id', $quiz->content_lesson_id)
            ->where('is_active', true)
            ->with(['options' => fn ($query) => $query->orderBy('sort_order')])
            ->get();

        $score = 0.0;
        $maxScore = (float) max($questions->sum(fn (AssessmentQuestion $question): float => (float) $question->points), 1);
        $normalizedAnswers = collect($answers)
            ->mapWithKeys(fn ($answer, $questionId): array => [(int) $questionId => is_scalar($answer) ? (string) $answer : null])
            ->all();

        foreach ($questions as $question) {
            $answer = trim((string) ($normalizedAnswers[(int) $question->assessment_question_id] ?? ''));

            if ($question->options->isNotEmpty()) {
                $correctOption = $question->options->firstWhere('is_correct', true);

                if ($correctOption && (int) $answer === (int) $correctOption->question_option_id) {
                    $score += (float) $question->points;
                }

                continue;
            }

            if ($question->correct_answer !== null && strcasecmp($answer, trim((string) $question->correct_answer)) === 0) {
                $score += (float) $question->points;
            }
        }

        $percentage = round(($score / $maxScore) * 100, 2);
        $passed = $percentage >= (float) $quiz->passing_score;

        AssessmentResult::query()->create([
            'student_id' => $this->student->student_id,
            'quiz_id' => $quiz->quiz_id,
            'assessment_type' => 'quiz',
            'total_score' => $percentage,
            'passed' => $passed,
            'published_at' => now(),
            'remarks' => json_encode(['answers' => $normalizedAnswers]),
        ]);

        AssessmentGrade::query()->create([
            'student_id' => $this->student->student_id,
            'quiz_id' => $quiz->quiz_id,
            'score' => $score,
            'max_score' => $maxScore,
            'grade' => $passed ? 'Pass' : 'Needs Review',
            'graded_at' => now(),
            'remarks' => 'Auto graded from student LMS quiz attempt.',
        ]);

        $this->quizAnswers = [];
    }

    public function submitAssignment(int $assignmentId, ?string $response = null, ?string $attachmentUrl = null): void
    {
        abort_unless($this->student && ! $this->isContentManager, 403);

        $assignment = ContentAssignment::query()
            ->whereKey($assignmentId)
            ->where('is_published', true)
            ->whereHas('lesson', fn (Builder $query): Builder => $query
                ->where('course_id', $this->courseRecord->course_id)
                ->publishedForStudents())
            ->firstOrFail();

        abort_unless($assignment->allow_late_submission || ! $assignment->due_at || $assignment->due_at->endOfDay()->gte(now()), 403);

        AssignmentSubmission::query()->create([
            'content_assignment_id' => $assignment->content_assignment_id,
            'student_id' => $this->student->student_id,
            'response' => trim((string) $response) ?: null,
            'attachment_url' => trim((string) $attachmentUrl) ?: null,
            'submitted_at' => now(),
            'status' => 'submitted',
        ]);

        $this->assignmentResponse = null;
        $this->assignmentAttachmentUrl = null;
    }

    private function progressRecord(): ?StudentProgress
    {
        if (! $this->student) {
            return null;
        }

        return StudentProgress::query()
            ->where('student_id', $this->student->student_id)
            ->where('course_id', $this->courseRecord->course_id)
            ->first();
    }

    private function userCanManageContent(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin', 'teacher']);
    }

    private function quizIsOpen(Quiz $quiz): bool
    {
        return (! $quiz->available_from || $quiz->available_from <= now())
            && (! $quiz->available_until || $quiz->available_until >= now());
    }

    private function courseIdFromRouteParameter(mixed $course): int
    {
        if ($course instanceof Course) {
            return (int) $course->getKey();
        }

        if (is_array($course)) {
            return (int) ($course['course_id'] ?? $course['id'] ?? 0);
        }

        if (is_string($course) && str_starts_with(trim($course), '{')) {
            $decoded = json_decode($course, true);

            if (is_array($decoded)) {
                return (int) ($decoded['course_id'] ?? $decoded['id'] ?? 0);
            }
        }

        return (int) $course;
    }

    /**
     * @return array<string, mixed>
     */
    private function decodeProgressNote(?string $note): array
    {
        if (! $note) {
            return [];
        }

        $decoded = json_decode($note, true);

        return is_array($decoded) ? $decoded : [];
    }
}
