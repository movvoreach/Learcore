<?php

namespace App\Filament\Admin\Resources\Departments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DepartmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['faculty']))
            ->columns([
                TextColumn::make('department_code')
                    ->label('លេខកូដ')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('department_name')
                    ->label('ឈ្មោះដេប៉ាតឺម៉ង់')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('faculty.faculty_name')
                    ->label('មហាវិទ្យាល័យ')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('deans')
                    ->label('ប្រធានដេប៉ាតឺម៉ង់')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('created_at')
                    ->label('បានបង្កើត')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('faculty_id')
                    ->label('មហាវិទ្យាល័យ')
                    ->relationship('faculty', 'faculty_name')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('has_dean')
                    ->label('ស្ថានភាពប្រធានដេប៉ាតឺម៉ង់')
                    ->placeholder('ទាំងអស់')
                    ->trueLabel('មានប្រធានដេប៉ាតឺម៉ង់')
                    ->falseLabel('គ្មានប្រធានដេប៉ាតឺម៉ង់')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('deans')->where('deans', '!=', ''),
                        false: fn (Builder $query) => $query->where(fn ($q) => $q->whereNull('deans')->orWhere('deans', '')),
                    ),
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(2)

            // Pagination
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(10)

            ->recordActions([
                ViewAction::make()
                    ->label('មើល'),
                EditAction::make()
                    ->label('កែសម្រួល')
                    ->successNotificationTitle('ដេប៉ាតឺម៉ង់ត្រូវបានកែសម្រួលដោយជោគជ័យ!'),
                DeleteAction::make()
                    ->label('លុប')
                    ->successNotificationTitle('ដេប៉ាតឺម៉ង់ត្រូវបានលុបដោយជោគជ័យ!'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('លុបដែលបានជ្រើសរើស')
                        ->successNotificationTitle('ដេប៉ាតឺម៉ង់ដែលបានជ្រើសរើសត្រូវបានលុបដោយជោគជ័យ!'),
                ]),
            ])

            ->defaultSort('created_at', 'desc');
    }
}
