<?php

namespace App\Infrastructure\Payment\StripePaymentGateway;

use App\Models\User\User\User;
use App\Services\Order\Payment\PaymentGatewayInterface\PaymentGatewayInterface;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePaymentGateway implements PaymentGatewayInterface
{
    public function charge(User $user, float $amount, string $paymentMethodId): array
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        if (! $user->stripe_customer_id) {
            return ['success' => false, 'message' => 'Stripe customer not found. Please add a payment method first.'];
        }

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => (int) ($amount * 100),
                'currency' => 'usd',
                'customer' => $user->stripe_customer_id,
                'payment_method' => $paymentMethodId,
                'off_session' => true,
                'confirm' => true,
            ]);

            if ($paymentIntent->status !== 'succeeded') {
                return ['success' => false, 'message' => 'Payment failed: '.$paymentIntent->status];
            }

            return ['success' => true, 'transaction_id' => $paymentIntent->id];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Payment processing failed: '.$e->getMessage()];
        }
    }
}
