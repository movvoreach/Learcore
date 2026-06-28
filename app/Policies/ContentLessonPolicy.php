<?php

namespace App\Policies;

use App\Models\ContentLesson;
use App\Models\User;

class ContentLessonPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']) ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['teacher', 'student']);
    }

    public function view(User $user, ContentLesson $contentLesson): bool
    {
        if ($user->hasRole('teacher')) {
            return true;
        }

        $student = $user->student;

        if (! $user->isStudent() || ! $student || ! $contentLesson->course) {
            return false;
        }

        return $contentLesson->is_published
            && $this->lessonIsVisibleNow($contentLesson)
            && $contentLesson->course->department_id === $student->department_id
            && $contentLesson->course->academic_year_id === $student->academic_year_id
            && $contentLesson->course->semester_id === $student->semester_id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin', 'teacher']);
    }

    public function update(User $user, ContentLesson $contentLesson): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin', 'teacher']);
    }

    public function delete(User $user, ContentLesson $contentLesson): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']);
    }

    private function lessonIsVisibleNow(ContentLesson $contentLesson): bool
    {
        if ($contentLesson->visibility === 'visible') {
            return true;
        }

        if ($contentLesson->visibility !== 'scheduled') {
            return false;
        }

        return ($contentLesson->available_from === null || $contentLesson->available_from <= now())
            && ($contentLesson->available_until === null || $contentLesson->available_until >= now());
    }
}
