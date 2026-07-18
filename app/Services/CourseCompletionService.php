<?php

namespace App\Services;

use App\Models\AssessmentResult;
use App\Models\AssignmentSubmission;
use App\Models\Certificate;
use App\Models\ContentLesson;
use App\Models\Course;
use App\Models\CourseCompletionRequest;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Models\Teacher;
use App\Models\User;
use App\Notifications\CourseCompletionWorkflowNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use RuntimeException;

class CourseCompletionService
{
    /**
     * @return array<string, mixed>
     */
    public function report(Course $course): array
    {
        $course->loadMissing([
            'contentLessons' => fn ($query) => $query
                ->where('is_published', true)
                ->orderBy('module_number')
                ->orderBy('position')
                ->orderBy('content_lesson_id'),
            'contentLessons.quizzes' => fn ($query) => $query->where('is_published', true),
            'contentLessons.assignments' => fn ($query) => $query->where('is_published', true),
            'enrollments.student',
            'progresses',
        ]);

        $requiredLessons = $course->contentLessons
            ->filter(fn (ContentLesson $lesson): bool => (bool) $lesson->completion_required);

        if ($requiredLessons->isEmpty()) {
            $requiredLessons = $course->contentLessons;
        }

        $requiredLessonIds = $requiredLessons
            ->pluck('content_lesson_id')
            ->map(fn ($id): int => (int) $id)
            ->values();

        $requiredQuizIds = $requiredLessons
            ->flatMap(fn (ContentLesson $lesson): Collection => $lesson->quizzes->pluck('quiz_id'))
            ->map(fn ($id): int => (int) $id)
            ->values();

        $requiredAssignmentIds = $requiredLessons
            ->flatMap(fn (ContentLesson $lesson): Collection => $lesson->assignments->pluck('content_assignment_id'))
            ->map(fn ($id): int => (int) $id)
            ->values();

        $enrollments = $course->enrollments->filter(fn (Enrollment $enrollment): bool => (bool) $enrollment->student);
        $progresses = $course->progresses->keyBy('student_id');

        $quizResults = AssessmentResult::query()
            ->whereIn('student_id', $enrollments->pluck('student_id'))
            ->whereIn('quiz_id', $requiredQuizIds)
            ->get()
            ->groupBy('student_id');

        $assignmentSubmissions = AssignmentSubmission::query()
            ->whereIn('student_id', $enrollments->pluck('student_id'))
            ->whereIn('content_assignment_id', $requiredAssignmentIds)
            ->get()
            ->groupBy('student_id');

        $students = $enrollments->map(function (Enrollment $enrollment) use ($progresses, $requiredLessonIds, $requiredQuizIds, $requiredAssignmentIds, $quizResults, $assignmentSubmissions): array {
            $student = $enrollment->student;
            $progress = $progresses->get($student->student_id);
            $note = app(StudentCourseProgressService::class)->decodeNote($progress?->note);
            $completedLessonIds = collect($note['completed_lesson_ids'] ?? [])
                ->map(fn ($id): int => (int) $id);

            $lessonProgress = $requiredLessonIds->count() > 0
                ? round(($completedLessonIds->intersect($requiredLessonIds)->count() / $requiredLessonIds->count()) * 100, 2)
                : 0.0;

            $studentQuizResults = $quizResults->get($student->student_id, collect());
            $completedQuizzes = $requiredQuizIds->filter(function (int $quizId) use ($studentQuizResults): bool {
                return $studentQuizResults->contains(fn (AssessmentResult $result): bool => (int) $result->quiz_id === $quizId && ($result->passed || (float) $result->total_score > 0));
            })->count();

            $studentAssignments = $assignmentSubmissions->get($student->student_id, collect());
            $completedAssignments = $requiredAssignmentIds->filter(function (int $assignmentId) use ($studentAssignments): bool {
                return $studentAssignments->contains(fn (AssignmentSubmission $submission): bool => (int) $submission->content_assignment_id === $assignmentId && in_array($submission->status, ['submitted', 'graded', 'approved'], true));
            })->count();

            $quizComplete = $requiredQuizIds->count() === 0 || $completedQuizzes === $requiredQuizIds->count();
            $assignmentComplete = $requiredAssignmentIds->count() === 0 || $completedAssignments === $requiredAssignmentIds->count();
            $lessonComplete = $requiredLessonIds->count() > 0 && $lessonProgress >= 100;
            $eligible = $lessonComplete && $quizComplete && $assignmentComplete;

            return [
                'student' => $student,
                'enrollment' => $enrollment,
                'progress' => $progress,
                'lesson_progress' => $lessonProgress,
                'quiz_result' => $requiredQuizIds->count() === 0 ? 'N/A' : "{$completedQuizzes}/{$requiredQuizIds->count()}",
                'assignment_result' => $requiredAssignmentIds->count() === 0 ? 'N/A' : "{$completedAssignments}/{$requiredAssignmentIds->count()}",
                'final_score' => $progress?->final_score ?? $progress?->score,
                'eligible' => $eligible,
            ];
        })->values();

        $completedStudents = $students->where('eligible', true)->count();
        $totalStudents = $students->count();

        return [
            'course' => $course,
            'total_lessons' => $course->contentLessons->count(),
            'required_lessons' => $requiredLessonIds->count(),
            'total_modules' => $course->contentLessons->pluck('module_number')->filter()->unique()->count(),
            'duration_minutes' => (int) $course->contentLessons->sum('duration_minutes'),
            'required_quizzes' => $requiredQuizIds->count(),
            'required_assignments' => $requiredAssignmentIds->count(),
            'total_students' => $totalStudents,
            'completed_students' => $completedStudents,
            'completion_percentage' => $totalStudents > 0 ? round(($completedStudents / $totalStudents) * 100, 2) : 0,
            'students' => $students,
            'can_complete' => $requiredLessonIds->count() > 0 && $totalStudents > 0 && $completedStudents === $totalStudents,
        ];
    }

