<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']) ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('teacher');
    }

    public function view(User $user, Student $student): bool
    {
        return $user->hasRole('teacher') || $user->student?->is($student);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']);
    }

    public function update(User $user, Student $student): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']);
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']);
    }
}
