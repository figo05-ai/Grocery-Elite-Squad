<?php

namespace App\Services;

use App\Http\Requests\Notification\ClearNotificationRequest;
use App\Http\Requests\Notification\DestroyMultipleRequest;
use App\Http\Resources\Api\NotificationResource;
use App\Models\Meal;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class NotificationManager
{
    /**
     * Get all notifications
     */
public function index(Request $request): JsonResponse
{
    $user = Auth::user();

    $perPage = max(1, min(100, (int) $request->get('per_page', 15)));

    $notifications = $this->buildNotificationsQuery($request)
        ->paginate($perPage);

    return response()->json([
        'success' => true,
        'data' => [
            'notifications' => NotificationResource::collection($notifications),
            'unread_count' => $user->unreadNotifications()->count(),
            'total_count' => $user->notifications()->count(),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
            ],
        ],
    ]);
}

    /**
     * Get notifications with related resources
     */
    public function indexWithResources(Request $request): JsonResponse
    {
        try {

            $user = Auth::user();

            $perPage = max(1, min(100, (int) $request->get('per_page', 15)));

            $notifications = $this->buildNotificationsQuery($request)
                ->paginate($perPage);

            $pageItems = $notifications->getCollection();

            $mealIds = [];
            $orderIds = [];

            foreach ($pageItems as $notification) {

                $data = $this->notificationDataAsArray($notification->data);

                if (!empty($data['meal_id']) && is_numeric($data['meal_id'])) {
                    $mealIds[] = (int) $data['meal_id'];
                }

                if (!empty($data['order_id']) && is_numeric($data['order_id'])) {
                    $orderIds[] = (int) $data['order_id'];
                }
            }

            $mealIds = array_unique($mealIds);
            $orderIds = array_unique($orderIds);

            $meals = Meal::with('category')
                ->whereIn('id', $mealIds)
                ->get()
                ->keyBy('id');

            $orders = Order::whereIn('id', $orderIds)
                ->get()
                ->keyBy('id');
          $transformed = $pageItems->map(function (DatabaseNotification $notification) use ($meals, $orders) {

    $row = (new NotificationResource($notification))->toArray(request());

    $data = $this->notificationDataAsArray($notification->data);

    $resources = [];

    if (!empty($data['meal_id']) && is_numeric($data['meal_id'])) {

        $meal = $meals->get((int) $data['meal_id']);

        if ($meal) {
            $resources['meal'] = [
                'id' => $meal->id,
                'title' => $meal->title,
                'slug' => $meal->slug,
                'image_url' => $meal->image_url,
                ...$meal->getApiPriceAttributes(),
                'has_offer' => $meal->hasOffer(),
                'category' => $meal->category ? [
                    'id' => $meal->category->id,
                    'name' => $meal->category->name,
                ] : null,
            ];
        }
    }

    if (!empty($data['order_id']) && is_numeric($data['order_id'])) {

        $order = $orders->get((int) $data['order_id']);

        if ($order) {
            $resources['order'] = [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'total' => (string) $order->total,
                'placed_at' => $order->placed_at?->toIso8601String(),
                'created_at' => $order->created_at?->toIso8601String(),
            ];
        }
    }

    $row['resources'] = $resources;

    return $row;

})->values();

$notifications->setCollection($transformed);

return response()->json([
    'success' => true,
    'data' => [
        'notifications' => $notifications->items(),
        'unread_count' => $user->unreadNotifications()->count(),
        'total_count' => $user->notifications()->count(),
        'pagination' => [
            'current_page' => $notifications->currentPage(),
            'last_page' => $notifications->lastPage(),
            'per_page' => $notifications->perPage(),
            'total' => $notifications->total(),
        ],
    ],
]);

} catch (Throwable $e) {

    Log::error('notifications.with-resources failed', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);

    return response()->json([
        'success' => false,
        'message' => 'Failed to load notifications',
        'error' => config('app.debug')
            ? $e->getMessage()
            : 'Internal server error',
    ], 500);
}
    }
      /**
 * Get notification statistics
 */
public function stats(): JsonResponse
{
    $user = Auth::user();

    $allNotifications = $user->notifications();
    $unreadNotifications = $user->unreadNotifications();

    $total = $allNotifications->count();
    $unread = $unreadNotifications->count();

    $typeCounts = $allNotifications->get()
        ->groupBy(function (DatabaseNotification $notification) {
            $data = $this->notificationDataAsArray($notification->data);

            return $data['type'] ?? 'unknown';
        })
        ->map(function ($notifications) {
            return [
                'total' => $notifications->count(),
                'unread' => $notifications->whereNull('read_at')->count(),
            ];
        });

    $recentTypes = $allNotifications->latest()
        ->take(5)
        ->get()
        ->map(function (DatabaseNotification $notification) {
            $data = $this->notificationDataAsArray($notification->data);

            return $data['type'] ?? null;
        })
        ->filter()
        ->unique()
        ->values();

    $last = $allNotifications->latest()->first();

    return response()->json([
        'success' => true,
        'data' => [
            'total' => $total,
            'unread' => $unread,
            'read' => $total - $unread,
            'by_type' => $typeCounts,
            'recent_types' => $recentTypes,
            'last_notification_at' => $last?->created_at?->toIso8601String(),
        ],
    ]);
}
      /**
 * Get a single notification
 */
