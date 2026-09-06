<?php

namespace App\Http\Controllers\Api\V1\User\NotificationSettings\GetNotificationSettingsController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetNotificationSettingsController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();
        $settings = $user->initializeNotificationSettings();

        return self::successResponse('Notification settings retrieved successfully', [
            'id' => $settings->id,
            'order_updates' => (bool) $settings->order_updates,
            'promotion_emails' => (bool) $settings->promotion_emails,
            'nutrition_insights' => (bool) $settings->nutrition_insights,
            'price_alerts' => (bool) $settings->price_alerts,
        ], 200);
    }
}
