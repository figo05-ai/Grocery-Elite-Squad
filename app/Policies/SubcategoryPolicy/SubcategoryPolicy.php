<?php

namespace App\Policies\SubcategoryPolicy;

use App\Models\User\User\User;

class SubcategoryPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Catalog\Subcategory\Subcategory $subcategory): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage catalog');
    }

    public function update(User $user, Catalog\Subcategory\Subcategory $subcategory): bool
    {
        return $user->hasPermissionTo('manage catalog');
    }

    public function delete(User $user, Catalog\Subcategory\Subcategory $subcategory): bool
    {
        return $user->hasPermissionTo('manage catalog');
    }
}
