<?php

namespace App\Filament\Admin\Resources\ContentLessons\Tables;

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

class ContentLessonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['course']))
            ->columns([
                TextColumn::make('title')->label('មេរៀន')->searchable()->sortable(),
                TextColumn::make('course.course_name')->label('វគ្គសិក្សា')->searchable()->sortable(),
                TextColumn::make('content_type')->label('Type')->badge()->sortable(),
                TextColumn::make('module_number')->label('Module')->sortable(),
                TextColumn::make('position')->label('លំដាប់')->sortable(),
                TextColumn::make('visibility')->label('Visibility')->badge()->sortable(),
                IconColumn::make('is_published')->label('ផ្សាយ')->boolean(),
                TextColumn::make('created_at')->label('បានបង្កើត')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('course_id')->label('វគ្គសិក្សា')->relationship('course', 'course_name')->searchable()->preload(),
                SelectFilter::make('content_type')
                    ->label('Type')
                    ->options([
                        'lesson' => 'Lesson',
                        'page' => 'Page',
                        'video' => 'Video',
                        'file' => 'File',
                        'url' => 'URL',
                        'assignment' => 'Assignment',
                        'quiz' => 'Quiz',
                        'forum' => 'Forum',
                    ]),
                SelectFilter::make('visibility')
                    ->label('Visibility')
                    ->options([
                        'visible' => 'Visible',
                        'hidden' => 'Hidden',
                        'scheduled' => 'Scheduled',
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
            ->defaultSort('position');
    }
}
