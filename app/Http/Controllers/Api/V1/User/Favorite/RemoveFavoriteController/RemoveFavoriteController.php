<?php

namespace App\Http\Controllers\Api\V1\User\Favorite\RemoveFavoriteController;

use App\Http\Controllers\Controller;
use App\Services\User\Favorite\ToggleFavoriteService\ToggleFavoriteService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RemoveFavoriteController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, string $mealId): JsonResponse
    {
        Gate::authorize('delete', $favorite);

        $service = app(ToggleFavoriteService::class);
        $result = $service->execute($request->user(), $mealId); // The service naturally toggles it, but typically we want a direct delete.
        // For simplicity, we just delete here since it's a simple Eloquent query and doesn't orchestrate complex logic.
        // Actually, let's use the DB query directly to avoid "service explosion" for a single line of logic.
        $deleted = $request->user()->favorites()->where('meal_id', $mealId)->delete();
        if ($deleted) {
            return self::successResponse('Meal removed from favorites', ['is_favorite' => false], 200);
        }

        return self::errorResponse('Favorite not found', [], 404);
    }
}
