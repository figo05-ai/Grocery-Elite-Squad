<?php

namespace App\Http\Resources\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function __construct(
        Cart $resource,
        private readonly ?float $shippingFee = null,
        private readonly ?float $totalWithShipping = null,
    ) {
        parent::__construct($resource);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Cart $cart */
        $cart = $this->resource;

        $data = [
            'id'     => $cart->id,
            'status' => $cart->isEmpty() ? 'empty' : 'not empty',
            'items'  => $cart->items->map(fn ($item) => [
                'id'   => $item->id,
                'meal' => [
                    'id'             => $item->meal->id,
                    'title'          => $item->meal->title,
                    'slug'           => $item->meal->slug,
                    'image_url'      => $item->meal->image_url,
                    ...$item->meal->getApiPriceAttributes(),
                    'rating'         => (float) $item->meal->rating,
                    'size'           => $item->meal->size,
                    'brand'          => $item->meal->brand,
                    'stock_quantity' => $item->meal->stock_quantity,
                    'is_available'   => $item->meal->is_available,
                    'in_stock'       => $item->meal->isInStock(),
                    'category'       => $item->meal->category ? [
                        'id'   => $item->meal->category->id,
                        'name' => $item->meal->category->name,
                    ] : null,
                    'subcategory' => $item->meal->subcategory ? [
                        'id'   => $item->meal->subcategory->id,
                        'name' => $item->meal->subcategory->name,
                    ] : null,
                ],
                'quantity'        => $item->quantity,
                'unit_price'      => (float) $item->unit_price,
                'discount_amount' => (float) $item->discount_amount,
                'subtotal'        => (float) $item->subtotal,
            ]),
            'item_count' => $cart->item_count,
            'subtotal'   => (float) $cart->subtotal,
            'tax'        => (float) $cart->tax,
            'discount'   => (float) $cart->discount,
            'total'      => (float) $cart->total,
            'is_empty'   => $cart->isEmpty(),
            'created_at' => $cart->created_at,
            'updated_at' => $cart->updated_at,
        ];

        if ($this->shippingFee !== null && $this->totalWithShipping !== null) {
            $data['shipping_fee']        = $this->shippingFee;
            $data['total_with_shipping'] = $this->totalWithShipping;
        }

        return $data;
    }
}
