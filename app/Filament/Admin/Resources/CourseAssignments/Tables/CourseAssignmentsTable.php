<?php

namespace App\Filament\Admin\Resources\CourseAssignments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CourseAssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['academicYear', 'classRoom', 'course', 'teacher']))
            ->columns([
                TextColumn::make('teacher.teacher_code')->label('លេខកូដគ្រូ')->searchable()->sortable(),
                TextColumn::make('teacher.first_name')->label('គ្រូបង្រៀន')->searchable()->sortable(),
                TextColumn::make('course.course_name')->label('វគ្គសិក្សា')->searchable()->sortable(),
                TextColumn::make('classRoom.class_name')->label('ថ្នាក់រៀន')->searchable()->sortable(),
                TextColumn::make('academicYear.year_name')->label('ឆ្នាំសិក្សា')->sortable(),
                TextColumn::make('assigned_date')->label('ថ្ងៃចាត់តាំង')->date()->sortable(),
                TextColumn::make('status')->label('ស្ថានភាព')->badge(),
            ])
            ->filters([
                SelectFilter::make('teacher_id')->label('គ្រូបង្រៀន')->relationship('teacher', 'first_name')->searchable()->preload(),
                SelectFilter::make('course_id')->label('វគ្គសិក្សា')->relationship('course', 'course_name')->searchable()->preload(),
                SelectFilter::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'active' => 'កំពុងដំណើរការ',
                        'completed' => 'បានបញ្ចប់',
                        'cancelled' => 'បានលុបចោល',
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
