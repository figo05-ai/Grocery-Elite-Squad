<?php

namespace App\Policies\OrderPolicy;

use App\Models\Order\Order\Order;
use App\Models\User\User\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view all orders') 
            || $user->hasPermissionTo('view own orders') 
            || $user->hasPermissionTo('view assigned orders');
    }

    public function view(User $user, Order $order): bool
    {
        if ($user->hasPermissionTo('view all orders')) {
            return true;
        }

        if ($user->hasPermissionTo('view assigned orders') && $order->driver_id === $user->id) {
            return true;
        }

        return $user->hasPermissionTo('view own orders') && $order->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('place orders');
    }

    public function update(User $user, Order $order): bool
    {
        if ($user->hasPermissionTo('manage orders')) {
            return true;
        }

        return $user->hasPermissionTo('update assigned orders') && $order->driver_id === $user->id;
    }
}
