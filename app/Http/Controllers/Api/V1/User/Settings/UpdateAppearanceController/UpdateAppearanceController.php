<?php

namespace App\Http\Controllers\Api\V1\User\Settings\UpdateAppearanceController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateAppearanceController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $request->validate(['theme' => 'required|string|in:light,dark']);
        $request->user()->update(['app_theme' => $request->input('theme')]);

        return self::successResponse('Appearance updated successfully', ['theme' => $request->input('theme')], 200);
    }
}
