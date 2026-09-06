<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// Create Services
$services = [
    'User/Address/CreateAddressService',
    'User/Address/UpdateAddressService',
    'User/Address/DeleteAddressService',
    'User/Address/SetDefaultAddressService',
    'User/Profile/UpdateProfileInfoService',
    'User/Profile/UpdateProfileImageService',
    'User/Profile/DeleteProfileImageService',
    'User/Favorite/ToggleFavoriteService',
    'User/Favorite/RemoveFavoriteService',
    'User/Data/ExportUserDataService',
    'User/Data/DeleteUserDataService',
];

foreach ($services as $service) {
    $dir = "$baseDir/Services/$service";
    createDir($dir);

    $parts = explode('/', $service);
    $className = end($parts);
    $namespace = str_replace('/', '\\', $service);

    $content = <<<PHP
<?php

namespace App\Services\\$namespace;

class $className
{
    public function execute()
    {
        // Implementation
    }
}
PHP;
    file_put_contents("$dir/$className.php", $content);
}

// Create Controllers
$controllers = [
    'User/Address/GetAddressesController',
    'User/Address/CreateAddressController',
    'User/Address/GetAddressController',
    'User/Address/UpdateAddressController',
    'User/Address/DeleteAddressController',
    'User/Address/SetDefaultAddressController',

    'User/Profile/GetProfileController',
    'User/Profile/UpdateProfileImageController',
    'User/Profile/UpdateProfileInfoController',
    'User/Profile/DeleteProfileImageController',
    'User/Profile/GetUserSessionsController',
    'User/Profile/DestroyUserSessionController',

    'User/Favorite/GetFavoritesController',
    'User/Favorite/ToggleFavoriteController',
    'User/Favorite/CheckFavoriteController',
    'User/Favorite/RemoveFavoriteController',

    'User/Loyalty/GetLoyaltyPointsController',

    'User/Settings/GetLanguageController',
    'User/Settings/UpdateLanguageController',
    'User/Settings/GetAppearanceController',
    'User/Settings/UpdateAppearanceController',
    'User/Settings/GetNotificationPreferencesController',
    'User/Settings/UpdateNotificationPreferencesController',

    'User/NotificationSettings/GetNotificationSettingsController',
    'User/NotificationSettings/UpdateNotificationSettingsController',
    'User/NotificationSettings/UpdateNotificationCategoryController',
];

foreach ($controllers as $controller) {
    $dir = "$baseDir/Http/Controllers/$controller";
    createDir($dir);

    $parts = explode('/', $controller);
    $className = end($parts);
    $namespace = str_replace('/', '\\', $controller);

    $content = <<<PHP
<?php

namespace App\Http\Controllers\\$namespace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class $className extends Controller
{
    public function __invoke(Request \$request): JsonResponse
    {
        return response()->json(['message' => 'Not implemented yet']);
    }
}
PHP;
    file_put_contents("$dir/$className.php", $content);
}

// Move Requests
$requestsToMove = [
    'AddressRequest' => 'User/Address',
];

foreach ($requestsToMove as $request => $domainPath) {
    $oldPath = "$baseDir/Http/Requests/$request.php";
    $newDir = "$baseDir/Http/Requests/$domainPath/$request";
    createDir($newDir);
    $newPath = "$newDir/$request.php";

    if (file_exists($oldPath)) {
        $content = file_get_contents($oldPath);
        $newNamespace = str_replace('/', '\\', $domainPath);
        $content = str_replace("namespace App\Http\Requests;", "namespace App\Http\Requests\\$newNamespace\\$request;", $content);
        file_put_contents($newPath, $content);
        unlink($oldPath);
    }
}

echo "User domain scaffolding created.\n";
