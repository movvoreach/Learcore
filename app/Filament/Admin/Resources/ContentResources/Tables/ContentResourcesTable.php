<?php

namespace App\Filament\Admin\Resources\ContentResources\Tables;

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

class ContentResourcesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['chapter', 'lesson']))
            ->columns([
                TextColumn::make('title')->label('ធនធាន')->searchable()->sortable(),
                TextColumn::make('lesson.title')->label('មេរៀន')->searchable()->sortable(),
                TextColumn::make('chapter.title')->label('ជំពូក')->searchable()->sortable(),
                TextColumn::make('external_url')->label('តំណ')->limit(35)->toggleable(),
                IconColumn::make('is_published')->label('ផ្សាយ')->boolean(),
            ])
            ->filters([
                SelectFilter::make('content_lesson_id')->label('មេរៀន')->relationship('lesson', 'title')->searchable()->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('sort_order');
    }
}
