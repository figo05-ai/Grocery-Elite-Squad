<?php

namespace App\Http\Controllers\Api\V1\User\Favorite\CheckFavoriteController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Models\User\Favorite\Favorite;
use Illuminate\Http\Request;

class CheckFavoriteController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, string $mealId): JsonResponse
    {
        Gate::authorize('viewAny', Favorite::class);

        $user = $request->user();
        $isFavorite = $user->favorites()->where('meal_id', $mealId)->exists();

        return self::successResponse('Favorite status checked', ['is_favorite' => $isFavorite], 200);
    }
}
