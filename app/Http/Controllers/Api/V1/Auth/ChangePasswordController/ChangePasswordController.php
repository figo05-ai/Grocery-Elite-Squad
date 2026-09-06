<?php

namespace App\Http\Controllers\Api\V1\Auth\ChangePasswordController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest\ChangePasswordRequest;
use App\Services\Auth\ChangePasswordService\ChangePasswordService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;

class ChangePasswordController extends Controller
{
    use ApiResponse;

    public function __construct(protected ChangePasswordService $service) {}

    public function __invoke(ChangePasswordRequest $request): JsonResponse
    {
        $this->service->execute($request->user(), $request->input('password'));

        return self::successResponse('Password changed successfully', [], 200);
    }
}
