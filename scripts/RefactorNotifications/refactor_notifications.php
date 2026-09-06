<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 1. Settings & Notifications
$controllers = [
    'GetNotificationSettingsController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $user = $request->user();
        $settings = $user->initializeNotificationSettings();
        
        return self::successResponse('Notification settings retrieved successfully', [
            'id' => $settings->id,
            'order_updates' => (bool) $settings->order_updates,
            'promotion_emails' => (bool) $settings->promotion_emails,
            'nutrition_insights' => (bool) $settings->nutrition_insights,
            'price_alerts' => (bool) $settings->price_alerts,
        ], 200);
PHP
    ],
    'UpdateNotificationSettingsController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $request->validate([
            'order_updates' => 'sometimes|boolean',
            'promotion_emails' => 'sometimes|boolean',
            'nutrition_insights' => 'sometimes|boolean',
            'price_alerts' => 'sometimes|boolean',
        ]);

        $user = $request->user();
        $settings = $user->initializeNotificationSettings();
        $settings->update($request->only([
            'order_updates', 'promotion_emails', 'nutrition_insights', 'price_alerts'
        ]));

        return self::successResponse('Notification settings updated successfully', [
            'id' => $settings->id,
            'order_updates' => (bool) $settings->order_updates,
            'promotion_emails' => (bool) $settings->promotion_emails,
            'nutrition_insights' => (bool) $settings->nutrition_insights,
            'price_alerts' => (bool) $settings->price_alerts,
        ], 200);
PHP
    ],
    'UpdateNotificationCategoryController' => [
        'use' => "use App\Traits\V1\ApiResponse;\nuse Illuminate\Validation\Rule;",
        'body' => <<<'PHP'
        $request->validate([
            'enabled' => 'required|boolean',
        ]);

        $validCategories = ['order_updates', 'promotion_emails', 'nutrition_insights', 'price_alerts'];
        if (!in_array($category, $validCategories)) {
            return self::errorResponse('Invalid notification category', [], 400);
        }

        $user = $request->user();
        $settings = $user->initializeNotificationSettings();
        $settings->update([$category => $request->boolean('enabled')]);

        return self::successResponse("Category '{$category}' updated successfully", [
            'category' => $category,
            'enabled' => $request->boolean('enabled')
        ], 200);
PHP
    ],
];

foreach ($controllers as $controller => $data) {
    $path = "$baseDir/Http/Controllers/User/NotificationSettings/$controller/$controller.php";
    createDir("$baseDir/Http/Controllers/User/NotificationSettings/$controller");

    $param = 'Request $request';
    if ($controller === 'UpdateNotificationCategoryController') {
        $param = 'Request $request, string $category';
    }

    $content = <<<PHP
<?php

namespace App\Http\Controllers\User\NotificationSettings\\$controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
{$data['use']}

class $controller extends Controller
{
    use ApiResponse;

    public function __invoke($param): JsonResponse
    {
{$data['body']}
    }
}
PHP;
    file_put_contents($path, $content);
}

// Routes update
$file = __DIR__.'/../routes/api.php';
$content = file_get_contents($file);

$imports = [
    'use App\Http\Controllers\User\NotificationSettings\GetNotificationSettingsController\GetNotificationSettingsController;',
    'use App\Http\Controllers\User\NotificationSettings\UpdateNotificationSettingsController\UpdateNotificationSettingsController;',
    'use App\Http\Controllers\User\NotificationSettings\UpdateNotificationCategoryController\UpdateNotificationCategoryController;',
];
$content = str_replace('use App\Http\Controllers\Api\NotificationSettingsController;', implode("\n", $imports), $content);
$content = str_replace("Route::get('/notifications/settings', [NotificationSettingsController::class, 'index']);", "Route::get('/notifications/settings', GetNotificationSettingsController::class);", $content);
$content = str_replace("Route::put('/notifications/settings', [NotificationSettingsController::class, 'update']);", "Route::put('/notifications/settings', UpdateNotificationSettingsController::class);", $content);
$content = str_replace("Route::patch('/notifications/settings/{category}', [NotificationSettingsController::class, 'updateCategory']);", "Route::patch('/notifications/settings/{category}', UpdateNotificationCategoryController::class);", $content);

file_put_contents($file, $content);

@unlink("$baseDir/Http/Controllers/Api/NotificationSettingsController.php");

echo "NotificationSettings Domain completed.\n";
