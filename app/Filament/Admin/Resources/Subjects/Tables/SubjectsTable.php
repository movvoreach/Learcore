<?php

namespace App\Filament\Admin\Resources\Subjects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['course']))
            ->columns([
                TextColumn::make('subject_code')
                    ->label('លេខកូដ')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject_name')
                    ->label('ឈ្មោះមុខវិជ្ជា')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.course_name')
                    ->label('វគ្គសិក្សា')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('credit')
                    ->label('ក្រេឌីត')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('course_id')
                    ->label('វគ្គសិក្សា')
                    ->relationship('course', 'course_name')
                    ->searchable()
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
