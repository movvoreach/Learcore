<?php

namespace App\Filament\Admin\Resources\QuestionOptions\Pages;

use App\Filament\Admin\Resources\QuestionOptions\QuestionOptionResource;
use Filament\Resources\Pages\EditRecord;

class EditQuestionOption extends EditRecord
{
    protected static string $resource = QuestionOptionResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}