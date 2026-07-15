<?php

namespace App\Filament\Admin\Resources\Enrollments\Pages;

use App\Filament\Admin\Resources\Enrollments\EnrollmentResource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
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
    public ?int $enrollmentClassRoomId = null;
    public ?int $enrollmentAcademicYearId = null;
    public ?int $enrollmentSemesterId = null;
    public ?string $enrollmentDate = null;
    public string $enrollmentStatus = 'studying';
    public ?string $enrollmentNote = null;
    public ?string $enrollmentStudentCode = null;
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

    public function openCreateEnrollmentModal(
        ?int $courseId = null,
        ?int $classRoomId = null,
        ?int $academicYearId = null,
        ?int $semesterId = null,
    ): void
    {
        $this->resetCreateEnrollmentForm();
        $this->enrollmentCourseId = $courseId;
        $this->enrollmentClassRoomId = $classRoomId;
        $this->enrollmentAcademicYearId = $academicYearId;
        $this->enrollmentSemesterId = $semesterId;
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

    public function createEnrollmentByStudentCode(): void
    {
        $data = $this->validate([
            'enrollmentStudentId' => ['required_without:enrollmentStudentCode', 'nullable', 'integer', 'exists:students,student_id'],
            'enrollmentStudentCode' => ['required_without:enrollmentStudentId', 'nullable', 'string', 'max:30'],
            'enrollmentCourseId' => ['required', 'integer', 'exists:courses,course_id'],
            'enrollmentClassRoomId' => ['nullable', 'integer', 'exists:class_rooms,class_room_id'],
            'enrollmentAcademicYearId' => ['nullable', 'integer', 'exists:academic_years,academic_year_id'],
            'enrollmentSemesterId' => [
                'nullable',
                'integer',
                Rule::exists('semesters', 'semester_id')->where(fn ($query) => $query
                    ->when($this->enrollmentAcademicYearId, fn ($query) => $query->where('academic_year_id', $this->enrollmentAcademicYearId))),
            ],
        ], [], [
            'enrollmentStudentId' => 'អត្តលេខសិក្ខាកាម',
            'enrollmentStudentCode' => 'អត្តលេខសិក្ខាកាម',
            'enrollmentCourseId' => 'វគ្គសិក្សា',
        ]);

        $student = filled($data['enrollmentStudentId'] ?? null)
            ? Student::query()->whereKey($data['enrollmentStudentId'])->first()
            : Student::query()
                ->where('student_code', trim((string) $data['enrollmentStudentCode']))
                ->first();

        if (! $student) {
            $this->addError('enrollmentStudentId', 'រកមិនឃើញសិក្ខាកាមដែលមានអត្តលេខនេះទេ។');

            return;
        }

        $user = auth()->user();
        $courseQuery = Course::query()->whereKey($data['enrollmentCourseId']);

        if ($user?->hasRole('teacher') && ! $user->hasAnyRole(['super_admin', 'admin'])) {
            $courseQuery->whereHas('courseAssignments', fn (Builder $query): Builder => $user->teacher
                ? $query->where('teacher_id', $user->teacher->teacher_id)
                : $query->whereRaw('1 = 0'));
        }

        if (! $courseQuery->exists()) {
            $this->addError('enrollmentCourseId', 'អ្នកមិនអាចចុះឈ្មោះសិក្ខាកាមចូលវគ្គសិក្សានេះបានទេ។');

            return;
        }

        $alreadyEnrolled = Enrollment::query()
            ->where('student_id', $student->student_id)
            ->where('course_id', $data['enrollmentCourseId'])
            ->whereIn('status', ['studying', 'completed'])
            ->exists();

        if ($alreadyEnrolled) {
            $this->addError('enrollmentStudentCode', 'សិក្ខាកាមនេះបានចុះឈ្មោះក្នុងវគ្គសិក្សានេះរួចហើយ។');

            return;
        }

        Enrollment::query()->create([
            'student_id' => $student->student_id,
            'course_id' => $data['enrollmentCourseId'],
            'class_room_id' => $data['enrollmentClassRoomId'],
            'academic_year_id' => $data['enrollmentAcademicYearId'],
            'semester_id' => $data['enrollmentSemesterId'],
            'enrollment_date' => now()->toDateString(),
            'status' => 'studying',
        ]);

        $this->showCreateEnrollmentModal = false;
        $this->resetCreateEnrollmentForm();
        $this->dispatch('close-create-enrollment-modal');

        Notification::make()
            ->success()
            ->title('បានចុះឈ្មោះសិក្ខាកាមចូលវគ្គសិក្សាដោយជោគជ័យ')
            ->send();
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $query = $this->enrollmentsQuery();
        $enrollments = (clone $query)
            ->latest('enrollment_date')
            ->latest('created_at')
            ->paginate(10, ['*'], 'page')
            ->withPath(EnrollmentResource::getUrl('index'));

        return [
            'enrollments' => $enrollments,
            'totalEnrollments' => (clone $query)->count(),
            'studyingEnrollments' => (clone $query)->where('status', 'studying')->count(),
            'completedEnrollments' => (clone $query)->where('status', 'completed')->count(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    private function enrollmentsQuery(): Builder
    {
        $user = auth()->user();

        return Enrollment::query()
            ->with(['academicYear', 'semester', 'student.department', 'course.department', 'classRoom'])
            ->when($this->course_id, fn (Builder $query): Builder => $query->where('course_id', $this->course_id))
            ->when($this->academic_year_id, fn (Builder $query): Builder => $query->where('academic_year_id', $this->academic_year_id))
            ->when($this->semester_id, fn (Builder $query): Builder => $query->where('semester_id', $this->semester_id))
            ->when(
                $user?->hasRole('teacher') && ! $user->hasAnyRole(['super_admin', 'admin']),
                fn (Builder $query): Builder => $user->teacher
                    ? $query->whereHas('course.courseAssignments', fn (Builder $query): Builder => $query
                        ->where('teacher_id', $user->teacher->teacher_id))
                    : $query->whereRaw('1 = 0')
            );
    }

    private function resetCreateEnrollmentForm(): void
    {
        $this->enrollmentDepartmentId = null;
        $this->enrollmentStudentId = null;
        $this->enrollmentCourseId = null;
        $this->enrollmentClassRoomId = null;
        $this->enrollmentAcademicYearId = null;
        $this->enrollmentSemesterId = null;
        $this->enrollmentDate = now()->toDateString();
        $this->enrollmentStatus = 'studying';
        $this->enrollmentNote = null;
        $this->enrollmentStudentCode = null;
        $this->resetValidation();
    }
}
