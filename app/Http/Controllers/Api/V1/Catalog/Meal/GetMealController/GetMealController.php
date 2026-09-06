<?php

namespace App\Http\Controllers\Api\V1\Catalog\Meal\GetMealController;

use App\Http\Controllers\Controller;
use App\Http\Resources\Catalog\Meal\MealResource\MealResource;
use App\Models\Catalog\Meal\Meal;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetMealController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $meal = Meal::with(['category', 'subcategory'])->available()->findOrFail($id);

        return self::successResponse('Meal retrieved successfully', new MealResource($meal), 200);
    }
}
