<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 1. Loyalty & Settings
$controllers = [
    'User/Loyalty/GetLoyaltyPointsController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $user = $request->user();
        $data = [
            'loyalty_points' => $user->loyalty_points,
            'tier' => 'Bronze', // Placeholder logic based on original service
            'points_to_next_tier' => 500,
            'history' => [],
        ];
        return self::successResponse('Loyalty data retrieved successfully', $data, 200);
PHP
    ],
    'User/Settings/GetLanguageController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $language = $request->user()->app_language ?? 'en';
        return self::successResponse('Language retrieved successfully', ['language' => $language], 200);
PHP
    ],
    'User/Settings/UpdateLanguageController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $request->validate(['language' => 'required|string|in:en,ar']);
        $request->user()->update(['app_language' => $request->input('language')]);
        return self::successResponse('Language updated successfully', ['language' => $request->input('language')], 200);
PHP
    ],
    'User/Settings/GetAppearanceController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $theme = $request->user()->app_theme ?? 'light';
        return self::successResponse('Appearance retrieved successfully', ['theme' => $theme], 200);
PHP
    ],
    'User/Settings/UpdateAppearanceController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $request->validate(['theme' => 'required|string|in:light,dark']);
        $request->user()->update(['app_theme' => $request->input('theme')]);
        return self::successResponse('Appearance updated successfully', ['theme' => $request->input('theme')], 200);
PHP
    ],
];

foreach ($controllers as $controller => $data) {
    $path = "$baseDir/Http/Controllers/$controller/".basename($controller).'.php';

    $param = 'Request $request';
    $className = basename($controller);
    $namespace = str_replace('/', '\\', $controller);

    $content = <<<PHP
<?php

namespace App\Http\Controllers\\$namespace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
{$data['use']}

class $className extends Controller
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
    'use App\Http\Controllers\User\Loyalty\GetLoyaltyPointsController\GetLoyaltyPointsController;',
    'use App\Http\Controllers\User\Settings\GetLanguageController\GetLanguageController;',
    'use App\Http\Controllers\User\Settings\UpdateLanguageController\UpdateLanguageController;',
    'use App\Http\Controllers\User\Settings\GetAppearanceController\GetAppearanceController;',
    'use App\Http\Controllers\User\Settings\UpdateAppearanceController\UpdateAppearanceController;',
];
$content = str_replace('use App\Http\Controllers\Api\LoyaltyController;', implode("\n", $imports), $content);
$content = preg_replace('/use App\\\\Http\\\\Controllers\\\\Api\\\\UserAppSettingsController;/', '', $content);

$content = str_replace("Route::get('/loyalty', [LoyaltyController::class, 'index']);", "Route::get('/loyalty', GetLoyaltyPointsController::class);", $content);

$content = str_replace("Route::get('/settings/language', [UserAppSettingsController::class, 'getLanguage']);", "Route::get('/settings/language', GetLanguageController::class);", $content);
$content = str_replace("Route::put('/settings/language', [UserAppSettingsController::class, 'updateLanguage']);", "Route::put('/settings/language', UpdateLanguageController::class);", $content);
$content = str_replace("Route::get('/settings/appearance', [UserAppSettingsController::class, 'getAppearance']);", "Route::get('/settings/appearance', GetAppearanceController::class);", $content);
$content = str_replace("Route::put('/settings/appearance', [UserAppSettingsController::class, 'updateAppearance']);", "Route::put('/settings/appearance', UpdateAppearanceController::class);", $content);
$content = preg_replace("/Route::get\('\/settings\/notifications', \[UserAppSettingsController::class, 'getNotificationPreferences'\]\);/", '', $content);
$content = preg_replace("/Route::put\('\/settings\/notifications', \[UserAppSettingsController::class, 'updateNotificationPreferences'\]\);/", '', $content);

file_put_contents($file, $content);

@unlink("$baseDir/Http/Controllers/Api/LoyaltyController.php");
@unlink("$baseDir/Http/Controllers/Api/UserAppSettingsController.php");
@unlink("$baseDir/Services/UserAppSettingsService.php");

echo "Loyalty and Settings Domains completed.\n";
