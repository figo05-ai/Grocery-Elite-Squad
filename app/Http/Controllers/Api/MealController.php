<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MealDetailResource;
use App\Http\Resources\Api\MealResource;
use App\Models\Meal;
use App\Services\FrequencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class MealController extends Controller
{
    public function __construct(
        protected FrequencyService $frequencyService,
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

            $meals = $this->frequencyService->getFrequentlyOrderedMeals($user, $frequencyType, 50, $subcategoryId);

            $data = $meals->map(function ($meal) {
                // Null-safe category: frequency() is the only endpoint where
                // category may legitimately be absent on a returned meal.
                $category = $meal->category
                    ? ['id' => $meal->category->id, 'name' => $meal->category->name]
                    : null;

                return new MealResource($meal, [
                    'subcategory' => $meal->subcategory ? [
                        'id'   => $meal->subcategory->id,
                        'name' => $meal->subcategory->name,
                    ] : null,
                    'available_date' => $meal->available_date,
                    'created_at'     => $meal->created_at,
                    'order_count'    => (int) $meal->getAttribute('order_count'),
                ], $category);
            })->values();

            $payload = [
                'success'        => true,
                'message'        => 'Frequency meals retrieved successfully',
                'frequency_type' => $frequencyType,
                'data'           => $data,
            ];
            if ($subcategoryId !== null) {
                $payload['subcategory_id'] = $subcategoryId;
            }

            return response()->json($payload);
        } catch (Throwable $e) {
            Log::error('Frequency meals error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load frequency meals',
                'error'   => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    public function moreToExplore(Request $request)
    {
        $meals = Meal::with('category')
            ->available()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'More to explore retrieved successfully',
            'data'    => $meals,
        ]);
    }

    public function brands(Request $request)
    {
        $brands = Meal::distinct()->pluck('brand');

        return response()->json([
            'success' => true,
            'message' => 'Brands retrieved successfully',
            'data'    => $brands,
        ]);
    }

    public function slider(Request $request)
    {
        $meals = Meal::with('category')
            ->available()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($meal) => new MealResource($meal, [
                'available_date' => $meal->available_date,
                'created_at'     => $meal->created_at,
            ]));

        return response()->json([
            'success' => true,
            'message' => 'Today\'s meals retrieved successfully',
            'data'    => $meals,
        ]);
    }

    public function bestSells(Request $request)
    {
        $meals = Meal::with('category')
            ->available()
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Best sells retrieved successfully',
            'data'    => $meals,
        ]);
    }

    public function newProducts(Request $request)
    {
        try {
            $meals = Meal::with('category')
                ->available()
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'New products retrieved successfully',
                'data'    => $meals,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve meals',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get hot / Ready-to-eat meals only.
     */
    public function hot(Request $request): JsonResponse
    {
        try {
            $meals = Meal::with('category')
                ->available()
                ->hot()
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($meal) => new MealResource($meal, [
                    'rating'         => (float) $meal->rating,
                    'rating_count'   => (int) $meal->rating_count,
                    'brand'          => $meal->brand,
                    'stock_quantity' => (int) $meal->stock_quantity,
                    'in_stock'       => $meal->isInStock(),
                    'available_date' => $meal->available_date,
                    'created_at'     => $meal->created_at,
                ]));

            return response()->json([
                'success' => true,
                'message' => 'Hot meals retrieved successfully',
                'data'    => $meals,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve hot meals',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get today's deals (meals with active discounts)
     */
    public function today(Request $request): JsonResponse
    {
        try {
            $meals = Meal::with('category')
                ->available()
                ->withActiveDiscount()
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($meal) => new MealResource($meal, [
                    'rating'         => (float) $meal->rating,
                    'rating_count'   => (int) $meal->rating_count,
                    'brand'          => $meal->brand,
                    'stock_quantity' => (int) $meal->stock_quantity,
                    'in_stock'       => $meal->isInStock(),
                    'available_date' => $meal->available_date,
                    'created_at'     => $meal->created_at,
                ]));

            return response()->json([
                'success' => true,
                'message' => 'Today\'s deals retrieved successfully',
                'data'    => $meals,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve today\'s deals',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $user  = $request->user();
            $query = Meal::with(['category', 'subcategory'])->available()->filter($request);

            // SORTING (sort_by: created_at|price|rating|title|sold_count|newest, sort_order: asc|desc)
            $sortBy    = $request->input('sort_by', 'created_at');
            $sortOrder = strtolower($request->input('sort_order', 'desc')) === 'asc' ? 'asc' : 'desc';
            if ($sortBy === 'newest') {
                $sortBy    = 'created_at';
                $sortOrder = 'desc';
            }
            $allowedSortFields = ['created_at', 'price', 'rating', 'title', 'sold_count'];
            if (in_array($sortBy, $allowedSortFields)) {
                if ($sortBy === 'price') {
                    $query->orderByRaw('COALESCE(discount_price, price) ' . $sortOrder);
                } else {
                    $query->orderBy($sortBy, $sortOrder);
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            // Get favorite meal IDs for the authenticated user
            $favoriteMealIds = [];
            if ($user) {
                $favoriteMealIds = $user->favorites()->pluck('meal_id')->toArray();
            }

            $meals = $query->get()
                ->map(function ($meal) use ($favoriteMealIds) {
                    return [
                        'id'          => $meal->id,
                        'title'       => $meal->title,
                        'slug'        => $meal->slug,
                        'description' => $meal->description,
                        'image_url'   => $meal->image_url,
                        'offer_title' => $meal->offer_title,
                        ...$meal->getApiPriceAttributes(),
                        'has_offer'      => $meal->hasOffer(),
                        'rating'         => (float) $meal->rating,
                        'rating_count'   => (int) $meal->rating_count,
                        'size'           => $meal->size,
                        'brand'          => $meal->brand,
                        'stock_quantity' => $meal->stock_quantity,
                        'in_stock'       => $meal->isInStock(),
                        'is_featured'    => $meal->is_featured,
                        'sold_count'     => $meal->sold_count,
                        'category'       => [
                            'id'   => $meal->category->id,
                            'name' => $meal->category->name,
                        ],
                        'subcategory' => $meal->subcategory ? [
                            'id'   => $meal->subcategory->id,
                            'name' => $meal->subcategory->name,
                        ] : null,
                        'features'     => $meal->features,
                        'is_favorited' => in_array($meal->id, $favoriteMealIds),
                        'created_at'   => $meal->created_at,
                    ];
                });

            $totalCount = $meals->count();
            $isEmpty    = $totalCount === 0;

            return response()->json(array_merge([
                'success'     => true,
                'message'     => $isEmpty ? 'No products match your filters.' : 'Meals retrieved successfully',
                'data'        => $meals,
                'total_count' => $totalCount,
                'filters_applied' => [
                    'search'         => $request->input('search'),
                    'category_id'    => $request->input('category_id'),
                    'subcategory_id' => $request->input('subcategory_id'),
                    'min_price'      => $request->input('min_price'),
                    'max_price'      => $request->input('max_price'),
                    'min_rating'     => $request->input('min_rating'),
                    'brand'          => $request->input('brand'),
                    'featured'       => $request->boolean('featured'),
                    'in_stock'       => $request->boolean('in_stock'),
                    'sort_by'        => $sortBy,
                    'sort_order'     => $sortOrder,
                ],
            ], $isEmpty ? ['empty_message' => 'No products match the applied filters. Try adjusting your search or filters.'] : []));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve meals',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

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

            $meals = $recommendations->map(fn ($meal) => new MealResource(
                meal: $meal,
                extras: [
                    'is_featured'           => $meal->is_featured,
                    'recommendation_reason' => MealResource::recommendationReason($meal),
                ],
                categoryShape: [
                    'id'   => $meal->category->id,
                    'name' => $meal->category->name,
                    'slug' => $meal->category->slug,
                ],
            ));

            return response()->json([
                'success' => true,
                'message' => 'Meal recommendations retrieved successfully',
                'data'    => $meals->values(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve recommendations',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

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
                'data'    => new MealDetailResource($meal),
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
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
