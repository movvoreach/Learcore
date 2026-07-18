<?php

namespace App\Filament\Admin\Resources\Enrollments\Pages;

use App\Filament\Admin\Resources\Enrollments\EnrollmentResource;
use App\Models\StudentProgress;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ViewEnrollment extends ViewRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected string $view = 'admin.enrollments.show';

    protected static ?string $title = 'Enrollment Detail';

    protected static ?string $breadcrumb = 'Detail';

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getDetailData(): array
    {
        $this->record->load([
            'student.user',
            'student.department',
            'course.category',
            'course.instructor',
            'course.contentLessons' => fn ($query) => $query
                ->orderBy('module_number')
                ->orderBy('position')
                ->orderBy('content_lesson_id'),
        ]);

        $course = $this->record->course;
        $lessons = $course?->contentLessons ?? collect();
        $totalLessons = $lessons->count();

        $progress = StudentProgress::query()
            ->where('student_id', $this->record->student_id)
            ->where('course_id', $this->record->course_id)
            ->when($this->record->class_room_id, fn ($query) => $query->where('class_room_id', $this->record->class_room_id))
            ->latest('progress_date')
            ->latest('progress_id')
            ->first();

        $progressPercent = (int) round((float) ($progress?->progress_percent ?? 0));

        if ($this->record->status === 'completed') {
            $progressPercent = 100;
        }

        $progressPercent = max(0, min(100, $progressPercent));
        $completedLessons = $totalLessons > 0 ? (int) floor($totalLessons * $progressPercent / 100) : 0;

        if ($progressPercent >= 100) {
            $completedLessons = $totalLessons;
        }

        return [
            'modules' => $this->modulesFromLessons($lessons, $completedLessons),
            'totalLessons' => $totalLessons,
            'completedLessons' => $completedLessons,
            'remainingLessons' => max(0, $totalLessons - $completedLessons),
            'progressPercent' => $progressPercent,
            'totalDuration' => (int) $lessons->sum('duration_minutes'),
            'studentPhotoUrl' => $this->avatarUrl($this->record->student?->user?->avatar),
            'courseImageUrl' => asset('backend/dist/img/prod-1.jpg'),
        ];
    }

    private function modulesFromLessons(Collection $lessons, int $completedLessons): Collection
    {
        $lessonNumber = 0;

        return $lessons
            ->groupBy(fn ($lesson) => ($lesson->module_number ?: 1).'|'.($lesson->module_title ?: 'Course Module'))
            ->map(function (Collection $moduleLessons, string $moduleKey) use (&$lessonNumber, $completedLessons): array {
                [$moduleNumber, $moduleTitle] = array_pad(explode('|', $moduleKey, 2), 2, 'Course Module');

                return [
                    'number' => (int) $moduleNumber,
                    'title' => $moduleTitle ?: 'Course Module',
                    'duration' => (int) $moduleLessons->sum('duration_minutes'),
                    'lessons' => $moduleLessons->map(function ($lesson) use (&$lessonNumber, $completedLessons): array {
                        $lessonNumber++;

                        return [
                            'model' => $lesson,
                            'number' => $lessonNumber,
                            'type' => $this->lessonTypeLabel($lesson->content_type),
                            'duration' => (int) ($lesson->duration_minutes ?? 0),
                            'status' => $this->lessonStatus($lesson, $lessonNumber, $completedLessons),
                        ];
                    }),
                ];
            })
            ->values();
    }

    private function lessonStatus($lesson, int $lessonNumber, int $completedLessons): array
    {
        if (! $lesson->is_published || $lesson->visibility === 'hidden') {
            return ['label' => 'Locked', 'class' => 'locked', 'icon' => 'fa-lock'];
        }

        if ($lesson->visibility === 'scheduled' && $lesson->available_from && $lesson->available_from->isFuture()) {
            return ['label' => 'Locked', 'class' => 'locked', 'icon' => 'fa-lock'];
        }

        if ($lessonNumber <= $completedLessons) {
            return ['label' => 'Completed', 'class' => 'completed', 'icon' => 'fa-check-circle'];
        }

        if ($lessonNumber === $completedLessons + 1) {
            return ['label' => 'In Progress', 'class' => 'progressing', 'icon' => 'fa-play-circle'];
        }

        return ['label' => 'Not Started', 'class' => 'not-started', 'icon' => 'fa-circle'];
    }

    private function lessonTypeLabel(?string $type): string
    {
        return match (Str::lower((string) $type)) {
            'video' => 'Video',
            'document', 'pdf', 'file' => 'Document',
            'quiz' => 'Quiz',
            'assignment' => 'Assignment',
            default => 'Lesson',
        };
    }

    private function avatarUrl(?string $avatar): string
    {
        if (blank($avatar)) {
            return asset('backend/dist/img/default-150x150.png');
        }

        if (Str::startsWith($avatar, ['http://', 'https://', '/'])) {
            return $avatar;
        }

        return asset('storage/'.$avatar);
    }
}
