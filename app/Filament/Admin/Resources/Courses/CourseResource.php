<?php

namespace App\Filament\Admin\Resources\Courses;

use App\Filament\Admin\Resources\Courses\Pages\CreateCourse;
use App\Filament\Admin\Resources\Courses\Pages\EditCourse;
use App\Filament\Admin\Resources\Courses\Pages\ListCourses;
use App\Filament\Admin\Resources\Courses\Schemas\CourseForm;
use App\Filament\Admin\Resources\Courses\Tables\CoursesTable;
use App\Models\Course;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'course';

    protected static ?string $modelLabel = 'វគ្គសិក្សា';

    protected static ?string $pluralModelLabel = 'វគ្គសិក្សា';

    protected static string|\UnitEnum|null $navigationGroup = 'គ្រប់គ្រងការសិក្សា';

    protected static ?int $navigationSort = 40;

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'មាតិកាសិក្សា';
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return new HtmlString('<img src="'.e(asset('Icons/courses.png')).'" alt="" class="fi-sidebar-item-icon" />');
    }

    public static function form(Schema $schema): Schema
    {
        return CourseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoursesTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['category', 'department', 'academicYear', 'semester', 'courseAssignments.teacher'])
            ->withCount([
                'contentLessons as published_lessons_count' => fn (Builder $query): Builder => $query->publishedForStudents(),
            ]);
        $student = auth()->user()?->student;

        if (auth()->user()?->isStudent() && $student) {
            $query->withAggregate([
                'progresses as student_progress_percent' => fn (Builder $query): Builder => $query
                    ->where('student_id', $student->student_id),
            ], 'progress_percent');
        }

        if (auth()->user()?->isStudent()) {
            return $student
                ? $query->enrolledByStudent($student)
                : $query->whereRaw('1 = 0');
        }

        $user = auth()->user();

        if ($user?->hasRole('teacher') && ! $user->hasAnyRole(['super_admin', 'admin'])) {
            return $user->teacher
                ? $query->whereHas('courseAssignments', fn (Builder $query): Builder => $query
                    ->where('teacher_id', $user->teacher->teacher_id))
                : $query->whereRaw('1 = 0');
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourses::route('/'),
            'create' => CreateCourse::route('/create'),
            'edit' => EditCourse::route('/{record}/edit'),
        ];
    }
}
