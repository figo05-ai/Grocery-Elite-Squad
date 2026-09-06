<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Http\Resources\Api\CartResource;
use App\Models\Meal;
use App\Services\CartService;
use App\Services\ShippingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected ShippingService $shippingService,
    ) {}

    /**
     * Get user's cart, optionally with a shipping fee preview.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $cart = $request->user()->getOrCreateCart();
            $cart->load(['items.meal.category', 'items.meal.subcategory']);

            $shippingFee      = null;
            $totalWithShipping = null;

            $deliveryType = $request->query('delivery_type');
            if ($deliveryType && in_array($deliveryType, ['delivery', 'pickup'], true)) {
                $shippingFee       = $this->shippingService->calculateShippingFee((float) $cart->subtotal, $deliveryType);
                $totalWithShipping = (float) $cart->total + $shippingFee;
            }

            return response()->json([
                'success' => true,
                'message' => 'Cart retrieved successfully',
                'data'    => new CartResource($cart, $shippingFee, $totalWithShipping),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve cart',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add an item to the cart.
     */
    public function addItem(AddCartItemRequest $request): JsonResponse
    {
        try {
            $cart = $request->user()->getOrCreateCart();
            $meal = Meal::findOrFail($request->validated('meal_id'));

            $cart = $this->cartService->addItem($cart, $meal, (int) $request->validated('quantity'));

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'data'    => new CartResource($cart),
            ]);
        } catch (\DomainException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to add item to cart',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a cart item's quantity.
     */
    public function updateItem(UpdateCartItemRequest $request, string $itemId): JsonResponse
    {
        try {
            $cart     = $request->user()->getOrCreateCart();
            $cartItem = $cart->items()->findOrFail($itemId);

            $cart = $this->cartService->updateItem($cart, $cartItem, (int) $request->validated('quantity'));

            return response()->json([
                'success' => true,
                'message' => 'Cart item updated successfully',
                'data'    => new CartResource($cart),
            ]);
        } catch (\DomainException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart item',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove an item from the cart.
     */
    public function removeItem(Request $request, string $itemId): JsonResponse
    {
        try {
            $cart     = $request->user()->getOrCreateCart();
            $cartItem = $cart->items()->findOrFail($itemId);

            $cart = $this->cartService->removeItem($cart, $cartItem);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully',
                'data'    => new CartResource($cart),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from cart',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clear all items from the cart.
     */
    public function clear(Request $request): JsonResponse
    {
        try {
            $cart = $request->user()->getOrCreateCart();
            $cart = $this->cartService->clearCart($cart);

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'data'    => new CartResource($cart),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
