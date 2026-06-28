<?php

namespace App\Filament\Admin\Resources\AssessmentQuestions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssessmentQuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['bank']))
            ->columns([
                TextColumn::make('question_text')->label('សំណួរ')->limit(60)->searchable(),
                TextColumn::make('bank.title')->label('ធនាគារ')->searchable()->sortable(),
                TextColumn::make('question_type')->label('ប្រភេទ')->badge(),
                TextColumn::make('points')->label('ពិន្ទុ')->sortable(),
                TextColumn::make('options_count')->label('ជម្រើស')->counts('options')->sortable(),
                IconColumn::make('is_active')->label('សកម្ម')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('created_at', 'desc');
    }
}
