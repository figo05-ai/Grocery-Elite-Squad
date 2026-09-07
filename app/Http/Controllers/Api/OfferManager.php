<?php

namespace App\Services;

use App\Http\Requests\Offer\ValidateOfferRequest;
use App\Http\Resources\Api\OfferResource;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfferManager
{
  public function index(Request $request): mixed
{
    $query = Offer::active();

    if ($request->has('type')) {
        $query->where('type', $request->type);
    }

    if ($request->has('min_purchase')) {
        $query->where('minimum_purchase', '<=', $request->min_purchase)
              ->orWhereNull('minimum_purchase');
    }

    if ($request->boolean('featured')) {
        $query->featured();
    }

    if ($request->has('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%");
        });
    }

    $orderBy = $request->get('order_by', 'created_at');
    $orderDirection = $request->get('order_direction', 'desc');

    $query->orderBy($orderBy, $orderDirection);

    $perPage = $request->get('per_page', 15);

    $offers = $query->paginate($perPage);

    return OfferResource::collection($offers);
}
public function featured()
{
    $offers = Offer::featured()
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    return OfferResource::collection($offers);
}
 public function showByCode(string $code)
{
    $offer = Offer::where('code', $code)->firstOrFail();

    return new OfferResource($offer);
}
 public function validateOffer(ValidateOfferRequest $request)
{
    $offer = Offer::where('code', $request->code)->first();

    if (!$offer) {
        return response()->json([
            'valid' => false,
            'message' => 'Invalid offer code',
        ], 404);
    }

    $isValid = $offer->isValid();
    $canApply = true;
    $message = 'Offer is valid';

    if ($isValid && $request->filled('amount')) {

        $canApply = $offer->canApplyToAmount($request->amount);

        if (!$canApply) {
            $message = 'Minimum purchase required: $' . $offer->minimum_purchase;
        }
    }

    $discount = ($isValid && $canApply)
        ? $offer->calculateDiscount($request->amount ?? 0)
        : 0;

    return response()->json([
        'valid' => $isValid && $canApply,
        'offer' => new OfferResource($offer),
        'discount_amount' => $discount,
        'message' => $message,
    ]);
}
}
