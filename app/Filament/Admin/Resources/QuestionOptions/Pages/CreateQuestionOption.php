<?php

namespace App\Filament\Admin\Resources\QuestionOptions\Pages;

use App\Filament\Admin\Resources\QuestionOptions\QuestionOptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestionOption extends CreateRecord
{
    protected static string $resource = QuestionOptionResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}