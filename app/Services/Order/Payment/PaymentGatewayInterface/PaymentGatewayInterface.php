<?php

namespace App\Services\Order\Payment\PaymentGatewayInterface;

use App\Models\User\User\User;

interface PaymentGatewayInterface
{
    public function charge(User $user, float $amount, string $paymentMethodId): array;
}
