<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Meal;
use Illuminate\Support\Facades\DB;

class CartService
{
    private function maxPerProduct(): int
    {
        return config('cart.max_quantity_per_product', 10);
    }

    /**
     * Add a meal to the cart or increment its quantity if already present.
     *
     * Throws \DomainException (code = HTTP status) for all business-rule violations
     * so the controller can map them to the correct JSON response without knowing
     * domain details.
     */
    public function addItem(Cart $cart, Meal $meal, int $quantity): Cart
    {
        // Pre-transaction guards — no rollback needed here.
        if (! $meal->is_available) {
            throw new \DomainException('This meal is currently unavailable', 400);
        }

        if (! $meal->isInStock()) {
            throw new \DomainException('This meal is out of stock', 400);
        }

        if ($meal->stock_quantity < $quantity) {
            throw new \DomainException("Only {$meal->stock_quantity} items available in stock", 400);
        }

        $maxPerProduct = $this->maxPerProduct();
        $cartItem = $cart->items()->where('meal_id', $meal->id)->first();

        DB::beginTransaction();

        if ($cartItem) {
            $newQuantity  = $cartItem->quantity + $quantity;
            $effectiveMax = min($maxPerProduct, $meal->stock_quantity);

            if ($newQuantity > $effectiveMax) {
                DB::rollBack();
                throw new \DomainException(
                    "Maximum {$maxPerProduct} units per product. You already have {$cartItem->quantity} in cart; maximum total is {$effectiveMax}.",
                    400
                );
            }

            if ($meal->stock_quantity < $newQuantity) {
                throw new \DomainException("Only {$meal->stock_quantity} items available in stock", 400);
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $discountAmount = 0;
            if ($meal->resolved_discount_price) {
                $discountAmount = ($meal->price - $meal->resolved_discount_price) * $quantity;
            }

            $cart->items()->create([
                'meal_id'         => $meal->id,
                'quantity'        => $quantity,
                'unit_price'      => $meal->final_price,
                'discount_amount' => $discountAmount,
                'subtotal'        => $meal->final_price * $quantity,
            ]);
        }

        return $this->refreshCart($cart);
    }

    /**
     * Replace a cart item's quantity.
     * Enforces the stock ceiling before writing.
     */
    public function updateItem(Cart $cart, CartItem $item, int $quantity): Cart
    {
        if ($item->meal->stock_quantity < $quantity) {
            throw new \DomainException("Only {$item->meal->stock_quantity} items available in stock", 400);
        }

        DB::beginTransaction();

        $item->update(['quantity' => $quantity]);

        return $this->refreshCart($cart);
    }

    /**
     * Remove a single item from the cart.
     */
    public function removeItem(Cart $cart, CartItem $item): Cart
    {
        DB::beginTransaction();

        $item->delete();

        return $this->refreshCart($cart);
    }

    /**
     * Remove all items from the cart.
     *
     * Uses a query-builder mass delete intentionally — Eloquent observers on
     * CartItem must not fire here (the cart recalculates explicitly afterwards).
     */
    public function clearCart(Cart $cart): Cart
    {
        DB::beginTransaction();

        $cart->items()->delete();
        $cart->calculateTotals();

        DB::commit();

        $cart->load(['items.meal.category', 'items.meal.subcategory']);

        return $cart;
    }

    /**
     * Recalculate cart totals, eager-load display relations, and commit the
     * open transaction. Mirrors the original refreshCart() private method.
     */
    private function refreshCart(Cart $cart): Cart
    {
        $cart->calculateTotals();
        $cart->load(['items.meal.category', 'items.meal.subcategory']);
        DB::commit();

        return $cart;
    }
}
