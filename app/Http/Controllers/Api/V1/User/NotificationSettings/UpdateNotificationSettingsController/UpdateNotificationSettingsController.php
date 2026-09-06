<?php

namespace App\Http\Controllers\Api\V1\User\NotificationSettings\UpdateNotificationSettingsController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateNotificationSettingsController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'order_updates' => 'sometimes|boolean',
            'promotion_emails' => 'sometimes|boolean',
            'nutrition_insights' => 'sometimes|boolean',
            'price_alerts' => 'sometimes|boolean',
        ]);

        $user = $request->user();
        $settings = $user->initializeNotificationSettings();
        $settings->update($request->only([
            'order_updates', 'promotion_emails', 'nutrition_insights', 'price_alerts',
        ]));

        return self::successResponse('Notification settings updated successfully', [
            'id' => $settings->id,
            'order_updates' => (bool) $settings->order_updates,
            'promotion_emails' => (bool) $settings->promotion_emails,
            'nutrition_insights' => (bool) $settings->nutrition_insights,
            'price_alerts' => (bool) $settings->price_alerts,
        ], 200);
    }
}
