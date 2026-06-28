<?php

namespace App\Filament\Admin\Resources\Teachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TeachersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['department']))
            ->columns([
                TextColumn::make('teacher_code')->label('លេខកូដគ្រូ')->searchable()->sortable(),
                TextColumn::make('first_name')->label('នាមខ្លួន')->searchable()->sortable(),
                TextColumn::make('last_name')->label('នាមត្រកូល')->searchable()->sortable(),
                TextColumn::make('department.department_name')->label('ដេប៉ាតឺម៉ង់')->searchable()->sortable(),
                TextColumn::make('employment_type')
                    ->label('ប្រភេទការងារ')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'full_time' => 'ពេញម៉ោង',
                        'part_time' => 'ក្រៅម៉ោង',
                        default => $state,
                    }),
                TextColumn::make('phone')->label('លេខទូរស័ព្ទ')->searchable(),
                TextColumn::make('specialization')->label('ជំនាញ')->searchable()->toggleable(),
                TextColumn::make('status')
                    ->label('ស្ថានភាព')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'កំពុងបង្រៀន',
                        'inactive' => 'ផ្អាក',
                        'resigned' => 'លាឈប់',
                        default => $state,
                    }),
                TextColumn::make('created_at')->label('បានបង្កើត')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'active' => 'កំពុងបង្រៀន',
                        'inactive' => 'ផ្អាក',
                        'resigned' => 'លាឈប់',
                    ]),
                SelectFilter::make('department_id')
                    ->label('ដេប៉ាតឺម៉ង់')
                    ->relationship('department', 'department_name')
                    ->searchable()
                    ->preload(false),
                SelectFilter::make('employment_type')
                    ->label('ប្រភេទការងារ')
                    ->options([
                        'full_time' => 'ពេញម៉ោង',
                        'part_time' => 'ក្រៅម៉ោង',
                    ]),
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
