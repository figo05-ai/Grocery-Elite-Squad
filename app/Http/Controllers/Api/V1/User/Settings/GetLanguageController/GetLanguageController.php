<?php

namespace App\Http\Controllers\Api\V1\User\Settings\GetLanguageController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetLanguageController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $language = $request->user()->app_language ?? 'en';

        return self::successResponse('Language retrieved successfully', ['language' => $language], 200);
    }
}
