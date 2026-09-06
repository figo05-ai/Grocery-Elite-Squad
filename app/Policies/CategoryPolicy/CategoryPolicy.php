<?php

namespace App\Policies\CategoryPolicy;

use App\Models\Catalog\Category\Category;
use App\Models\User\User\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Category $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage catalog');
    }

    public function update(User $user, Category $category): bool
    {
        return $user->hasPermissionTo('manage catalog');
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->hasPermissionTo('manage catalog');
    }
}
