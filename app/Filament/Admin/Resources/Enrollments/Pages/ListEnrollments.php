<?php

namespace App\Filament\Admin\Resources\Enrollments\Pages;

use App\Filament\Admin\Resources\Enrollments\EnrollmentResource;
use App\Models\Enrollment;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Validation\Rule;

class ListEnrollments extends ListRecords
{
    protected static string $resource = EnrollmentResource::class;

    protected string $view = 'filament.admin.resources.enrollments.pages.list-enrollments';

    public ?int $course_id = null;
    public ?int $academic_year_id = null;
    public ?int $semester_id = null;

    public ?int $enrollmentDepartmentId = null;
    public ?int $enrollmentStudentId = null;
    public ?int $enrollmentCourseId = null;
    public ?int $enrollmentAcademicYearId = null;
    public ?int $enrollmentSemesterId = null;
    public ?string $enrollmentDate = null;
    public string $enrollmentStatus = 'studying';
    public ?string $enrollmentNote = null;
    public bool $showCreateEnrollmentModal = false;

    public function mount(): void
    {
        parent::mount();

        if (request()->boolean('openEnrollmentModal')) {
            $this->openCreateEnrollmentModal();
        }
    }

    public function updatedEnrollmentAcademicYearId(): void
    {
        $this->enrollmentSemesterId = null;
    }

    public function openCreateEnrollmentModal(): void
    {
        $this->resetCreateEnrollmentForm();
        $this->showCreateEnrollmentModal = true;
    }

    public function closeCreateEnrollmentModal(): void
    {
        $this->showCreateEnrollmentModal = false;
        $this->resetValidation();
    }

    public function createEnrollment(): void
    {
        $data = $this->validate([
            'enrollmentDepartmentId' => ['nullable', 'integer', 'exists:departments,department_id'],
            'enrollmentStudentId' => ['required', 'integer', 'exists:students,student_id'],
            'enrollmentCourseId' => ['required', 'integer', 'exists:courses,course_id'],
            'enrollmentAcademicYearId' => ['nullable', 'integer', 'exists:academic_years,academic_year_id'],
            'enrollmentSemesterId' => [
                'nullable',
                'integer',
                Rule::exists('semesters', 'semester_id')->where(fn ($query) => $query
                    ->when($this->enrollmentAcademicYearId, fn ($query) => $query->where('academic_year_id', $this->enrollmentAcademicYearId))),
            ],
            'enrollmentDate' => ['nullable', 'date'],
            'enrollmentStatus' => ['required', Rule::in(['studying', 'completed', 'cancelled'])],
            'enrollmentNote' => ['nullable', 'string'],
        ], [], [
            'enrollmentDepartmentId' => 'ដេប៉ាតឺម៉ង់',
            'enrollmentStudentId' => 'និស្សិត',
            'enrollmentCourseId' => 'វគ្គសិក្សា',
            'enrollmentAcademicYearId' => 'ឆ្នាំសិក្សា',
            'enrollmentSemesterId' => 'ឆមាស',
            'enrollmentDate' => 'ថ្ងៃចុះឈ្មោះ',
            'enrollmentStatus' => 'ស្ថានភាព',
            'enrollmentNote' => 'កំណត់សម្គាល់',
        ]);

        if ($this->enrollmentDepartmentId) {
            $studentMatchesDepartment = \App\Models\Student::query()
                ->whereKey($data['enrollmentStudentId'])
                ->where('department_id', $this->enrollmentDepartmentId)
                ->exists();

            $courseMatchesDepartment = \App\Models\Course::query()
                ->whereKey($data['enrollmentCourseId'])
                ->where('department_id', $this->enrollmentDepartmentId)
                ->exists();

            if (! $studentMatchesDepartment) {
                $this->addError('enrollmentStudentId', 'និស្សិតមិនស្ថិតក្នុងដេប៉ាតឺម៉ង់ដែលបានជ្រើសរើសទេ។');

                return;
            }

            if (! $courseMatchesDepartment) {
                $this->addError('enrollmentCourseId', 'វគ្គសិក្សាមិនស្ថិតក្នុងដេប៉ាតឺម៉ង់ដែលបានជ្រើសរើសទេ។');

                return;
            }
        }

        Enrollment::query()->create([
            'student_id' => $data['enrollmentStudentId'],
            'course_id' => $data['enrollmentCourseId'],
            'academic_year_id' => $data['enrollmentAcademicYearId'],
            'semester_id' => $data['enrollmentSemesterId'],
            'enrollment_date' => $data['enrollmentDate'],
            'status' => $data['enrollmentStatus'],
            'note' => $data['enrollmentNote'],
        ]);

        $this->showCreateEnrollmentModal = false;
        $this->resetCreateEnrollmentForm();
        $this->dispatch('close-create-enrollment-modal');

        Notification::make()
            ->success()
            ->title('បានចុះឈ្មោះចូលរៀនដោយជោគជ័យ')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    private function resetCreateEnrollmentForm(): void
    {
        $this->enrollmentDepartmentId = null;
        $this->enrollmentStudentId = null;
        $this->enrollmentCourseId = null;
        $this->enrollmentAcademicYearId = null;
        $this->enrollmentSemesterId = null;
        $this->enrollmentDate = now()->toDateString();
        $this->enrollmentStatus = 'studying';
        $this->enrollmentNote = null;
        $this->resetValidation();
    }
}
