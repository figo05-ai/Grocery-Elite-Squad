<?php

namespace App\Http\Controllers\Api\V1\Catalog\Meal\GetMealsController;

use App\Http\Controllers\Controller;
use App\Http\Resources\Catalog\Meal\MealResource\MealResource;
use App\Models\Catalog\Meal\Meal;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetMealsController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $query = Meal::with(['category', 'subcategory'])->available();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(fn ($q) => $q->where('title', 'like', "%$search%")->orWhere('description', 'like', "%$search%"));
        }
        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        if ($request->has('subcategory_id')) {
            $query->where('subcategory_id', $request->input('subcategory_id'));
        }

        $meals = $query->orderBy('created_at', 'desc')->paginate(20);

        return self::successResponse('Meals retrieved successfully', MealResource::collection($meals), 200);
    }
}
