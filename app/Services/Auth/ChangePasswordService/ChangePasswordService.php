<?php

namespace App\Services\Auth\ChangePasswordService;

use App\Models\User\User\User;

class ChangePasswordService
{
    public function execute(User $user, string $newPassword): bool
    {
        $user->update([
            'password' => $newPassword,
        ]);

        return true;
    }
}
