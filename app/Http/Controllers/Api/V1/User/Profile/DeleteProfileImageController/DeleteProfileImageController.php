<?php

namespace App\Http\Controllers\Api\V1\User\Profile\DeleteProfileImageController;

use App\Http\Controllers\Controller;
use App\Services\User\Profile\ProfileImageService\ProfileImageService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteProfileImageController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $service = app(ProfileImageService::class);
        $success = $service->delete($request->user());

        if (! $success) {
            return self::errorResponse('No profile image to delete', [], 404);
        }

        return self::successResponse('Profile image deleted successfully');
    }
}
