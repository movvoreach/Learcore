<?php

namespace App\Services;

use App\Models\ContentLesson;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\StudentProgress;
use Illuminate\Support\Arr;

class StudentCourseProgressService
{
    public function markLessonViewed(Student $student, Course $course, ContentLesson $lesson): StudentProgress
    {
        return $this->sync($student, $course, [$lesson->content_lesson_id], $lesson->content_lesson_id);
    }

    /**
     * @param  array<int, int|string>  $completedLessonIds
     */
    public function sync(Student $student, Course $course, array $completedLessonIds = [], ?int $lastLessonId = null): StudentProgress
    {
        $validLessonIds = ContentLesson::query()
            ->where('course_id', $course->course_id)
            ->publishedForStudents()
            ->pluck('content_lesson_id')
            ->map(fn ($id): int => (int) $id)
            ->all();

        $existingProgress = StudentProgress::query()
            ->where('student_id', $student->student_id)
            ->where('course_id', $course->course_id)
            ->first();

        $existingNote = $this->decodeNote($existingProgress?->note);
        $completedLessonIds = collect(Arr::wrap($existingNote['completed_lesson_ids'] ?? []))
            ->merge($completedLessonIds)
            ->map(fn ($id): int => (int) $id)
            ->intersect($validLessonIds)
            ->unique()
            ->values()
            ->all();

        if ($lastLessonId && ! in_array($lastLessonId, $validLessonIds, true)) {
            $lastLessonId = null;
        }

        $totalLessons = max(count($validLessonIds), 1);
        $progressPercent = round((count($completedLessonIds) / $totalLessons) * 100, 2);
        $enrollment = $this->enrollment($student, $course);

        return StudentProgress::query()->updateOrCreate(
            [
                'student_id' => $student->student_id,
                'course_id' => $course->course_id,
            ],
            [
                'class_room_id' => $enrollment?->class_room_id,
                'progress_date' => now()->toDateString(),
                'progress_percent' => $progressPercent,
                'status' => $progressPercent >= 100 ? 'completed' : 'in_progress',
                'note' => json_encode([
                    'completed_lesson_ids' => $completedLessonIds,
                    'last_lesson_id' => $lastLessonId ?? ($existingNote['last_lesson_id'] ?? null),
                    'total_lessons' => count($validLessonIds),
                ]),
            ],
        );
    }

    public function syncEnrollment(Enrollment $enrollment): ?StudentProgress
    {
        if (! $enrollment->student || ! $enrollment->course) {
            return null;
        }

        return $this->sync($enrollment->student, $enrollment->course);
    }

    /**
     * @return array<string, mixed>
     */
    public function decodeNote(?string $note): array
    {
        if (! $note) {
            return [];
        }

        $decoded = json_decode($note, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function enrollment(Student $student, Course $course): ?Enrollment
    {
        return Enrollment::query()
            ->where('student_id', $student->student_id)
            ->where('course_id', $course->course_id)
            ->latest('enrollment_date')
            ->first();
    }
}
