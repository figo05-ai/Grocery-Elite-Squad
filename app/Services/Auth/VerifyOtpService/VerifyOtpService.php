<?php

namespace App\Services\Auth\VerifyOtpService;

use App\Services\Auth\OtpService\OtpService;

class VerifyOtpService
{
    public function __construct(protected OtpService $otpService) {}

    public function execute(string $identifier, string $otp): bool
    {
        return $this->otpService->verify($identifier, $otp, 'password_reset');
    }
}
