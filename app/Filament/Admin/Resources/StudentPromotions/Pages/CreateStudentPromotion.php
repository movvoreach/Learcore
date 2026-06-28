<?php

namespace App\Filament\Admin\Resources\StudentPromotions\Pages;

use App\Filament\Admin\Resources\StudentPromotions\StudentPromotionResource;
use App\Models\Student;
use App\Services\StudentPromotionService;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateStudentPromotion extends CreateRecord
{
    protected static string $resource = StudentPromotionResource::class;

    protected static bool $canCreateAnother = false;

    public function mount(): void
    {
        $this->redirect(static::getResource()::getUrl('index', [
            'openPromotionModal' => 1,
        ]));
    }

    protected function handleRecordCreation(array $data): Model
    {
        return app(StudentPromotionService::class)->promote(
            Student::query()->findOrFail($data['student_id']),
            (int) $data['to_year_id'],
            (int) $data['to_semester_id'],
            $data['note'] ?? null,
        );
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'បានដំឡើងឆមាសនិស្សិត';
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('ដំឡើងឆមាស');
    }
}
