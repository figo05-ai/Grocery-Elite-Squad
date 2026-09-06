<?php

namespace App\Http\Controllers\Api\V1\Cart\GetCartController;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource\CartResource;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Models\Cart\Cart\Cart;
use Illuminate\Http\Request;

class GetCartController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        Gate::authorize('viewAny', Cart::class);

        $user = $request->user();
        $cart = $user->activeCart()->with('items.meal')->firstOrCreate(['user_id' => $user->id, 'status' => 'active']);
        $cart->calculateTotals();

        return self::successResponse('Cart retrieved successfully', new CartResource($cart), 200);
    }
}
