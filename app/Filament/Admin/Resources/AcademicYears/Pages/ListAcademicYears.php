<?php

namespace App\Filament\Admin\Resources\AcademicYears\Pages;

use App\Filament\Admin\Resources\AcademicYears\AcademicYearResource;
use App\Models\AcademicYear;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Validation\Rule;

class ListAcademicYears extends ListRecords
{
    protected static string $resource = AcademicYearResource::class;

    protected static ?string $title = 'បញ្ជីឆ្នាំសិក្សា';

    protected static ?string $breadcrumb = 'បញ្ជី';

    protected string $view = 'filament.admin.resources.academic-years.pages.list-academic-years';

    public ?string $academicYearName = null;
    public ?string $academicYearStartDate = null;
    public ?string $academicYearEndDate = null;
    public bool $academicYearIsActive = true;
    public bool $showCreateAcademicYearModal = false;

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    public function openCreateAcademicYearModal(): void
    {
        $this->resetCreateAcademicYearForm();
        $this->showCreateAcademicYearModal = true;
    }

    public function closeCreateAcademicYearModal(): void
    {
        $this->showCreateAcademicYearModal = false;
        $this->resetValidation();
    }

    public function createAcademicYear(): void
    {
        $data = $this->validate([
            'academicYearName' => ['required', 'string', 'max:50', Rule::unique('academic_years', 'year_name')],
            'academicYearStartDate' => ['nullable', 'date'],
            'academicYearEndDate' => ['nullable', 'date', 'after_or_equal:academicYearStartDate'],
            'academicYearIsActive' => ['boolean'],
        ], [], [
            'academicYearName' => 'ឆ្នាំសិក្សា',
            'academicYearStartDate' => 'ថ្ងៃចាប់ផ្តើម',
            'academicYearEndDate' => 'ថ្ងៃបញ្ចប់',
            'academicYearIsActive' => 'កំពុងប្រើប្រាស់',
        ]);

        AcademicYear::query()->create([
            'year_name' => $data['academicYearName'],
            'start_date' => $data['academicYearStartDate'],
            'end_date' => $data['academicYearEndDate'],
            'is_active' => $data['academicYearIsActive'],
        ]);

        $this->showCreateAcademicYearModal = false;
        $this->resetCreateAcademicYearForm();
        $this->dispatch('close-create-academic-year-modal');

        Notification::make()
            ->success()
            ->title('ឆ្នាំសិក្សាត្រូវបានបង្កើតដោយជោគជ័យ!')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    private function resetCreateAcademicYearForm(): void
    {
        $this->academicYearName = null;
        $this->academicYearStartDate = now()->toDateString();
        $this->academicYearEndDate = now()->addYear()->toDateString();
        $this->academicYearIsActive = true;
        $this->resetValidation();
    }
}
