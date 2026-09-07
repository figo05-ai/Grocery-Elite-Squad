<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\ClearNotificationRequest;
use App\Http\Requests\Notification\DestroyMultipleRequest;
use App\Services\NotificationManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
   public function __construct(
    private NotificationManager $notificationManager
) {}
    /**
     * Get all notifications
     */
    public function index(Request $request): JsonResponse
    {
        return $this->notificationService->index($request);
    }

    /**
     * Get notifications with resources
     */
    public function indexWithResources(Request $request): JsonResponse
    {
       return $this->notificationManager->indexWithResources($request);
    }

    /**
     * Get notification statistics
     */
    public function stats(): JsonResponse
    {
      return $this->notificationManager->stats();
    }

    /**
     * Show notification
     */
    public function show(string $id): JsonResponse
    {
       return $this->notificationManager->show($id);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(string $id): JsonResponse
    {
        return $this->notificationService->markAsRead($id);
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(string $id): JsonResponse
    {
        return $this->notificationService->markAsUnread($id);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): JsonResponse
    {
        return $this->notificationService->markAllAsRead();
    }

    /**
     * Delete notification
     */
    public function destroy(string $id): JsonResponse
    {
       return $this->notificationManager->destroy($id);
    }

    /**
     * Delete multiple notifications
     */
    public function destroyMultiple(DestroyMultipleRequest $request): JsonResponse
    {
        return $this->notificationService->destroyMultiple($request);
    }

    /**
     * Clear notifications
     */
    public function clearAll(ClearNotificationRequest $request): JsonResponse
    {
        return $this->notificationService->clearAll($request);
    }

    /**
     * Get notifications by type
     */
    public function byType(string $type): JsonResponse
    {
        return $this->notificationService->byType($type);
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount(): JsonResponse
    {
        return $this->notificationService->unreadCount();
    }

    /**
     * Get recent notifications
     */
    public function recent(): JsonResponse
    {
       return $this->notificationManager->recent();

    }
}
