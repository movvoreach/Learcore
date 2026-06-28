<?php

namespace App\Filament\Admin\Resources\StudentPromotions\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentPromotionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['fromDepartment', 'fromSemester', 'fromYear', 'student', 'toSemester', 'toYear']))
            ->columns([
                TextColumn::make('student.student_code')
                    ->label('លេខកូដ')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student.first_name')
                    ->label('និស្សិត')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fromDepartment.department_name')
                    ->label('ដេប៉ាតឺម៉ង់ដើម')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fromYear.year_name')
                    ->label('ឆ្នាំសិក្សាដើម')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fromSemester.semester_name')
                    ->label('ឆមាសដើម')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('toYear.year_name')
                    ->label('ឆ្នាំសិក្សាថ្មី')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('toSemester.semester_name')
                    ->label('ឆមាសថ្មី')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('promoted_at')
                    ->label('ថ្ងៃដំឡើងឆមាស')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('note')
                    ->label('កំណត់សម្គាល់')
                    ->limit(60)
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('from_department_id')
                    ->label('ដេប៉ាតឺម៉ង់ដើម')
                    ->relationship('fromDepartment', 'department_name')
                    ->searchable()
                    ->preload(false),
                SelectFilter::make('from_year_id')
                    ->label('ឆ្នាំសិក្សាដើម')
                    ->relationship('fromYear', 'year_name')
                    ->searchable()
                    ->preload(false),
                SelectFilter::make('to_year_id')
                    ->label('ឆ្នាំសិក្សាថ្មី')
                    ->relationship('toYear', 'year_name')
                    ->searchable()
                    ->preload(false),
            ], layout: FiltersLayout::AboveContent)
            ->defaultSort('promoted_at', 'desc');
    }
}
