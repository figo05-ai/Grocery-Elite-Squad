<?php

namespace App\Policies\FavoritePolicy;

use App\Models\User\User\User;

class FavoritePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, User\Favorite\Favorite $favorite): bool
    {
        return $user->id === $favorite->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, User\Favorite\Favorite $favorite): bool
    {
        return $user->id === $favorite->user_id;
    }

    public function delete(User $user, User\Favorite\Favorite $favorite): bool
    {
        return $user->id === $favorite->user_id;
    }
}
