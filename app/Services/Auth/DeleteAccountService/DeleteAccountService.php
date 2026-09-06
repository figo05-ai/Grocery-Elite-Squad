<?php

namespace App\Services\Auth\DeleteAccountService;

use App\Models\User\User\User;

class DeleteAccountService
{
    public function execute(User $user): bool
    {
        $user->delete();
        $user->tokens()->delete();

        return true;
    }
}
