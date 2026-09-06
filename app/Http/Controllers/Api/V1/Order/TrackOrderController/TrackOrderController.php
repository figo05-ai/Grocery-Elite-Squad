<?php

namespace App\Http\Controllers\Api\V1\Order\TrackOrderController;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource\OrderResource;
use App\Models\Order\Order\Order;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();
        $order = Order::where('user_id', $user->id)
            ->whereNotIn('status', ['cancelled', 'delivered'])
            ->with(['items.meal.category', 'items.meal.subcategory', 'address'])
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $order) {
            return self::errorResponse('No active order found', [], 404);
        }

        if ($order->status === 'awaiting_payment') {
            return self::successResponse('Order is waiting for payment. Complete checkout to continue.', [
                'order' => new OrderResource($order),
                'awaiting_payment' => true,
                'tracking' => null,
            ], 200);
        }

        $tracking = [
            'position' => $order->status_position,
            'status' => $order->status,
            'status_description' => $order->status_description,
            'positions' => [
                ['position' => 1, 'status' => 'placed', 'label' => 'Order Placed', 'completed' => in_array($order->status, ['placed', 'processing', 'shipping', 'out_for_delivery', 'delivered']), 'timestamp' => $order->placed_at],
                ['position' => 2, 'status' => 'processing', 'label' => 'Processing', 'completed' => in_array($order->status, ['processing', 'shipping', 'out_for_delivery', 'delivered']), 'timestamp' => $order->processing_at],
                ['position' => 3, 'status' => 'shipping', 'label' => 'Shipping', 'completed' => in_array($order->status, ['shipping', 'out_for_delivery', 'delivered']), 'timestamp' => $order->shipping_at],
                ['position' => 4, 'status' => 'out_for_delivery', 'label' => 'Out for Delivery', 'completed' => in_array($order->status, ['out_for_delivery', 'delivered']), 'timestamp' => $order->out_for_delivery_at],
                ['position' => 5, 'status' => 'delivered', 'label' => 'Delivered', 'completed' => $order->status === 'delivered', 'timestamp' => $order->delivered_at],
            ],
        ];

        return self::successResponse('Order tracking retrieved successfully', [
            'order' => new OrderResource($order),
            'tracking' => $tracking,
        ], 200);
    }
}
