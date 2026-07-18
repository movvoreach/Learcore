<?php

namespace App\Filament\Admin\Resources\Courses\Tables;

use App\Filament\Admin\Pages\CourseLessons;
use App\Filament\Admin\Pages\CourseStudents;
use App\Filament\Admin\Pages\StudentCourse;
use App\Models\Course;
use App\Services\CourseCompletionService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['academicYear', 'category', 'department', 'semester', 'courseAssignments.teacher']))
            ->columns([
                TextColumn::make('course_code')
                    ->label('Course Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('course_name')
                    ->label('Course Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.category_name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('department.department_name')
                    ->label('Department')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('academicYear.year_name')
                    ->label('Academic Year')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('semester.semester_name')
                    ->label('Semester')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('visibility')
                    ->label('Visibility')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'public' => 'Public',
                        'university_students' => 'University Students Only',
                        default => 'Private',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'public' => 'success',
                        'university_students' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('teacher_name')
                    ->label('Teacher')
                    ->getStateUsing(function (Course $record): string {
                        $teacher = $record->courseAssignments->first()?->teacher;

                        return $teacher ? trim($teacher->first_name.' '.$teacher->last_name) : 'Not assigned';
                    }),

                TextColumn::make('published_lessons_count')
                    ->label('Lessons')
                    ->badge()
                    ->sortable(),

                TextColumn::make('progress_percent')
                    ->label('Progress')
                    ->getStateUsing(function (Course $record): string {
                        if (! auth()->user()?->isStudent()) {
                            return '-';
                        }

                        return number_format((float) ($record->student_progress_percent ?? 0), 0).'%';
                    }),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('course_category_id')
                    ->label('Category')
                    ->relationship('category', 'category_name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'department_name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('academic_year_id')
                    ->label('Academic Year')
                    ->relationship('academicYear', 'year_name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('semester_id')
                    ->label('Semester')
                    ->relationship('semester', 'semester_name')
                    ->searchable()
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->recordUrl(fn (Course $record): ?string => auth()->user()?->isStudent()
                ? StudentCourse::getUrl(['course' => $record->course_id])
                : null)
            ->recordActions([
                ActionGroup::make([
                    Action::make('view_students')
                        ->label('View Students')
                        ->icon(Heroicon::OutlinedUsers)
                        ->color('info')
                        ->url(fn (Course $record): string => CourseStudents::getUrl(['course' => $record->course_id])),

                    Action::make('view_lessons')
                        ->label('View Lessons')
                        ->icon(Heroicon::OutlinedBookOpen)
                        ->color('success')
                        ->url(fn (Course $record): string => CourseLessons::getUrl(['course' => $record->course_id])),

                    Action::make('mark_course_completed')
                        ->label('Mark Course Completed')
                        ->icon(Heroicon::OutlinedCheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Submit course completion request')
                        ->modalDescription('The system will verify lessons, enrolled student progress, quizzes, and assignments before sending this course to admin review.')
                        ->action(function (Course $record): void {
                            try {
                                app(CourseCompletionService::class)->requestCompletion($record, auth()->user());

                                Notification::make()
                                    ->success()
                                    ->title('Course completion request submitted')
                                    ->body('Admin has been notified for certificate approval.')
                                    ->send();
                            } catch (\Throwable $exception) {
                                Notification::make()
                                    ->danger()
                                    ->title('Course is not ready')
                                    ->body($exception->getMessage())
                                    ->send();
                            }
                        })
                        ->visible(fn (Course $record): bool => auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher'])
                            && ! auth()->user()?->isStudent()
                            && ! $record->completionRequests()->where('status', 'pending')->exists()),

                    Action::make('assign_teacher')
                        ->label('Assign Teacher')
                        ->icon(Heroicon::OutlinedAcademicCap)
                        ->color('warning')
                        ->action(fn (Course $record, $livewire): mixed => $livewire->openAssignTeacherModal($record->course_id)),

                    EditAction::make()
                        ->label('Edit'),

                    DeleteAction::make()
                        ->label('Delete'),
                ])
                    ->label('មុខងារ')
                    ->icon(Heroicon::EllipsisVertical)
                    ->button()
                    ->color('primary')
                    ->dropdownWidth('14rem')
                    ->extraAttributes(['class' => 'lc-course-actions'])
                    ->visible(fn (): bool => ! auth()->user()?->isStudent()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])
                    ->visible(fn (): bool => ! auth()->user()?->isStudent()),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
