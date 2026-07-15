<?php

namespace App\Filament\Admin\Resources\StudentProgresses\Pages;

use App\Filament\Admin\Resources\StudentProgresses\StudentProgressResource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Services\StudentCourseProgressService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListStudentProgresses extends ListRecords
{
    protected static string $resource = StudentProgressResource::class;

    protected string $view = 'filament.admin.resources.student-progresses.pages.list-student-progresses';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $courses = $this->getCourses();
        $courseQuery = $this->courseQuery();

        return [
            'courses' => $courses,
            'totalCourses' => $courses->total(),
            'totalStudents' => (clone $courseQuery)->withCount('enrollments')->get()->sum('enrollments_count'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sync_course_progress')
                ->label('Sync Course Progress')
                ->icon(Heroicon::OutlinedArrowPath)
                ->color('info')
                ->action(function (): void {
                    $service = app(StudentCourseProgressService::class);
                    $user = auth()->user();
                    $query = Enrollment::query()->with(['student', 'course']);

                    if ($user?->hasRole('teacher') && ! $user->hasAnyRole(['super_admin', 'admin'])) {
                        $query = $user->teacher
                            ? $query->whereHas('course.courseAssignments', fn (Builder $query): Builder => $query
                                ->where('teacher_id', $user->teacher->teacher_id))
                            : $query->whereRaw('1 = 0');
                    }

                    $synced = 0;

                    $query->chunkById(100, function ($enrollments) use ($service, &$synced): void {
                        foreach ($enrollments as $enrollment) {
                            if ($service->syncEnrollment($enrollment)) {
                                $synced++;
                            }
                        }
                    }, 'enrollment_id');

                    Notification::make()
                        ->title('Course progress synced')
                        ->body($synced.' student course progress records updated.')
                        ->success()
                        ->send();
                }),
        ];
    }

    private function getCourses(): LengthAwarePaginator
    {
        return $this->courseQuery()
            ->orderBy('course_name')
            ->paginate(10, ['*'], 'page')
            ->withPath(StudentProgressResource::getUrl('index'));
    }

    private function courseQuery(): Builder
    {
        $user = auth()->user();

        return Course::query()
            ->with(['department', 'academicYear', 'semester', 'courseAssignments.teacher'])
            ->withCount([
                'enrollments',
                'contentLessons as published_lessons_count' => fn (Builder $query): Builder => $query->publishedForStudents(),
            ])
            ->withAvg('progresses as average_progress_percent', 'progress_percent')
            ->when(
                $user?->hasRole('teacher') && ! $user->hasAnyRole(['super_admin', 'admin']),
                fn (Builder $query): Builder => $user->teacher
                    ? $query->whereHas('courseAssignments', fn (Builder $query): Builder => $query
                        ->where('teacher_id', $user->teacher->teacher_id))
                    : $query->whereRaw('1 = 0')
            );
    }
}
