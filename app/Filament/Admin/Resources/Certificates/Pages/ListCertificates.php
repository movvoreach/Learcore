<?php

namespace App\Filament\Admin\Resources\Certificates\Pages;

use App\Filament\Admin\Resources\Certificates\CertificateResource;
use App\Models\CourseCompletionRequest;
use App\Services\CourseCompletionService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Collection;

class ListCertificates extends ListRecords
{
    protected static string $resource = CertificateResource::class;

    protected string $view = 'filament.admin.resources.certificates.pages.list-certificates';

    public ?int $selectedRequestId = null;

    public ?int $rejectingRequestId = null;

    public string $rejectionReason = '';

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount(): void
    {
        parent::mount();

        if (! auth()->user()?->isStudent()) {
            $this->selectedRequestId = $this->completionRequests()->first()?->id;
        }
    }

    public function completionRequests(): Collection
    {
        $query = CourseCompletionRequest::query()
            ->with(['course.contentLessons.quizzes', 'course.contentLessons.assignments', 'teacher.user', 'approvedBy', 'rejectedBy'])
            ->withCount('certificates')
            ->latest('completed_at');

        $user = auth()->user();

        if ($user?->isTeacher() && $user->teacher) {
            $query->where('teacher_id', $user->teacher->teacher_id);
        }

        return $query->get();
    }

    public function selectedRequest(): ?CourseCompletionRequest
    {
        if (! $this->selectedRequestId) {
            return null;
        }

        return CourseCompletionRequest::query()
            ->with(['course.contentLessons.quizzes', 'course.contentLessons.assignments', 'teacher.user', 'approvedBy', 'rejectedBy'])
            ->find($this->selectedRequestId);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function selectedReport(): ?array
    {
        $request = $this->selectedRequest();

        return $request ? app(CourseCompletionService::class)->report($request->course) : null;
    }

    public function viewRequest(int $requestId): void
    {
        $this->selectedRequestId = $requestId;
    }

    public function approveRequest(int $requestId): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['super_admin', 'admin']), 403);

        try {
            $result = app(CourseCompletionService::class)->approve(
                CourseCompletionRequest::query()->with(['course', 'teacher.user'])->findOrFail($requestId),
                auth()->user(),
            );

            Notification::make()
                ->success()
                ->title('Course completion approved')
                ->body($result['generated'].' certificates generated.')
                ->send();
        } catch (\Throwable $exception) {
            Notification::make()
                ->danger()
                ->title('Approval failed')
                ->body($exception->getMessage())
                ->send();
        }
    }

    public function openRejectRequest(int $requestId): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['super_admin', 'admin']), 403);

        $this->rejectingRequestId = $requestId;
        $this->rejectionReason = '';
    }

    public function rejectRequest(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['super_admin', 'admin']), 403);

        $this->validate([
            'rejectionReason' => ['required', 'string', 'min:3', 'max:1000'],
            'rejectingRequestId' => ['required', 'integer', 'exists:course_completion_requests,id'],
        ]);

        try {
            app(CourseCompletionService::class)->reject(
                CourseCompletionRequest::query()->with(['course', 'teacher.user'])->findOrFail($this->rejectingRequestId),
                auth()->user(),
                $this->rejectionReason,
            );

            $this->rejectingRequestId = null;
            $this->rejectionReason = '';

            Notification::make()
                ->success()
                ->title('Course completion rejected')
                ->send();
        } catch (\Throwable $exception) {
            Notification::make()
                ->danger()
                ->title('Reject failed')
                ->body($exception->getMessage())
                ->send();
        }
    }
}