public function show(string $id): JsonResponse
{
    $user = Auth::user();

    $notification = $user->notifications()->findOrFail($id);

    if (!$notification->read_at) {
        $notification->markAsRead();
    }

    return response()->json([
        'success' => true,
        'data' => new NotificationResource($notification),
    ]);
}

/**
 * Mark notification as read
 */
public function markAsRead(string $id): JsonResponse
{
    $user = Auth::user();

    $notification = $user->notifications()->findOrFail($id);

    if (!$notification->read_at) {

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
            'data' => new NotificationResource($notification),
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Notification is already read',
    ], 400);
}

/**
 * Mark notification as unread
 */
public function markAsUnread(string $id): JsonResponse
{
    $user = Auth::user();

    $notification = $user->notifications()->findOrFail($id);

    if ($notification->read_at) {

        $notification->markAsUnread();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as unread',
            'data' => new NotificationResource($notification),
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Notification is already unread',
    ], 400);
}

/**
 * Mark all notifications as read
 */
public function markAllAsRead(): JsonResponse
{
    $user = Auth::user();

    $count = $user->unreadNotifications()->count();

    if ($count > 0) {

        $user->unreadNotifications()->update([
            'read_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$count} notifications marked as read",
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'No unread notifications',
    ], 400);
}
      /**
 * Delete notification
 */
public function destroy(string $id): JsonResponse
{
    $user = Auth::user();

    $notification = $user->notifications()->findOrFail($id);

    $notification->delete();

    return response()->json([
        'success' => true,
        'message' => 'Notification deleted successfully',
    ]);
}

/**
 * Delete multiple notifications
 */
public function destroyMultiple(DestroyMultipleRequest $request): JsonResponse
{
    $user = Auth::user();

    $deleted = $user->notifications()
        ->whereIn('id', $request->ids)
        ->delete();

    return response()->json([
        'success' => true,
        'message' => "{$deleted} notifications deleted successfully",
    ]);
}

/**
 * Clear notifications
 */
public function clearAll(ClearNotificationRequest $request): JsonResponse
{
    $user = Auth::user();

    $type = $request->get('type', 'all');

    switch ($type) {

        case 'read':
            $count = $user->readNotifications()->count();
            $user->readNotifications()->delete();
            $message = "{$count} read notifications cleared";
            break;

        case 'unread':
            $count = $user->unreadNotifications()->count();
            $user->unreadNotifications()->delete();
            $message = "{$count} unread notifications cleared";
            break;

        default:
            $count = $user->notifications()->count();
            $user->notifications()->delete();
            $message = "All {$count} notifications cleared";
    }

    return response()->json([
        'success' => true,
        'message' => $message,
    ]);
}

/**
 * Get notifications by type
 */
public function byType(string $type): JsonResponse
{
    $user = Auth::user();

    $notifications = $user->notifications()
        ->where('data->type', $type)
        ->latest()
        ->paginate(15);

    return response()->json([
        'success' => true,
        'data' => [
            'type' => $type,
            'notifications' => NotificationResource::collection($notifications),
            'total' => $notifications->total(),
        ],
    ]);
}

/**
 * Unread notifications count
 */
public function unreadCount(): JsonResponse
{
    $count = Auth::user()->unreadNotifications()->count();

    return response()->json([
        'success' => true,
        'data' => [
            'count' => $count,
            'has_unread' => $count > 0,
        ],
    ]);
}

/**
 * Recent notifications
 */
public function recent(): JsonResponse
{
    $notifications = Auth::user()
        ->notifications()
        ->where('created_at', '>=', now()->subDay())
        ->latest()
        ->take(10)
        ->get();

    return response()->json([
        'success' => true,
        'data' => [
            'notifications' => NotificationResource::collection($notifications),
            'total_recent' => $notifications->count(),
        ],
    ]);
}
      /**
 * Build notifications query
 */
private function buildNotificationsQuery(Request $request)
{
    $user = Auth::user();

    $query = $user->notifications();

    if ($request->has('read')) {
        $isRead = filter_var($request->read, FILTER_VALIDATE_BOOLEAN);
        $query = $isRead
            ? $query->read()
            : $query->unread();
    }

    if ($request->filled('type')) {
        $query->where('data->type', $request->type);
    }

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('data->title', 'like', "%{$search}%")
              ->orWhere('data->body', 'like', "%{$search}%");
        });
    }

    $allowed = ['created_at', 'read_at'];

  $orderBy = in_array(
    (string) $request->get('order_by', 'created_at'),
    $allowed,
    true
)
    ? (string) $request->get('order_by', 'created_at')
    : 'created_at';

    $direction = strtolower($request->get('order_dir', 'desc')) === 'asc'
        ? 'asc'
        : 'desc';

    return $query->orderBy($orderBy, $direction);
}

/**
 * Convert notification data to array
 */
private function notificationDataAsArray(mixed $data): array
{
    if (is_array($data)) {
        return $data;
    }

    if (is_string($data)) {

        $decoded = json_decode($data, true);

        return is_array($decoded)
            ? $decoded
            : [];
    }

    return [];
}
    }
