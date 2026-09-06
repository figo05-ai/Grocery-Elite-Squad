<?php

namespace App\Http\Controllers\Api\V1\User\Settings\UpdateLanguageController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateLanguageController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $request->validate(['language' => 'required|string|in:en,ar']);
        $request->user()->update(['app_language' => $request->input('language')]);

        return self::successResponse('Language updated successfully', ['language' => $request->input('language')], 200);
    }
}
