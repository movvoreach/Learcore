<?php

namespace App\Filament\Admin\Resources\ContentAssignments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContentAssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['chapter', 'lesson']))
            ->columns([
                TextColumn::make('title')->label('កិច្ចការ')->searchable()->sortable(),
                TextColumn::make('lesson.title')->label('មេរៀន')->searchable()->sortable(),
                TextColumn::make('chapter.title')->label('ជំពូក')->searchable()->sortable(),
                TextColumn::make('due_at')->label('ផុតកំណត់')->dateTime()->sortable(),
                TextColumn::make('max_score')->label('ពិន្ទុ')->sortable(),
                IconColumn::make('is_published')->label('ផ្សាយ')->boolean(),
            ])
            ->filters([
                SelectFilter::make('content_lesson_id')->label('មេរៀន')->relationship('lesson', 'title')->searchable()->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('due_at');
    }
}
