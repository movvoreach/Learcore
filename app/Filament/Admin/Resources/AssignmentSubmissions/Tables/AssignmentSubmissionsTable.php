<?php

namespace App\Filament\Admin\Resources\AssignmentSubmissions\Tables;

use App\Models\AssignmentSubmission;
use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Semester;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssignmentSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['assignment.lesson.course', 'student.department', 'student.academicYear', 'student.semester']))
            ->columns([
                TextColumn::make('student_name')
                    ->label('Student')
                    ->getStateUsing(fn (AssignmentSubmission $record): string => trim(($record->student?->first_name ?? '').' '.($record->student?->last_name ?? '')) ?: 'Unknown student')
                    ->description(fn (AssignmentSubmission $record): string => collect([
                        $record->student?->student_code,
                        $record->student?->department?->department_name,
                    ])->filter()->join(' - '))
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->whereHas('student', fn (Builder $query): Builder => $query
                        ->where('student_code', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")))
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query
                        ->join('students as submission_students', 'assignment_submissions.student_id', '=', 'submission_students.student_id')
                        ->orderBy('submission_students.first_name', $direction)
                        ->select('assignment_submissions.*')),

                TextColumn::make('assignment.lesson.course.course_name')
                    ->label('Course')
                    ->limit(34)
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('assignment.title')
                    ->label('Assignment')
                    ->description(fn (AssignmentSubmission $record): string => $record->assignment?->due_at
                        ? 'Due '.$record->assignment->due_at->format('M d, Y')
                        : 'No due date')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('attachment_url')
                    ->label('Document')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? 'File attached' : 'No file')
                    ->url(fn (AssignmentSubmission $record): ?string => $record->attachmentPublicUrl())
                    ->openUrlInNewTab()
                    ->badge()
                    ->color(fn (?string $state): string => filled($state) ? 'info' : 'gray'),

                TextColumn::make('response')
                    ->label('Student Note')
                    ->limit(45)
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'submitted' => 'Submitted',
                        'graded' => 'Graded',
                        'reviewed' => 'Reviewed',
                        'needs_revision' => 'Needs revision',
                        default => 'Submitted',
                    })
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'graded' => 'success',
                        'reviewed' => 'info',
                        'needs_revision' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('score_display')
                    ->label('Score')
                    ->getStateUsing(fn (AssignmentSubmission $record): string => filled($record->score)
                        ? number_format((float) $record->score, 2).' / '.number_format((float) ($record->assignment?->max_score ?? 100), 0)
                        : 'Not graded')
                    ->badge()
                    ->color(fn (AssignmentSubmission $record): string => filled($record->score) ? 'success' : 'gray')
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy('score', $direction)),
            ])
            ->filters([
                SelectFilter::make('student_department_id')
                    ->label('Department')
                    ->options(fn (): array => self::departmentOptions())
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['value'] ?? null,
                        fn (Builder $query, int|string $departmentId): Builder => $query->whereHas('student', fn (Builder $query): Builder => $query
                            ->where('department_id', $departmentId)),
                    ))
                    ->searchable(),
                SelectFilter::make('student_academic_year_id')
                    ->label('Academic Year')
                    ->options(fn (): array => self::academicYearOptions())
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['value'] ?? null,
                        fn (Builder $query, int|string $academicYearId): Builder => $query->whereHas('student', fn (Builder $query): Builder => $query
                            ->where('academic_year_id', $academicYearId)),
                    ))
                    ->searchable(),
                SelectFilter::make('student_semester_id')
                    ->label('Semester')
                    ->options(fn (): array => self::semesterOptions())
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['value'] ?? null,
                        fn (Builder $query, int|string $semesterId): Builder => $query->whereHas('student', fn (Builder $query): Builder => $query
                            ->where('semester_id', $semesterId)),
                    ))
                    ->searchable(),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'submitted' => 'Submitted',
                        'graded' => 'Graded',
                        'reviewed' => 'Reviewed',
                        'needs_revision' => 'Needs revision',
                    ]),
                TernaryFilter::make('has_file')
                    ->label('Submitted file')
                    ->placeholder('All')
                    ->trueLabel('Has file')
                    ->falseLabel('No file')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereNotNull('attachment_url')->where('attachment_url', '!=', ''),
                        false: fn (Builder $query): Builder => $query->where(fn (Builder $query): Builder => $query->whereNull('attachment_url')->orWhere('attachment_url', '')),
                    ),
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(10)
            ->recordActions([
                Action::make('open_file')
                    ->label('File')
                    ->icon(Heroicon::OutlinedDocumentArrowDown)
                    ->color('info')
                    ->url(fn (AssignmentSubmission $record): ?string => $record->attachmentPublicUrl())
                    ->openUrlInNewTab()
                    ->visible(fn (AssignmentSubmission $record): bool => filled($record->attachment_url)),

                Action::make('grade')
                    ->label('Review')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->color('success')
                    ->modalHeading('Review assignment submission')
                    ->modalSubmitActionLabel('Save score')
                    ->fillForm(fn (AssignmentSubmission $record): array => [
                        'score' => $record->score,
                        'status' => $record->status ?: 'graded',
                        'feedback' => $record->feedback,
                    ])
                    ->form([
                        TextInput::make('score')
                            ->label('Score')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(fn (AssignmentSubmission $record): int => (int) ($record->assignment?->max_score ?? 100))
                            ->helperText(fn (AssignmentSubmission $record): string => 'Max score: '.(int) ($record->assignment?->max_score ?? 100)),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'submitted' => 'Submitted',
                                'graded' => 'Graded',
                                'reviewed' => 'Reviewed',
                                'needs_revision' => 'Needs revision',
                            ])
                            ->default('graded')
                            ->required(),
                        Textarea::make('feedback')
                            ->label('Feedback')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->action(function (AssignmentSubmission $record, array $data): void {
                        $record->update([
                            'score' => $data['score'] ?? null,
                            'status' => filled($data['score'] ?? null) ? 'graded' : ($data['status'] ?? 'reviewed'),
                            'feedback' => $data['feedback'] ?? null,
                        ]);

                        $record->refresh()->loadMissing('assignment');
                        $record->publishGradeToStudent(auth()->id());
                    }),

                EditAction::make(),
            ])
            ->defaultSort('submitted_at', 'desc');
    }

    private static function departmentOptions(): array
    {
        return Department::query()
            ->when(self::isTeacherOnly(), fn (Builder $query): Builder => $query->whereIn(
                'department_id',
                self::visibleStudentsQuery()->select('department_id')
            ))
            ->orderBy('department_name')
            ->pluck('department_name', 'department_id')
            ->all();
    }

    private static function academicYearOptions(): array
    {
        return AcademicYear::query()
            ->when(self::isTeacherOnly(), fn (Builder $query): Builder => $query->whereIn(
                'academic_year_id',
                self::visibleStudentsQuery()->select('academic_year_id')
            ))
            ->orderByDesc('start_date')
            ->pluck('year_name', 'academic_year_id')
            ->all();
    }

    private static function semesterOptions(): array
    {
        return Semester::query()
            ->when(self::isTeacherOnly(), fn (Builder $query): Builder => $query->whereIn(
                'semester_id',
                self::visibleStudentsQuery()->select('semester_id')
            ))
            ->orderByDesc('start_date')
            ->pluck('semester_name', 'semester_id')
            ->all();
    }

    private static function visibleStudentsQuery(): Builder
    {
        $user = auth()->user();
        $query = Student::query();

        if (self::isTeacherOnly()) {
            return $user?->teacher
                ? $query->whereIn(
                    'student_id',
                    AssignmentSubmission::query()
                        ->select('student_id')
                        ->whereHas('assignment.lesson.course.courseAssignments', fn (Builder $query): Builder => $query
                            ->where('teacher_id', $user->teacher->teacher_id))
                )
                : $query->whereRaw('1 = 0');
        }

        return $query;
    }

    private static function isTeacherOnly(): bool
    {
        $user = auth()->user();

        return $user?->hasRole('teacher') && ! $user->hasAnyRole(['super_admin', 'admin']);
    }
}
