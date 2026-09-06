<?php

namespace App\Services\Order\CreateOrderService;

use App\Models\Order\Order\Order;
use App\Models\Order\OrderItem\OrderItem;
use App\Models\Order\OrderNote\OrderNote;
use App\Models\User\User\User;
use App\Services\Order\Payment\PaymentGatewayInterface\PaymentGatewayInterface;
use App\Services\Order\ShippingService\ShippingService;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateOrderService
{
    public function __construct(
        private readonly ShippingService $shippingService,
        private readonly PaymentGatewayInterface $paymentGateway
    ) {}

    public function execute(User $user, array $validated): Order
    {
        $cart = $user->activeCart()->with('items.meal')->first();
        if (! $cart || $cart->isEmpty()) {
            throw new Exception('Your cart is empty. Please add items to your cart before placing an order.');
        }

        $items = [];
        $subtotal = 0;
        foreach ($cart->items as $cartItem) {
            $meal = $cartItem->meal;
            if (! $meal || ! $meal->is_available) {
                throw new Exception('One or more items in your cart are no longer available.');
            }
            if ($meal->stock_quantity < $cartItem->quantity) {
                throw new Exception("Only {$meal->stock_quantity} items available for '{$meal->title}'");
            }
            $maxPerProduct = config('cart.max_quantity_per_product', 10);
            if ($cartItem->quantity > $maxPerProduct) {
                throw new Exception("Maximum {$maxPerProduct} units per product allowed.");
            }
            $items[] = [
                'meal' => $meal,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->unit_price,
                'discount_amount' => $cartItem->discount_amount,
                'subtotal' => $cartItem->subtotal,
            ];
        }

        $cart->calculateTotals();
        $shippingFee = $this->shippingService->calculateShippingFee((float) $cart->subtotal, $validated['delivery_type']);
        $total = (float) $cart->subtotal + (float) $cart->tax + $shippingFee;

        return DB::transaction(function () use ($user, $validated, $cart, $items, $total, $shippingFee) {
            $stripePaymentIntentId = null;

            // Handle Inline Card Payment
            if ($validated['payment_method'] === 'card') {
                $paymentResult = $this->paymentGateway->charge($user, $total, $validated['payment_method_id']);
                if (! $paymentResult['success']) {
                    throw new Exception($paymentResult['message']);
                }
                $stripePaymentIntentId = $paymentResult['transaction_id'];
            }

            $isHostedStripe = $validated['payment_method'] === 'stripe_checkout';

            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $validated['delivery_type'] === 'delivery' ? $validated['address_id'] : null,
                'payment_method' => $validated['payment_method'],
                'stripe_payment_intent_id' => $stripePaymentIntentId,
                'delivery_type' => $validated['delivery_type'],
                'status' => $isHostedStripe ? 'awaiting_payment' : 'placed',
                'subtotal' => $cart->subtotal,
                'tax' => $cart->tax,
                'discount' => $cart->discount,
                'shipping_fee' => $shippingFee,
                'total' => $total,
                'notes' => $validated['notes'] ?? null,
                'placed_at' => $isHostedStripe ? null : now(),
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'meal_id' => $item['meal']->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount_amount' => $item['discount_amount'],
                    'subtotal' => $item['subtotal'],
                ]);
                $item['meal']->decrement('stock_quantity', $item['quantity']);
            }

            // Clear Cart
            $cart->items()->delete();
            $cart->update(['status' => 'completed']);

            // Order Notes
            if (isset($validated['special_note_id'])) {
                OrderNote::create([
                    'order_id' => $order->id,
                    'special_note_id' => $validated['special_note_id'],
                    'notes' => $validated['notes'] ?? null,
                ]);
            } elseif (isset($validated['notes'])) {
                OrderNote::create([
                    'order_id' => $order->id,
                    'notes' => $validated['notes'],
                ]);
            }

            return $order;
        });
    }
}
