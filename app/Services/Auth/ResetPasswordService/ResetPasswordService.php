<?php

namespace App\Services\Auth\ResetPasswordService;

use App\Exceptions\Auth\UserNotFoundException\UserNotFoundException;
use App\Models\User\User\User;
use App\Services\Auth\OtpService\OtpService;
use Illuminate\Support\Facades\Hash;

class ResetPasswordService
{
    public function __construct(protected OtpService $otpService) {}

    public function execute(string $identifier, string $otp, string $newPassword): bool
    {
        $user = User::findByIdentifier($identifier);

        if (! $user) {
            throw new UserNotFoundException;
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        $this->otpService->verify($identifier, $otp, 'password_reset');
        $user->tokens()->delete();

        return true;
    }
}
