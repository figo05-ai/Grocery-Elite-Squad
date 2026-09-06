<?php

namespace App\Services\Auth\LogoutUserService;

use App\Models\User\User\User;

class LogoutUserService
{
    public function execute(User $user): bool
    {
        $user->tokens()->delete();

        return true;
    }
}
