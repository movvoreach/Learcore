<?php

namespace App\Filament\Admin\Resources\CourseModules\Tables;

use App\Filament\Admin\Resources\ContentLessons\ContentLessonResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CourseModulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['course'])->withCount('lessons'))
            ->columns([
                TextColumn::make('module_number')->label('Order')->sortable(),
                TextColumn::make('title')->label('Module')->searchable()->sortable(),
                TextColumn::make('course.course_name')->label('Course')->searchable()->sortable(),
                TextColumn::make('lessons_count')->label('Lessons')->badge()->sortable(),
                TextColumn::make('lessons_tree')
                    ->label('Tree')
                    ->html()
                    ->state(function ($record): string {
                        $items = $record->lessons()
                            ->limit(8)
                            ->get()
                            ->map(fn ($lesson): string => '<div style="line-height:1.7"><span style="color:#16a34a">✓</span> Lesson '.e((string) $lesson->position).': '.e($lesson->title).'</div>')
                            ->implode('');

                        return $items ?: '<span style="color:#64748b">No lessons yet</span>';
                    })
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('course_id')->label('Course')->relationship('course', 'course_name')->searchable()->preload(),
            ])
            ->recordActions([
                Action::make('addLesson')
                    ->label('Add Lesson')
                    ->icon('heroicon-o-plus-circle')
                    ->url(fn ($record): string => ContentLessonResource::getUrl('create', [
                        'course_id' => $record->course_id,
                        'course_module_id' => $record->course_module_id,
                    ])),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('module_number')
            ->defaultSort('module_number');
    }
}
