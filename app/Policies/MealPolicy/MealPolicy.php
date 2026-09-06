<?php

namespace App\Policies\MealPolicy;

use App\Models\Catalog\Meal\Meal;
use App\Models\User\User\User;

class MealPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Meal $meal): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage catalog');
    }

    public function update(User $user, Meal $meal): bool
    {
        return $user->hasPermissionTo('manage catalog');
    }

    public function delete(User $user, Meal $meal): bool
    {
        return $user->hasPermissionTo('manage catalog');
    }
}
