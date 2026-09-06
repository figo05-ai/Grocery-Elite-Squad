<?php

namespace App\Http\Controllers\Api\V1\User\NotificationSettings\UpdateNotificationCategoryController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateNotificationCategoryController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, string $category): JsonResponse
    {
        $request->validate([
            'enabled' => 'required|boolean',
        ]);

        $validCategories = ['order_updates', 'promotion_emails', 'nutrition_insights', 'price_alerts'];
        if (! in_array($category, $validCategories)) {
            return self::errorResponse('Invalid notification category', [], 400);
        }

        $user = $request->user();
        $settings = $user->initializeNotificationSettings();
        $settings->update([$category => $request->boolean('enabled')]);

        return self::successResponse("Category '{$category}' updated successfully", [
            'category' => $category,
            'enabled' => $request->boolean('enabled'),
        ], 200);
    }
}
