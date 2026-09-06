<?php

namespace App\Services\Auth\LoginUserService;

use App\Exceptions\Auth\InvalidCredentialsException\InvalidCredentialsException;
use App\Exceptions\Auth\UserDeactivatedException\UserDeactivatedException;
use App\Exceptions\Auth\UserNotFoundException\UserNotFoundException;
use App\Models\User\User\User;
use Illuminate\Support\Facades\Hash;

class LoginUserService
{
    public function execute(string $identifier, string $password): array
    {
        $user = User::findByIdentifier($identifier);

        if (! $user) {
            throw new UserNotFoundException('Unable to sign in. Please try again.', 401);
        }

        if (! Hash::check($password, $user->password)) {
            throw new InvalidCredentialsException('The password you entered is incorrect.', 401);
        }

        if (! $user->is_active) {
            throw new UserDeactivatedException('Your account has been deactivated.', 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
