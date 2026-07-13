<?php

namespace App\Filament\Admin\Resources\Courses\Pages;

use App\Filament\Admin\Resources\Courses\CourseResource;
use App\Models\Course;
use App\Models\CourseAssignment;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    protected string $view = 'filament.admin.resources.courses.pages.list-courses';

    public bool $showAssignTeacherModal = false;
    public ?int $assignCourseId = null;
    public ?string $assignCourseName = null;
    public ?int $assignDepartmentId = null;
    public ?int $assignTeacherId = null;

    public function openAssignTeacherModal(int $courseId): void
    {
        $course = Course::query()
            ->with(['courseAssignments', 'academicYear'])
            ->findOrFail($courseId);

        $assignment = $course->courseAssignments->first();

        $this->assignCourseId = $course->course_id;
        $this->assignCourseName = $course->course_name;
        $this->assignDepartmentId = $assignment?->teacher?->department_id ?? $course->department_id;
        $this->assignTeacherId = $assignment?->teacher_id;
        $this->showAssignTeacherModal = true;
        $this->resetValidation();
        $this->dispatch('open-assign-teacher-modal');
    }

    public function closeAssignTeacherModal(): void
    {
        $this->showAssignTeacherModal = false;
        $this->resetValidation();
    }

    public function saveTeacherAssignment(): void
    {
        $data = $this->validate([
            'assignCourseId' => ['required', 'integer', 'exists:courses,course_id'],
            'assignDepartmentId' => ['nullable', 'integer', 'exists:departments,department_id'],
            'assignTeacherId' => ['required', 'integer', 'exists:teachers,teacher_id'],
        ], [], [
            'assignDepartmentId' => 'Department',
            'assignTeacherId' => 'Teacher',
        ]);

        $course = Course::query()->findOrFail($data['assignCourseId']);

        if ($data['assignDepartmentId']) {
            $teacherMatchesDepartment = \App\Models\Teacher::query()
                ->whereKey($data['assignTeacherId'])
                ->where('department_id', $data['assignDepartmentId'])
                ->exists();

            if (! $teacherMatchesDepartment) {
                $this->addError('assignTeacherId', 'Teacher does not belong to the selected department.');

                return;
            }
        }

        CourseAssignment::query()->updateOrCreate(
            [
                'teacher_id' => $data['assignTeacherId'],
                'course_id' => $data['assignCourseId'],
            ],
            [
                'class_room_id' => null,
                'academic_year_id' => $course->academic_year_id,
                'assigned_date' => now()->toDateString(),
                'status' => 'active',
                'note' => null,
            ],
        );

        $this->showAssignTeacherModal = false;
        $this->resetAssignTeacherForm();
        $this->dispatch('close-assign-teacher-modal');

        Notification::make()
            ->success()
            ->title('Teacher assigned to course')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        if (auth()->user()?->isStudent()) {
            return [];
        }

        return [
            CreateAction::make()
                ->icon('heroicon-m-plus')
                ->hiddenLabel()
                ->tooltip('បញ្ចូលវគ្គសិក្សា'),
        ];
    }

    private function resetAssignTeacherForm(): void
    {
        $this->assignCourseId = null;
        $this->assignCourseName = null;
        $this->assignDepartmentId = null;
        $this->assignTeacherId = null;
        $this->resetValidation();
    }
}
