<?php

namespace App\Filament\Admin\Resources\AssessmentResults\Pages;

use App\Filament\Admin\Resources\AssessmentResults\AssessmentResultResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssessmentResults extends ListRecords
{
    protected static string $resource = AssessmentResultResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
