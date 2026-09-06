<?php

namespace App\Http\Controllers\Api\V1\Auth\RegisterController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest\RegisterRequest;
use App\Http\Resources\Auth\AuthResource\AuthResource;
use App\Services\Auth\RegisterUserService\RegisterUserService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    use ApiResponse;

    public function __construct(protected RegisterUserService $service) {}

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $result = $this->service->execute($request->validated());

        return self::successResponse('Registration successful', new AuthResource($result), 201);
    }
}
