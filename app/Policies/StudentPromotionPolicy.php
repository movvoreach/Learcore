<?php

namespace App\Policies;

use App\Models\StudentPromotion;
use App\Models\User;

class StudentPromotionPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']) ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage promotions');
    }

    public function view(User $user, StudentPromotion $studentPromotion): bool
    {
        return $user->hasPermissionTo('manage promotions');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage promotions');
    }

    public function update(User $user, StudentPromotion $studentPromotion): bool
    {
        return $user->hasPermissionTo('manage promotions');
    }

    public function delete(User $user, StudentPromotion $studentPromotion): bool
    {
        return $user->hasPermissionTo('manage promotions');
    }
}
