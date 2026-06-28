<?php

namespace App\Filament\Admin\Resources\CourseCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CourseCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category_code')
                    ->label('លេខកូដ')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category_name')
                    ->label('ឈ្មោះប្រភេទវគ្គសិក្សា')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('courses_count')
                    ->label('ចំនួនវគ្គសិក្សា')
                    ->counts('courses')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('បានបង្កើត')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
