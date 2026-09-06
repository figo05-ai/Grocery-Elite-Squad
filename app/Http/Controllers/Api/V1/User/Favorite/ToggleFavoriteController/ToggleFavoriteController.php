<?php

namespace App\Http\Controllers\Api\V1\User\Favorite\ToggleFavoriteController;

use App\Http\Controllers\Controller;
use App\Models\User\Favorite\Favorite;
use App\Services\User\Favorite\ToggleFavoriteService\ToggleFavoriteService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ToggleFavoriteController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        Gate::authorize('create', Favorite::class);

        $request->validate(['meal_id' => 'required|exists:meals,id']);
        $mealId = $request->input('meal_id');

        $service = app(ToggleFavoriteService::class);
        $result = $service->execute($request->user(), $mealId);

        return self::successResponse($result['message'], ['is_favorite' => $result['is_favorite']], 200);
    }
}
