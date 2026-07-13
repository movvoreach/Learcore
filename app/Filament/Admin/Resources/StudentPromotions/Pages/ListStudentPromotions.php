<?php

namespace App\Filament\Admin\Resources\StudentPromotions\Pages;

use App\Filament\Admin\Resources\StudentPromotions\StudentPromotionResource;
use App\Models\Student;
use App\Services\StudentPromotionService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ListStudentPromotions extends ListRecords
{
    protected static string $resource = StudentPromotionResource::class;

    protected string $view = 'filament.admin.resources.student-promotions.pages.list-student-promotions';

    public ?int $promotionStudentId = null;
    public ?int $promotionToYearId = null;
    public ?int $promotionToSemesterId = null;
    public ?string $promotionNote = null;
    public bool $showCreatePromotionModal = false;

    public ?int $groupFromDepartmentId = null;
    public ?int $groupFromYearId = null;
    public ?int $groupFromSemesterId = null;
    public ?int $groupToYearId = null;
    public ?int $groupToSemesterId = null;
    public ?string $groupNote = null;
    public bool $showGroupPromotionModal = false;

    public ?int $nextFromDepartmentId = null;
    public ?int $nextFromYearId = null;
    public ?int $nextFromSemesterId = null;
    public ?string $nextNote = null;
    public bool $showNextPromotionModal = false;

    public function mount(): void
    {
        parent::mount();

        if (request()->boolean('openPromotionModal')) {
            $this->openCreatePromotionModal();
        }
    }

    public function openCreatePromotionModal(): void
    {
        $this->resetCreatePromotionForm();
        $this->showCreatePromotionModal = true;
    }

    public function closeCreatePromotionModal(): void
    {
        $this->showCreatePromotionModal = false;
        $this->resetValidation();
    }

    public function openGroupPromotionModal(): void
    {
        $this->resetGroupPromotionForm();
        $this->showGroupPromotionModal = true;
    }

    public function closeGroupPromotionModal(): void
    {
        $this->showGroupPromotionModal = false;
        $this->resetValidation();
    }

    public function openNextPromotionModal(): void
    {
        $this->resetNextPromotionForm();
        $this->showNextPromotionModal = true;
    }

    public function closeNextPromotionModal(): void
    {
        $this->showNextPromotionModal = false;
        $this->resetValidation();
    }

    public function createStudentPromotion(): void
    {
        $data = $this->validate([
            'promotionStudentId' => ['required', 'integer', 'exists:students,student_id'],
            'promotionToYearId' => ['required', 'integer', 'exists:academic_years,academic_year_id'],
            'promotionToSemesterId' => [
                'required',
                'integer',
                Rule::exists('semesters', 'semester_id')
                    ->where(fn ($query) => $query->where('academic_year_id', $this->promotionToYearId)),
            ],
            'promotionNote' => ['nullable', 'string', 'max:1000'],
        ], [], [
            'promotionStudentId' => 'និស្សិត',
            'promotionToYearId' => 'ឆ្នាំសិក្សាថ្មី',
            'promotionToSemesterId' => 'ឆមាសថ្មី',
            'promotionNote' => 'កំណត់សម្គាល់',
        ]);

        app(StudentPromotionService::class)->promote(
            Student::query()->findOrFail($data['promotionStudentId']),
            (int) $data['promotionToYearId'],
            (int) $data['promotionToSemesterId'],
            $data['promotionNote'] ?? null,
        );

        $this->showCreatePromotionModal = false;
        $this->resetCreatePromotionForm();
        $this->dispatch('close-create-promotion-modal');

        Notification::make()
            ->success()
            ->title('បានដំឡើងឆមាសនិស្សិត')
            ->send();
    }

    public function createGroupPromotion(): void
    {
        $data = $this->validate([
            'groupFromDepartmentId' => ['required', 'integer', 'exists:departments,department_id'],
            'groupFromYearId' => ['required', 'integer', 'exists:academic_years,academic_year_id'],
            'groupFromSemesterId' => [
                'required',
                'integer',
                Rule::exists('semesters', 'semester_id')
                    ->where(fn ($query) => $query->where('academic_year_id', $this->groupFromYearId)),
            ],
            'groupToYearId' => ['required', 'integer', 'exists:academic_years,academic_year_id'],
            'groupToSemesterId' => [
                'required',
                'integer',
                Rule::exists('semesters', 'semester_id')
                    ->where(fn ($query) => $query->where('academic_year_id', $this->groupToYearId)),
            ],
            'groupNote' => ['nullable', 'string', 'max:1000'],
        ], [], [
            'groupFromDepartmentId' => 'ដេប៉ាតឺម៉ង់',
            'groupFromYearId' => 'ឆ្នាំសិក្សា',
            'groupFromSemesterId' => 'ឆមាស',
            'groupToYearId' => 'ឆ្នាំសិក្សាថ្មី',
            'groupToSemesterId' => 'ឆមាសថ្មី',
            'groupNote' => 'កំណត់សម្គាល់',
        ]);

        $promotedCount = DB::transaction(function () use ($data): int {
            $students = Student::query()
                ->where('department_id', $data['groupFromDepartmentId'])
                ->where('academic_year_id', $data['groupFromYearId'])
                ->where('semester_id', $data['groupFromSemesterId'])
                ->get();

            foreach ($students as $student) {
                app(StudentPromotionService::class)->promote(
                    $student,
                    (int) $data['groupToYearId'],
                    (int) $data['groupToSemesterId'],
                    $data['groupNote'] ?? null,
                );
            }

            return $students->count();
        });

        $this->showGroupPromotionModal = false;
        $this->resetGroupPromotionForm();
        $this->dispatch('close-group-promotion-modal');

        Notification::make()
            ->success()
            ->title("បានដំឡើងឆមាសនិស្សិត {$promotedCount} នាក់")
            ->send();
    }

    public function createNextPromotion(): void
    {
        $data = $this->validate([
            'nextFromDepartmentId' => ['required', 'integer', 'exists:departments,department_id'],
            'nextFromYearId' => ['required', 'integer', 'exists:academic_years,academic_year_id'],
            'nextFromSemesterId' => [
                'required',
                'integer',
                Rule::exists('semesters', 'semester_id')
                    ->where(fn ($query) => $query->where('academic_year_id', $this->nextFromYearId)),
            ],
            'nextNote' => ['nullable', 'string', 'max:1000'],
        ], [], [
            'nextFromDepartmentId' => 'Department',
            'nextFromYearId' => 'Academic Year',
            'nextFromSemesterId' => 'Semester',
            'nextNote' => 'Note',
        ]);

        $students = Student::query()
            ->where('department_id', $data['nextFromDepartmentId'])
            ->where('academic_year_id', $data['nextFromYearId'])
            ->where('semester_id', $data['nextFromSemesterId'])
            ->where('status', 'active')
            ->get();

        foreach ($students as $student) {
            app(StudentPromotionService::class)->promoteToNext($student, $data['nextNote'] ?? null);
        }

        $this->showNextPromotionModal = false;
        $this->resetNextPromotionForm();
        $this->dispatch('close-next-promotion-modal');

        Notification::make()
            ->success()
            ->title("Promoted {$students->count()} students to the next semester")
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    private function resetCreatePromotionForm(): void
    {
        $this->promotionStudentId = null;
        $this->promotionToYearId = null;
        $this->promotionToSemesterId = null;
        $this->promotionNote = null;
        $this->resetValidation();
    }

    private function resetGroupPromotionForm(): void
    {
        $this->groupFromDepartmentId = null;
        $this->groupFromYearId = null;
        $this->groupFromSemesterId = null;
        $this->groupToYearId = null;
        $this->groupToSemesterId = null;
        $this->groupNote = null;
        $this->resetValidation();
    }

    private function resetNextPromotionForm(): void
    {
        $this->nextFromDepartmentId = null;
        $this->nextFromYearId = null;
        $this->nextFromSemesterId = null;
        $this->nextNote = 'Automatic next-semester bulk promotion';
        $this->resetValidation();
    }
}
