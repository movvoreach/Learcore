<?php

namespace App\Filament\Admin\Resources\Semesters\Pages;

use App\Filament\Admin\Resources\Semesters\SemesterResource;
use App\Models\Semester;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListSemesters extends ListRecords
{
    protected static string $resource = SemesterResource::class;

    protected static ?string $title = 'បញ្ជីឆមាស';

    protected static ?string $breadcrumb = 'បញ្ជី';

    protected string $view = 'filament.admin.resources.semesters.pages.list-semesters';

    public ?int $semesterAcademicYearId = null;
    public ?string $semesterName = null;
    public ?string $semesterStartDate = null;
    public ?string $semesterEndDate = null;
    public bool $semesterIsActive = true;
    public bool $showCreateSemesterModal = false;

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    public function openCreateSemesterModal(): void
    {
        $this->resetCreateSemesterForm();
        $this->showCreateSemesterModal = true;
    }

    public function closeCreateSemesterModal(): void
    {
        $this->showCreateSemesterModal = false;
        $this->resetValidation();
    }

    public function createSemester(): void
    {
        $data = $this->validate([
            'semesterAcademicYearId' => ['required', 'integer', 'exists:academic_years,academic_year_id'],
            'semesterName' => ['required', 'string', 'max:100'],
            'semesterStartDate' => ['required', 'date', 'before_or_equal:semesterEndDate'],
            'semesterEndDate' => ['required', 'date', 'after_or_equal:semesterStartDate'],
            'semesterIsActive' => ['boolean'],
        ], [], [
            'semesterAcademicYearId' => 'ឆ្នាំសិក្សា',
            'semesterName' => 'ឈ្មោះឆមាស',
            'semesterStartDate' => 'ថ្ងៃចាប់ផ្តើម',
            'semesterEndDate' => 'ថ្ងៃបញ្ចប់',
            'semesterIsActive' => 'កំពុងប្រើប្រាស់',
        ]);

        Semester::query()->create([
            'academic_year_id' => $data['semesterAcademicYearId'],
            'semester_name' => $data['semesterName'],
            'start_date' => $data['semesterStartDate'],
            'end_date' => $data['semesterEndDate'],
            'is_active' => $data['semesterIsActive'],
        ]);

        $this->showCreateSemesterModal = false;
        $this->resetCreateSemesterForm();
        $this->dispatch('close-create-semester-modal');

        Notification::make()
            ->success()
            ->title('ឆមាសត្រូវបានបង្កើតដោយជោគជ័យ!')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    private function resetCreateSemesterForm(): void
    {
        $this->semesterAcademicYearId = null;
        $this->semesterName = null;
        $this->semesterStartDate = now()->toDateString();
        $this->semesterEndDate = now()->toDateString();
        $this->semesterIsActive = true;
        $this->resetValidation();
    }
}
