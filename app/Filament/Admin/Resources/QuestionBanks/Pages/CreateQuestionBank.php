<?php

namespace App\Filament\Admin\Resources\QuestionBanks\Pages;

use App\Filament\Admin\Resources\QuestionBanks\QuestionBankResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestionBank extends CreateRecord
{
    protected static string $resource = QuestionBankResource::class;
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}