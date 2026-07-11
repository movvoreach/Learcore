<?php

namespace App\Filament\Admin\Resources\Enrollments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query, $livewire): Builder => $query
                ->with(['academicYear', 'course', 'semester', 'student'])
                ->when($livewire && isset($livewire->course_id) && $livewire->course_id, fn ($q) => $q->where('course_id', $livewire->course_id))
                ->when($livewire && isset($livewire->academic_year_id) && $livewire->academic_year_id, fn ($q) => $q->where('academic_year_id', $livewire->academic_year_id))
                ->when($livewire && isset($livewire->semester_id) && $livewire->semester_id, fn ($q) => $q->where('semester_id', $livewire->semester_id))
            )
            ->columns([
                TextColumn::make('student.student_code')
                    ->label('លេខកូដ')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student.first_name')
                    ->label('និស្សិត')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.course_name')
                    ->label('វគ្គសិក្សា')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('academicYear.year_name')
                    ->label('ឆ្នាំសិក្សា')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('semester.semester_name')
                    ->label('ឆមាស')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('enrollment_date')
                    ->label('ថ្ងៃចុះឈ្មោះ')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('ស្ថានភាព')
                    ->badge(),
            ])
            ->filters([])
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
