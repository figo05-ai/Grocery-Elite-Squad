<?php

namespace App\Http\Controllers\Api\V1\Auth\ResetPasswordController;

use App\Exceptions\Auth\UserNotFoundException\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService\ResetPasswordService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    use ApiResponse;

    public function __construct(protected ResetPasswordService $service) {}

    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $this->service->execute($request->input('identifier'), $request->input('otp'), $request->input('password'));

            return self::successResponse('Password reset successfully', [], 200);
        } catch (UserNotFoundException $e) {
            return self::errorResponse('Password reset failed', ['identifier' => [$e->getMessage()]], 404);
        }
    }
}
