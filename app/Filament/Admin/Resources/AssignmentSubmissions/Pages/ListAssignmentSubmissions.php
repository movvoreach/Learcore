<?php

namespace App\Filament\Admin\Resources\AssignmentSubmissions\Pages;

use App\Filament\Admin\Resources\AssignmentSubmissions\AssignmentSubmissionResource;
use App\Models\AssignmentSubmission;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ListAssignmentSubmissions extends ListRecords
{
    protected static string $resource = AssignmentSubmissionResource::class;

    protected string $view = 'filament.admin.resources.assignment-submissions.pages.list-assignment-submissions';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $baseQuery = $this->submissionsQuery();
        $submissions = (clone $baseQuery)
            ->latest('submitted_at')
            ->paginate(10, ['*'], 'page')
            ->withPath(AssignmentSubmissionResource::getUrl('index'));

        return [
            'submissions' => $submissions,
            'totalSubmissions' => (clone $baseQuery)->count(),
            'pendingSubmissions' => (clone $baseQuery)->whereIn('status', ['submitted', 'reviewed'])->count(),
            'gradedSubmissions' => (clone $baseQuery)->where('status', 'graded')->count(),
        ];
    }

    private function submissionsQuery(): Builder
    {
        $user = auth()->user();

        return AssignmentSubmission::query()
            ->with(['assignment.lesson.course', 'student.department', 'student.academicYear', 'student.semester'])
            ->when(
                $user?->hasRole('teacher') && ! $user->hasAnyRole(['super_admin', 'admin']),
                fn (Builder $query): Builder => $user->teacher
                    ? $query->whereHas('assignment.lesson.course.courseAssignments', fn (Builder $query): Builder => $query
                        ->where('teacher_id', $user->teacher->teacher_id))
                    : $query->whereRaw('1 = 0')
            );
    }
}
