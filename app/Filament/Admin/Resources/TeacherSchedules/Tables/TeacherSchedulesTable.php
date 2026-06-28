<?php

namespace App\Filament\Admin\Resources\TeacherSchedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TeacherSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['classRoom', 'course', 'teacher']))
            ->columns([
                TextColumn::make('teacher.first_name')->label('គ្រូបង្រៀន')->searchable()->sortable(),
                TextColumn::make('course.course_name')->label('វគ្គសិក្សា')->searchable()->sortable(),
                TextColumn::make('classRoom.class_name')->label('ថ្នាក់រៀន')->searchable()->sortable(),
                TextColumn::make('day_of_week')->label('ថ្ងៃ')->badge(),
                TextColumn::make('start_time')->label('ចាប់ផ្តើម'),
                TextColumn::make('end_time')->label('បញ្ចប់'),
                TextColumn::make('room')->label('បន្ទប់')->searchable(),
                TextColumn::make('status')->label('ស្ថានភាព')->badge(),
            ])
            ->filters([
                SelectFilter::make('teacher_id')->label('គ្រូបង្រៀន')->relationship('teacher', 'first_name')->searchable()->preload(false),
                SelectFilter::make('day_of_week')
                    ->label('ថ្ងៃ')
                    ->options([
                        'monday' => 'ចន្ទ',
                        'tuesday' => 'អង្គារ',
                        'wednesday' => 'ពុធ',
                        'thursday' => 'ព្រហស្បតិ៍',
                        'friday' => 'សុក្រ',
                        'saturday' => 'សៅរ៍',
                        'sunday' => 'អាទិត្យ',
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
