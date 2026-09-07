<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\MealResource;
use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Services\FrequencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Services\MealService;

class MealController extends Controller
{
    public function __construct(
    private readonly FrequencyService $frequencyService,
    private readonly MealService $mealService,
) {}
    
    /**
     * Get meals the authenticated user orders most often (personalized by frequency type).
     * Query param: frequency_type = daily|weekly|monthly (default: weekly).
     */
    public function frequency(Request $request): JsonResponse
    {
        try {
            $frequencyType = $request->input('frequency_type', FrequencyService::FREQUENCY_WEEKLY);
            if (! in_array($frequencyType, FrequencyService::VALID_TYPES, true)) {
                $frequencyType = FrequencyService::FREQUENCY_WEEKLY;
            }

            $user = $request->user();
            if ($user === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required to view frequency meals.',
                ], 401);
            }

            $subcategoryId = $request->input('subcategory_id');
            $subcategoryId = is_numeric($subcategoryId) ? (int) $subcategoryId : null;

            $meals = $this->frequencyService->getFrequentlyOrderedMeals(
    $user,
    $frequencyType,
    50,
    $subcategoryId
);
            $data = $meals->map(function ($meal) {
                return [
                    'id' => $meal->id,
                    'title' => $meal->title,
                    'slug' => $meal->slug,
                    'description' => $meal->description,
                    'image_url' => $meal->image_url,
                    'offer_title' => $meal->offer_title,
                    ...$meal->getApiPriceAttributes(),
                    'has_offer' => $meal->hasOffer(),
                    'category' => $meal->category ? [
                        'id' => $meal->category->id,
                        'name' => $meal->category->name,
                    ] : null,
                    'subcategory' => $meal->subcategory ? [
                        'id' => $meal->subcategory->id,
                        'name' => $meal->subcategory->name,
                    ] : null,
                    'features' => $meal->features,
                    'available_date' => $meal->available_date,
                    'created_at' => $meal->created_at,
                    'order_count' => (int) $meal->getAttribute('order_count'),
                ];
            })->values();

            $payload = [
                'success' => true,
                'message' => 'Frequency meals retrieved successfully',
                'frequency_type' => $frequencyType,
                'data' => $data,
            ];
            if ($subcategoryId !== null) {
                $payload['subcategory_id'] = $subcategoryId;
            }

