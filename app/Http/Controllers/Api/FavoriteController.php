<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Meal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    /**
     * Get all user's favorite meals
     */
    private function formatMeal(Meal $meal, $favorite = null): array
{
    return [
        'id' => $meal->id,
        'title' => $meal->title,
        'slug' => $meal->slug,
        'description' => $meal->description,
        'image_url' => $meal->image_url,
        'offer_title' => $meal->offer_title,

        ...$meal->getApiPriceAttributes(),

        'has_offer' => $meal->hasOffer(),

        'rating' => (float) $meal->rating,
        'rating_count' => (int) $meal->rating_count,

        'size' => $meal->size,
        'brand' => $meal->brand,

        'stock_quantity' => $meal->stock_quantity,
        'in_stock' => $meal->isInStock(),
        'is_available' => $meal->is_available,
        'is_featured' => $meal->is_featured,

        'category' => [
            'id' => $meal->category->id,
            'name' => $meal->category->name,
            'slug' => $meal->category->slug,
        ],

        'subcategory' => $meal->subcategory ? [
            'id' => $meal->subcategory->id,
            'name' => $meal->subcategory->name,
            'slug' => $meal->subcategory->slug,
        ] : null,

        'is_favorited' => true,
        'favorited_at' => optional($favorite)->created_at,
    ];
}
    private function findMeal(string $mealId): Meal
{
    return Meal::findOrFail($mealId);
}
    private function errorResponse(
    string $message,
    int $status = 500,
    ?string $error = null
): JsonResponse {
    $response = [
        'success' => false,
        'message' => $message,
    ];

    if ($error) {
        $response['error'] = $error;
    }

    return response()->json($response, $status);
}
   public function index(Request $request): JsonResponse
{
    try {
        $user = $request->user();

        $favorites = $user->favorites()
            ->with(['meal.category', 'meal.subcategory'])
            ->latest()
            ->get()
            ->map(fn($favorite) => $this->formatMeal($favorite->meal, $favorite));

        return $this->successResponse(
            'Favorites retrieved successfully',
            [
                'favorites' => $favorites,
                'total_count' => $favorites->count(),
            ]
        );

    } catch (\Exception $e) {
        return $this->errorResponse(
            'Failed to retrieve favorites',
            500,
            $e->getMessage()
        );
    }
}

    /**
     * Toggle favorite status for a meal
     */
    public function toggle(Request $request, string $mealId): JsonResponse
    {
        try {
            $user = $request->user();
            $meal = $this->findMeal($mealId);

      DB::transaction(function () use ($user, $meal, &$isFavorited, &$message) {

    $favorite = $user->favorites()
        ->where('meal_id', $meal->id)
        ->first();

    if ($favorite) {
        $favorite->delete();
        $isFavorited = false;
        $message = 'Removed from favorites';
    } else {
        $user->favorites()->create([
            'meal_id' => $meal->id,
        ]);

        $isFavorited = true;
        $message = 'Added to favorites';
    }

});

          return $this->successResponse(
    $message,
    [
        'meal_id' => $meal->id,
        'is_favorited' => $isFavorited,
    ]
);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
           return $this->errorResponse('Meal not found',404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle favorite',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check if a meal is favorited
     */
    public function check(Request $request, string $mealId): JsonResponse
    {
        try {
            $user = $request->user();
            $meal = $this->findMeal($mealId);

            $isFavorited = $user->favorites()->where('meal_id', $meal->id)->exists();

            return $this->successResponse(
    'Favorite status retrieved successfully',
    [
        'meal_id' => $meal->id,
        'is_favorited' => $isFavorited,
    ]
);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
           return $this->errorResponse('Meal not found',404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check favorite status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove meal from favorites
     */
    public function remove(Request $request, string $mealId): JsonResponse
    {
        try {
            $user = $request->user();
            $meal = $this->findMeal($mealId);

            $deleted = $user->favorites()->where('meal_id', $meal->id)->delete();

            if ($deleted) {
                return $this->successResponse(
    $message,
    [
        'meal_id' => $meal->id,
        'is_favorited' => $isFavorited,
    ]
);
            } else {
                return $this->errorResponse('Meal not found',404);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
           return $this->errorResponse('Meal not found',404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove from favorites',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
private function successResponse(
    string $message,
    array $data = [],
    int $status = 200
): JsonResponse {
    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => $data,
    ], $status);
}
}
