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
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['academicYear', 'course', 'semester', 'student']))
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
            ->filters([
                SelectFilter::make('course_id')
                    ->label('វគ្គសិក្សា')
                    ->relationship('course', 'course_name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('academic_year_id')
                    ->label('ឆ្នាំសិក្សា')
                    ->relationship('academicYear', 'year_name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('semester_id')
                    ->label('ឆមាស')
                    ->relationship('semester', 'semester_name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'studying' => 'កំពុងសិក្សា',
                        'completed' => 'បានបញ្ចប់',
                        'cancelled' => 'បានបោះបង់',
                    ])
                    ->searchable(),
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
