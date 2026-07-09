<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Course extends Model
{
    protected $primaryKey = 'course_id';

    protected $fillable = [
        'course_category_id',
        'department_id',
        'academic_year_id',
        'semester_id',
        'course_code',
        'course_name',
        'description',
        'visibility',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id', 'course_category_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'academic_year_id');
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'semester_id');
    }

    public function scopeAvailableToStudent(Builder $query, Student $student): Builder
    {
        return $query
            ->where('department_id', $student->department_id)
            ->where('academic_year_id', $student->academic_year_id)
            ->where('semester_id', $student->semester_id);
    }

    public function scopeEnrolledByStudent(Builder $query, Student $student): Builder
    {
        return $query->whereHas(
            'enrollments',
            fn (Builder $query): Builder => $query->where('student_id', $student->student_id)
        );
    }

    public function scopePublicCourses(Builder $query): Builder
    {
        return $query->where('visibility', 'public');
    }

    public function scopeVisibleOnFrontend(Builder $query, ?User $user = null): Builder
    {
        $student = $user?->isStudent() ? $user->student : null;

        if (! $student) {
            return $query->publicCourses();
        }

        return $query->where(function (Builder $query) use ($student): void {
            $query
                ->publicCourses()
                ->orWhere(fn (Builder $query): Builder => $query->enrolledByStudent($student));
        });
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'course_id', 'course_id');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class, 'course_id', 'course_id');
    }

    public function contentLessons(): HasMany
    {
        return $this->hasMany(ContentLesson::class, 'course_id', 'course_id');
    }

    public function classRooms(): HasMany
    {
        return $this->hasMany(ClassRoom::class, 'course_id', 'course_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'course_id', 'course_id');
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(StudentProgress::class, 'course_id', 'course_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'course_id', 'course_id');
    }

    public function courseAssignments(): HasMany
    {
        return $this->hasMany(CourseAssignment::class, 'course_id', 'course_id');
    }

    public function instructor(): HasOneThrough
    {
        return $this->hasOneThrough(
            Teacher::class,
            CourseAssignment::class,
            'course_id',
            'teacher_id',
            'course_id',
            'teacher_id'
        );
    }

    public function teacherSchedules(): HasMany
    {
        return $this->hasMany(TeacherSchedule::class, 'course_id', 'course_id');
    }

    public function discussionPosts(): HasMany
    {
        return $this->hasMany(DiscussionPost::class, 'course_id', 'course_id');
    }
}
