<?php

namespace App\Http\Controllers\Api\V1\Auth\VerifyOtpController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyOtpRequest\VerifyOtpRequest;
use App\Services\Auth\VerifyOtpService\VerifyOtpService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;

class VerifyOtpController extends Controller
{
    use ApiResponse;

    public function __construct(protected VerifyOtpService $service) {}

    public function __invoke(VerifyOtpRequest $request): JsonResponse
    {
        $isValid = $this->service->execute($request->input('identifier'), $request->input('otp'));
        if (! $isValid) {
            return self::errorResponse('Invalid or expired OTP', [], 400);
        }

        return self::successResponse('OTP verified successfully', [], 200);
    }
}
