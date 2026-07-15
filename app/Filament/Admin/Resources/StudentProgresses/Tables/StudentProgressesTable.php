<?php

namespace App\Filament\Admin\Resources\StudentProgresses\Tables;

use App\Filament\Admin\Pages\CourseStudents;
use App\Models\StudentProgress;
use App\Services\StudentCourseProgressService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentProgressesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['course', 'student']))
            ->columns([
                TextColumn::make('student.student_code')->label('លេខកូដ')->searchable()->sortable(),
                TextColumn::make('student.first_name')->label('និស្សិត')->searchable()->sortable(),
                TextColumn::make('course.course_name')->label('វគ្គសិក្សា')->searchable()->sortable(),
                TextColumn::make('progress_percent')->label('វឌ្ឍនភាព')->suffix('%')->sortable(),
                TextColumn::make('completed_lessons')
                    ->label('Lessons')
                    ->getStateUsing(function (StudentProgress $record): string {
                        $note = app(StudentCourseProgressService::class)->decodeNote($record->note);
                        $completed = count($note['completed_lesson_ids'] ?? []);
                        $total = (int) ($note['total_lessons'] ?? $record->course?->contentLessons()->publishedForStudents()->count() ?? 0);

                        return $completed.' / '.$total;
                    }),
                TextColumn::make('attendance_score')->label('Attendance')->sortable(),
                TextColumn::make('attribute_score')->label('Attribute')->sortable(),
                TextColumn::make('midterm_score')->label('Midterm')->sortable(),
                TextColumn::make('assignment_score')->label('Homework')->sortable(),
                TextColumn::make('final_score')->label('Final')->sortable(),
                TextColumn::make('score')->label('ពិន្ទុ')->sortable(),
                TextColumn::make('status')->label('ស្ថានភាព')->badge(),
                TextColumn::make('progress_date')->label('កាលបរិច្ឆេទ')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('course_id')->label('វគ្គសិក្សា')->relationship('course', 'course_name')->searchable()->preload(),
                SelectFilter::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'in_progress' => 'កំពុងដំណើរការ',
                        'completed' => 'បានបញ្ចប់',
                        'needs_support' => 'ត្រូវការជំនួយ',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                Action::make('course_progress')
                    ->label('Course Progress')
                    ->icon(Heroicon::OutlinedUsers)
                    ->color('info')
                    ->url(fn (StudentProgress $record): string => CourseStudents::getUrl(['course' => $record->course_id])),
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
