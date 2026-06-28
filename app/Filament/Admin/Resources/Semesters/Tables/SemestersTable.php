<?php

namespace App\Filament\Admin\Resources\Semesters\Tables;

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

class SemestersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['academicYear']))
            ->columns([
                TextColumn::make('semester_name')
                    ->label('ឆមាស')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('academicYear.year_name')
                    ->label('ឆ្នាំសិក្សា')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label('ថ្ងៃចាប់ផ្តើម')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('ថ្ងៃបញ្ចប់')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('កំពុងប្រើប្រាស់')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('academic_year_id')
                    ->label('ឆ្នាំសិក្សា')
                    ->relationship('academicYear', 'year_name')
                    ->searchable()
                    ->preload(false),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make()
                    ->label('កែសម្រួល')
                    ->successNotificationTitle('ឆមាសត្រូវបានកែសម្រួលដោយជោគជ័យ!'),
                DeleteAction::make()
                    ->label('លុប')
                    ->successNotificationTitle('ឆមាសត្រូវបានលុបដោយជោគជ័យ!'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('លុបដែលបានជ្រើសរើស')
                        ->successNotificationTitle('ឆមាសដែលបានជ្រើសរើសត្រូវបានលុបដោយជោគជ័យ!'),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
    }
}
