<?php

namespace App\Http\Controllers\Api\V1\Cart\ClearCartController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ClearCartController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {

        $user = $request->user();
        $cart = $user->activeCart()->first();
        if ($cart) {
            Gate::authorize('update', $cart);
            $cart->items()->delete();
            $cart->calculateTotals();
        }

        return self::successResponse('Cart cleared successfully', [], 200);
    }
}