            return response()->json($payload);
        } catch (Throwable $e) {
            Log::error('Frequency meals error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load frequency meals',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    public function moreToExplore(Request $request): JsonResponse
{
    $meals = $this->mealService->moreToExplore();

    return response()->json([
        'success' => true,
        'message' => 'More to explore retrieved successfully',
        'data' => MealResource::collection($meals),
    ]);
}

  public function brands(Request $request): JsonResponse
{
    $brands = $this->mealService->brands();

    return response()->json([
        'success' => true,
        'message' => 'Brands retrieved successfully',
        'data' => $brands,
    ]);
}

 public function slider(Request $request): JsonResponse
{
    $meals = $this->mealService->sliderMeals();

    return response()->json([
        'success' => true,
        'message' => "Today's meals retrieved successfully",
        'data' => MealResource::collection($meals),
    ]);
}

   public function bestSells(Request $request): JsonResponse
{
    $meals = $this->mealService->bestSells();

    return response()->json([
        'success' => true,
        'message' => 'Best sells retrieved successfully',
        'data' => MealResource::collection($meals),
    ]);
}

  public function newProducts(Request $request): JsonResponse
{
    try {

        $meals = $this->mealService->newProducts();

        return response()->json([
            'success' => true,
            'message' => 'New products retrieved successfully',
            'data' => MealResource::collection($meals),
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Failed to retrieve meals',
            'error' => $e->getMessage(),
        ],500);

    }
}

    /**
     * Get hot / Ready-to-eat meals only.
     */
  public function hot(Request $request): JsonResponse
{
    try {

        $meals = $this->mealService->hotMeals();

        return response()->json([
            'success' => true,
            'message' => 'Hot meals retrieved successfully',
            'data' => MealResource::collection($meals),
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Failed to retrieve hot meals',
            'error' => $e->getMessage(),
        ],500);

    }
}
    /**
     * Get today's deals (meals with active discounts)
     */
public function today(Request $request): JsonResponse
{
    try {

        $meals = $this->mealService->todayDeals();

        return response()->json([
            'success' => true,
            'message' => "Today's deals retrieved successfully",
            'data' => MealResource::collection($meals),
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => "Failed to retrieve today's deals",
            'error' => $e->getMessage(),
        ],500);

    }
}

    /**
     * Get all meals
     */
   public function index(Request $request): JsonResponse
{
    try {

        $meals = $this->mealService->allMeals($request);

        return response()->json([
            'success' => true,
            'message' => 'Meals retrieved successfully',
            'data' => MealResource::collection($meals),
            'total_count' => $meals->count(),
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Failed to retrieve meals',
            'error' => $e->getMessage(),
        ],500);

    }
}

    /**
     * Get recommended meals
     */
    public function recommendations(Request $request): JsonResponse
    {
        try {
            $limit = $request->input('limit', 10);

            // Get featured meals with offers
            $featuredMeals = Meal::with('category')
                ->available()
                ->featured()
                ->whereNotNull('discount_price')
                ->inRandomOrder()
                ->limit(ceil($limit / 2))
                ->get();

            // Get random meals from different categories
            $randomMeals = Meal::with('category')
                ->available()
                ->whereNotIn('id', $featuredMeals->pluck('id'))
                ->inRandomOrder()
                ->limit($limit - $featuredMeals->count())
                ->get();

            // Combine and shuffle
            $recommendations = $featuredMeals->merge($randomMeals)->shuffle()->take($limit);

            $meals = $recommendations->map(function ($meal) {
                return [
                    'id' => $meal->id,
                    'title' => $meal->title,
                    'slug' => $meal->slug,
                    'description' => $meal->description,
                    'image_url' => $meal->image_url,
                    'offer_title' => $meal->offer_title,
                    ...$meal->getApiPriceAttributes(),
                    'has_offer' => $meal->hasOffer(),
                    'is_featured' => $meal->is_featured,
                    'category' => [
                        'id' => $meal->category->id,
                        'name' => $meal->category->name,
                        'slug' => $meal->category->slug,
                    ],
                    'features' => $meal->features,
                    'recommendation_reason' => $this->getRecommendationReason($meal),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Meal recommendations retrieved successfully',
                'data' => $meals->values(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve recommendations',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get recommendation reason for a meal
     */
    private function getRecommendationReason($meal): string
    {
        if ($meal->is_featured && $meal->discount_price) {
            return 'Featured with special offer';
        }

        if ($meal->is_featured) {
            return 'Featured meal';
        }

        if ($meal->discount_price) {
            return 'Special offer';
        }

        return 'Popular choice';
    }

    /**
     * Get single meal
     */
    public function show(string $id): JsonResponse
    {
        try {
            $meal = Meal::with([
                'category',
                'subcategory',
                'reviews' => fn ($q) => $q->approved()->with('user:id,username,firstname,lastname')->orderBy('created_at', 'desc'),
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Meal retrieved successfully',
                'data' => [
                    'id' => $meal->id,
                    'title' => $meal->title,
                    'slug' => $meal->slug,
                    'description' => $meal->description,
                    'image_url' => $meal->image_url,
                    'offer_title' => $meal->offer_title,

                    // Pricing
                    ...$meal->getApiPriceAttributes(),
                    'has_offer' => $meal->hasOffer(),

                    // Rating
                    'rating' => (float) $meal->rating,
                    'rating_count' => (int) $meal->rating_count,

                    // Product details
                    'size' => $meal->size,
                    'brand' => $meal->brand,
                    'includes' => $meal->includes,
                    'how_to_use' => $meal->how_to_use,
                    'features' => $meal->features,

                    // Expiry and availability
                    'expiry_date' => $meal->expiry_date,
                    'days_until_expiry' => $meal->daysUntilExpiry(),
                    'is_expired' => $meal->isExpired(),

                    // Stock
                    'stock_quantity' => $meal->stock_quantity,
                    'in_stock' => $meal->isInStock(),
                    'sold_count' => $meal->sold_count,

                    // Status
                    'is_featured' => $meal->is_featured,
                    'is_available' => $meal->is_available,
                    'available_date' => $meal->available_date,

                    // Relationships
                    'category' => [
                        'id' => $meal->category->id,
                        'name' => $meal->category->name,
                        'slug' => $meal->category->slug,
                    ],
                    'reviews' => $meal->reviews->map(function ($review) {
                        return [
                            'id' => $review->id,
                            'user' => $review->relationLoaded('user') && $review->user ? [
                                'id' => $review->user->id,
                                'name' => $review->user->full_name ?? $review->user->username ?? 'User',
                            ] : null,
                            'rating' => (int) $review->rating,
                            'comment' => $review->comment,
                            'images' => $review->images ?? [],
                            'created_at' => $review->created_at?->toIso8601String(),
                        ];
                    })->values(),
                    'subcategory' => $meal->subcategory ? [
                        'id' => $meal->subcategory->id,
                        'name' => $meal->subcategory->name,
                        'slug' => $meal->subcategory->slug,
                    ] : null,

                    'created_at' => $meal->created_at,
                    'updated_at' => $meal->updated_at,
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Meal not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve meal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
