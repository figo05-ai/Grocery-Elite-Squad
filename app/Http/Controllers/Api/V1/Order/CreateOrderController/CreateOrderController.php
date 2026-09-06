<?php

namespace App\Http\Controllers\Api\V1\Order\CreateOrderController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest\StoreOrderRequest;
use App\Http\Resources\Order\OrderResource\OrderResource;
use App\Models\Order\Order\Order;
use App\Services\Order\CreateOrderService\CreateOrderService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class CreateOrderController extends Controller
{
    use ApiResponse;

    public function __invoke(StoreOrderRequest $request): JsonResponse
    {
        Gate::authorize('create', Order::class);
        try {
            $service = app(CreateOrderService::class);
            $order = $service->execute($request->user(), $request->validated());
            $order->load(['items.meal', 'address']);

            return self::successResponse('Order created successfully', new OrderResource($order), 201);
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage(), [], 400);
        }
    }
}
