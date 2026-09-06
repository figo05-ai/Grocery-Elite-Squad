<?php

namespace App\Http\Controllers\Api\V1\Auth\LogoutController;

use App\Http\Controllers\Controller;
use App\Services\Auth\LogoutUserService\LogoutUserService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use ApiResponse;

    public function __construct(protected LogoutUserService $service) {}

    public function __invoke(Request $request): JsonResponse
    {
        $this->service->execute($request->user());

        return self::successResponse('Logout successfull', [], 200);
    }
}
