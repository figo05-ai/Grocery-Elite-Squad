<?php

namespace App\Filament\Resources\Order\OrderItemResource\Pages;

use App\Filament\Resources\Order\OrderItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrderItem extends CreateRecord
{
    protected static string $resource = OrderItemResource::class;
}
