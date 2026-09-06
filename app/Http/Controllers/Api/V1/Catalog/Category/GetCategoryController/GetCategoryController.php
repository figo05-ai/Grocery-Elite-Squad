<?php

namespace App\Http\Controllers\Api\V1\Catalog\Category\GetCategoryController;

use App\Http\Controllers\Controller;
use App\Http\Resources\Catalog\Category\CategoryResource\CategoryResource;
use App\Models\Catalog\Category\Category;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetCategoryController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $category = Category::with(['subcategories' => function ($q) {
            $q->active()->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
        }])->active()->findOrFail($id);

        return self::successResponse('Category retrieved successfully', new CategoryResource($category), 200);
    }
}
