<?php

namespace App\Http\Controllers\Api\V1\Order\GetOrderController;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource\OrderResource;
use App\Models\Order\Order\Order;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetOrderController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $order = Order::where('user_id', $request->user()->id)->with(['items.meal', 'address'])->findOrFail($id);

        return self::successResponse('Order retrieved successfully', new OrderResource($order), 200);
    }
}
