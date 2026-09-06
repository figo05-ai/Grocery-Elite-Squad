<?php

namespace App\Http\Controllers\Api\V1\Auth\MeController;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\MeResource\MeResource;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        return self::successResponse('Profile fetched successfully', new MeResource($request->user()), 200);
    }
}
