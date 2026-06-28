<?php

namespace App\Filament\Admin\Resources\QuestionOptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuestionOptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['question']))
            ->columns([
                TextColumn::make('question.question_text')->label('សំណួរ')->limit(50)->searchable(),
                TextColumn::make('option_text')->label('ជម្រើស')->limit(50)->searchable(),
                TextColumn::make('sort_order')->label('លំដាប់')->sortable(),
                IconColumn::make('is_correct')->label('ត្រឹមត្រូវ')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('sort_order');
    }
}
