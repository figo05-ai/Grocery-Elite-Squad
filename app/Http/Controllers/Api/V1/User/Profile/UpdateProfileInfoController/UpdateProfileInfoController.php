<?php

namespace App\Http\Controllers\Api\V1\User\Profile\UpdateProfileInfoController;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\UpdateProfileInfoRequest\UpdateProfileInfoRequest;
use App\Services\User\Profile\UpdateProfileInfoService\UpdateProfileInfoService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;

class UpdateProfileInfoController extends Controller
{
    use ApiResponse;

    public function __invoke(UpdateProfileInfoRequest $request): JsonResponse
    {
        $service = app(UpdateProfileInfoService::class);
        $user = $service->execute($request->user(), $request->validated());

        return self::successResponse('Profile updated successfully', [
            'id' => $user->id,
            'username' => $user->username,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'full_name' => $user->full_name,
            'phone' => $user->phone,
        ]);
    }
}
