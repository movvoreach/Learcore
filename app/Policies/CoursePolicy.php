<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']) ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['teacher', 'student']);
    }

    public function view(User $user, Course $course): bool
    {
        $student = $user->student;

        if (! $user->isStudent() || ! $student) {
            return $user->hasRole('teacher');
        }

        return $course->department_id === $student->department_id
            && $course->academic_year_id === $student->academic_year_id
            && $course->semester_id === $student->semester_id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin', 'teacher']);
    }

    public function update(User $user, Course $course): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin', 'teacher']);
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']);
    }
}
