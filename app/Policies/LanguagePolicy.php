<?php

namespace App\Policies;

use App\Models\Language;
use App\Models\User;

class LanguagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('language.view');
    }

    public function view(User $user, Language $language): bool
    {
        return $user->can('language.view');
    }

    public function create(User $user): bool
    {
        return $user->can('language.create');
    }

    public function update(User $user, Language $language): bool
    {
        return $user->can('language.update');
    }

    public function delete(User $user, Language $language): bool
    {
        return $user->can('language.delete') && ! $language->is_default;
    }
}
