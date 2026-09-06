<?php

namespace App\Http\Controllers\Api\V1\Order\GetOrdersController;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource\OrderResource;
use App\Models\Order\Order\Order;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GetOrdersController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        Gate::authorize('viewAny', Order::class);
        $user = $request->user();
        $orders = Order::where('user_id', $user->id)->with(['items.meal.category', 'items.meal.subcategory', 'address'])->orderBy('created_at', 'desc')->get();

        return self::successResponse('Orders retrieved successfully', [
            'data' => OrderResource::collection($orders),
            'total_count' => $orders->count(),
        ], 200);
    }
}
