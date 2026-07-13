<?php

namespace App\Policies;

use App\Models\Translation;
use App\Models\User;

class TranslationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('translation.view');
    }

    public function view(User $user, Translation $translation): bool
    {
        return $user->can('translation.view');
    }

    public function create(User $user): bool
    {
        return $user->can('translation.update');
    }

    public function update(User $user, Translation $translation): bool
    {
        return $user->can('translation.update');
    }

    public function delete(User $user, Translation $translation): bool
    {
        return $user->can('translation.update');
    }
}
