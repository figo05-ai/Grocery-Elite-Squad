<?php

namespace App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;

use App\Exceptions\Auth\UserNotFoundException\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest\ForgotPasswordRequest;
use App\Services\Auth\ForgotPasswordService\ForgotPasswordService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
{
    use ApiResponse;

    public function __construct(protected ForgotPasswordService $service) {}

    public function __invoke(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $this->service->execute($request->input('identifier'));

            return self::successResponse('OTP sent successfully . Please check your email', [], 200);
        } catch (UserNotFoundException $e) {
            return self::errorResponse('Failed to send OTP', ['identifier' => [$e->getMessage()]], 404);
        }
    }
}
