<?php

namespace App\Http\Controllers\Api\V1\User\Favorite\GetFavoritesController;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Favorite\FavoriteResource\FavoriteResource;
use App\Models\User\Favorite\Favorite;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GetFavoritesController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        Gate::authorize('viewAny', Favorite::class);

        $user = $request->user();
        $favorites = $user->favorites()->with(['meal.category', 'meal.subcategory'])->orderBy('created_at', 'desc')->get();

        return self::successResponse('Favorites retrieved successfully', [
            'favorites' => FavoriteResource::collection($favorites),
        ], 200);
    }
}
