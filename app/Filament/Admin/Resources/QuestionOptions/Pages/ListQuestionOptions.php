<?php

namespace App\Filament\Admin\Resources\QuestionOptions\Pages;

use App\Filament\Admin\Resources\QuestionOptions\QuestionOptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQuestionOptions extends ListRecords
{
    protected static string $resource = QuestionOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
