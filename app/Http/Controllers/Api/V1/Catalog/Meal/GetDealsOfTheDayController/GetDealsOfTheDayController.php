<?php

namespace App\Http\Controllers\Api\V1\Catalog\Meal\GetDealsOfTheDayController;

use App\Http\Controllers\Controller;
use App\Http\Resources\Catalog\Meal\MealResource\MealResource;
use App\Models\Catalog\Meal\Meal;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetDealsOfTheDayController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $meals = Meal::with('category')->available()->withActiveDiscount()->orderBy('created_at', 'desc')->get();

        return self::successResponse("Today's deals retrieved successfully", MealResource::collection($meals), 200);
    }
}
