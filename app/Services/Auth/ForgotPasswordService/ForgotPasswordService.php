<?php

namespace App\Services\Auth\ForgotPasswordService;

use App\Exceptions\Auth\UserNotFoundException\UserNotFoundException;
use App\Models\User\User\User;
use App\Services\Auth\OtpService\OtpService;
use App\Services\System\NotificationService\NotificationService;

class ForgotPasswordService
{
    public function __construct(
        protected OtpService $otpService,
        protected NotificationService $notificationService
    ) {}

    public function execute(string $identifier): bool
    {
        $user = User::findByIdentifier($identifier);

        if (! $user) {
            throw new UserNotFoundException;
        }

        $otp = $this->otpService->generate($identifier, 'password_reset');

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $this->notificationService->sendOtpEmail($identifier, $otp, 'password_reset');
        } else {
            $this->notificationService->sendOtpSms($identifier, $otp, 'password_reset');
        }

        return true;
    }
}
