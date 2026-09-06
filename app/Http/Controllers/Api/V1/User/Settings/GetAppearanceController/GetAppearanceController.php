<?php

namespace App\Http\Controllers\Api\V1\User\Settings\GetAppearanceController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetAppearanceController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $theme = $request->user()->app_theme ?? 'light';

        return self::successResponse('Appearance retrieved successfully', ['theme' => $theme], 200);
    }
}
