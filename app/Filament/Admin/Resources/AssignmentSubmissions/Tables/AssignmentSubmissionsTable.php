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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssignmentSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['assignment', 'student.department', 'student.academicYear', 'student.semester']))
            ->columns([
                TextColumn::make('assignment.title')
                    ->label('Assignment')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student.student_code')
                    ->label('Student Code')
                    ->searchable(),
                TextColumn::make('student.first_name')
                    ->label('Student')
                    ->formatStateUsing(fn ($record): string => trim(($record->student?->first_name ?? '').' '.($record->student?->last_name ?? '')))
                    ->searchable(),
                TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('attachment_url')
                    ->label('Document')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? 'Open file' : 'No file')
                    ->url(fn (AssignmentSubmission $record): ?string => $record->attachmentPublicUrl())
                    ->openUrlInNewTab()
                    ->badge()
                    ->color(fn (?string $state): string => filled($state) ? 'info' : 'gray'),
                TextColumn::make('response')
                    ->label('Student Note')
                    ->limit(45)
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('score')
                    ->label('Score')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? $state : 'Not graded')
                    ->sortable(),
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
                        'reviewed' => 'Reviewed',
                        'needs_revision' => 'Needs revision',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                Action::make('open_file')
                    ->label('Open file')
                    ->icon(Heroicon::OutlinedDocumentArrowDown)
                    ->color('info')
                    ->url(fn (AssignmentSubmission $record): ?string => $record->attachmentPublicUrl())
                    ->openUrlInNewTab()
                    ->visible(fn (AssignmentSubmission $record): bool => filled($record->attachment_url)),

                Action::make('grade')
                    ->label('Score')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->color('success')
                    ->modalHeading('Review assignment submission')
                    ->modalSubmitActionLabel('Save score')
                    ->fillForm(fn (AssignmentSubmission $record): array => [
                        'score' => $record->score,
                        'status' => $record->status ?: 'reviewed',
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
                                'reviewed' => 'Reviewed',
                                'needs_revision' => 'Needs revision',
                            ])
                            ->default('reviewed')
                            ->required(),
                        Textarea::make('feedback')
                            ->label('Feedback')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->action(function (AssignmentSubmission $record, array $data): void {
                        $record->update([
                            'score' => $data['score'] ?? null,
                            'status' => $data['status'] ?? 'reviewed',
                            'feedback' => $data['feedback'] ?? null,
                        ]);
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
