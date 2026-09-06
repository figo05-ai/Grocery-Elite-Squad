<?php

namespace App\Http\Controllers\Api\V1\User\Profile\UpdateProfileImageController;

use App\Http\Controllers\Controller;
use App\Services\User\Profile\ProfileImageService\ProfileImageService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateProfileImageController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $service = app(ProfileImageService::class);
        $user = $service->update($request->user(), $request->file('image'));

        return self::successResponse('Profile image updated successfully', [
            'profile_image' => $user->profile_image,
            'profile_image_url' => $user->profile_image_url,
        ]);
    }
}
