<?php

namespace App\Policies\CartPolicy;

use App\Models\Cart\Cart\Cart;
use App\Models\User\User\User;

class CartPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id;
    }

    public function delete(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id;
    }
}