    public function requestCompletion(Course $course, User $completedBy): CourseCompletionRequest
    {
        $teacher = $this->teacherForCourse($course, $completedBy);
        $report = $this->report($course);

        if (! $report['can_complete']) {
            throw new RuntimeException('Course is not ready for certificate approval. Required lessons, student progress, quizzes, or assignments are still incomplete.');
        }

        return DB::transaction(function () use ($course, $teacher, $completedBy, $report): CourseCompletionRequest {
            $request = CourseCompletionRequest::query()->updateOrCreate(
                [
                    'course_id' => $course->course_id,
                    'teacher_id' => $teacher->teacher_id,
                    'status' => CourseCompletionRequest::STATUS_PENDING,
                ],
                [
                    'completed_by' => $completedBy->id,
                    'completed_at' => now(),
                    'summary' => $this->summaryPayload($report),
                ],
            );

            $admins = User::role(['super_admin', 'admin'])->get();

            Notification::send($admins, new CourseCompletionWorkflowNotification(
                'Course completion request',
                "Teacher has completed {$course->course_name} and requested certificate approval.",
                [
                    'type' => 'course_completion_requested',
                    'course_id' => $course->course_id,
                    'course_completion_request_id' => $request->id,
                ],
            ));

            return $request;
        });
    }

    /**
     * @return array{generated:int, skipped:int}
     */
    public function approve(CourseCompletionRequest $request, User $admin): array
    {
        if (! $request->isPending()) {
            throw new RuntimeException('Only pending completion requests can be approved.');
        }

        return DB::transaction(function () use ($request, $admin): array {
            $report = $this->report($request->course);
            $generated = 0;
            $skipped = 0;

            foreach ($report['students'] as $studentRow) {
                if (! $studentRow['eligible']) {
                    $skipped++;
                    continue;
                }

                /** @var Student $student */
                $student = $studentRow['student'];

                Certificate::query()->updateOrCreate(
                    [
                        'student_id' => $student->student_id,
                        'course_id' => $request->course_id,
                    ],
                    [
                        'course_completion_request_id' => $request->id,
                        'certificate_no' => $this->certificateNumber($request, $student),
                        'issued_date' => now()->toDateString(),
                        'issued_by' => $admin->id,
                        'issued_at' => now(),
                        'status' => 'issued',
                        'note' => 'Generated from approved course completion request #'.$request->id,
                    ],
                );

                $generated++;

                if ($student->user) {
                    $student->user->notify(new CourseCompletionWorkflowNotification(
                        'Certificate generated',
                        "Your certificate for {$request->course->course_name} has been generated.",
                        [
                            'type' => 'certificate_generated',
                            'course_id' => $request->course_id,
                            'course_completion_request_id' => $request->id,
                        ],
                    ));
                }
            }

            $request->update([
                'status' => CourseCompletionRequest::STATUS_APPROVED,
                'approved_by' => $admin->id,
                'approved_at' => now(),
                'summary' => $this->summaryPayload($report),
            ]);

            $request->teacher->user?->notify(new CourseCompletionWorkflowNotification(
                'Course completion approved',
                "Your course {$request->course->course_name} has been approved. {$generated} student certificates have been generated.",
                [
                    'type' => 'course_completion_approved',
                    'course_id' => $request->course_id,
                    'course_completion_request_id' => $request->id,
                    'generated_certificates' => $generated,
                ],
            ));

            return ['generated' => $generated, 'skipped' => $skipped];
        });
    }

    public function reject(CourseCompletionRequest $request, User $admin, string $reason): void
    {
        if (! $request->isPending()) {
            throw new RuntimeException('Only pending completion requests can be rejected.');
        }

        $request->update([
            'status' => CourseCompletionRequest::STATUS_REJECTED,
            'rejected_by' => $admin->id,
            'rejected_at' => now(),
            'rejection_reason' => $reason,
        ]);

        $request->teacher->user?->notify(new CourseCompletionWorkflowNotification(
            'Course completion rejected',
            "Your course completion request was rejected. Reason: {$reason}",
            [
                'type' => 'course_completion_rejected',
                'course_id' => $request->course_id,
                'course_completion_request_id' => $request->id,
                'reason' => $reason,
            ],
        ));
    }

    private function teacherForCourse(Course $course, User $user): Teacher
    {
        $course->loadMissing('courseAssignments.teacher');

        if ($user->isTeacher() && $user->teacher) {
            $assigned = $course->courseAssignments
                ->contains(fn ($assignment): bool => (int) $assignment->teacher_id === (int) $user->teacher->teacher_id);

            if (! $assigned) {
                throw new RuntimeException('Only the assigned teacher can submit this course for certificate approval.');
            }

            return $user->teacher;
        }

        $teacher = $course->courseAssignments->first()?->teacher;

        if (! $teacher) {
            throw new RuntimeException('This course does not have an assigned teacher.');
        }

        return $teacher;
    }

    /**
     * @param  array<string, mixed>  $report
     * @return array<string, mixed>
     */
    private function summaryPayload(array $report): array
    {
        return collect($report)
            ->only(['total_lessons', 'required_lessons', 'total_modules', 'duration_minutes', 'required_quizzes', 'required_assignments', 'total_students', 'completed_students', 'completion_percentage'])
            ->all();
    }

    private function certificateNumber(CourseCompletionRequest $request, Student $student): string
    {
        return 'CERT-'.$request->course_id.'-'.$student->student_id.'-'.now()->format('Ymd').'-'.Str::upper(Str::random(4));
    }
}
