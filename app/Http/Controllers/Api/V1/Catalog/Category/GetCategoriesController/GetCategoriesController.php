<?php

namespace App\Http\Controllers\Api\V1\Catalog\Category\GetCategoriesController;

use App\Http\Controllers\Controller;
use App\Http\Resources\Catalog\Category\CategoryResource\CategoryResource;
use App\Models\Catalog\Category\Category;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetCategoriesController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $query = Category::active();
        if ($request->boolean('featured')) {
            $query->featured();
        }
        $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
        $categories = $query->get();

        return self::successResponse('Categories retrieved successfully', CategoryResource::collection($categories), 200);
    }
}
