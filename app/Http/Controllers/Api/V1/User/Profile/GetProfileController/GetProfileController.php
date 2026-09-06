<?php

namespace App\Http\Controllers\Api\V1\User\Profile\GetProfileController;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Profile\ProfileResource\ProfileResource;
use App\Models\Order\Order\Order;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\TransientToken;

class GetProfileController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load(['addresses', 'favorites.meal.category', 'favorites.meal.subcategory']);

        $addresses = $user->addresses()->orderBy('is_default', 'desc')->orderBy('created_at', 'desc')->get();
        $allOrders = Order::where('user_id', $user->id)->with(['items.meal.category', 'items.meal.subcategory', 'address'])->orderBy('created_at', 'desc')->get();

        // Data formatters kept locally for now to avoid massive refactoring of Order/Catalog domains prematurely
        $orderHistory = $allOrders->map(fn (Order $o) => ['id' => $o->id, 'order_number' => $o->order_number, 'status' => $o->status, 'status_description' => $o->status_description, 'total' => (float) $o->total, 'placed_at' => $o->placed_at?->toIso8601String(), 'created_at' => $o->created_at?->toIso8601String(), 'item_count' => $o->items->count()]);

        $inProgressWithTracking = $allOrders->whereNotIn('status', ['cancelled', 'delivered'])->map(fn (Order $o) => ['id' => $o->id, 'order_number' => $o->order_number, 'status' => $o->status, 'total' => (float) $o->total])->values(); // Simplified for now

        $orderNotifications = $user->notifications()->take(20)->get()->map(fn ($n) => ['id' => $n->id, 'type' => $n->data['type'] ?? 'order', 'title' => $n->data['title'] ?? 'Order update', 'body' => $n->data['body'] ?? '', 'is_read' => $n->read_at !== null, 'created_at' => $n->created_at?->toIso8601String()]);

        $currentTokenId = $user->currentAccessToken() && ! ($user->currentAccessToken() instanceof TransientToken) ? $user->currentAccessToken()->id : null;
        $sessions = $user->tokens()->get()->map(fn ($token) => ['id' => $token->id, 'name' => $token->name, 'last_used_at' => $token->last_used_at?->toIso8601String(), 'is_current' => (string) $token->id === (string) $currentTokenId])->all();

        $wishlist = $user->favorites->map(fn ($f) => ['id' => $f->meal->id, 'title' => $f->meal->title, 'is_favorited' => true])->values();

        $data = [
            'user' => $user,
            'addresses' => $addresses,
            'order_history' => $orderHistory,
            'in_progress_orders' => $inProgressWithTracking,
            'order_notifications' => $orderNotifications,
            'sessions' => $sessions,
            'wishlist' => $wishlist,
        ];

        return self::successResponse('Profile retrieved successfully', new ProfileResource($data));
    }
}
