<?php

namespace App\Filament\Admin\Resources\Enrollments\Pages;

use App\Filament\Admin\Resources\Enrollments\EnrollmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListEnrollments extends ListRecords
{
    protected static string $resource = EnrollmentResource::class;

    public function mount(): void
    {
        parent::mount();

        if (request()->boolean('openEnrollmentModal')) {
            $this->defaultAction = 'create';
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('ចុះឈ្មោះចូលរៀន')
                ->modalHeading('ចុះឈ្មោះចូលរៀន')
                ->modalDescription('ជ្រើសនិស្សិត វគ្គសិក្សា ឆ្នាំសិក្សា និងឆមាស ដើម្បីចុះឈ្មោះចូលរៀន។')
                ->modalSubmitActionLabel('រក្សាទុក')
                ->modalWidth(Width::SevenExtraLarge)
                ->createAnother(false),
        ];
    }
}
