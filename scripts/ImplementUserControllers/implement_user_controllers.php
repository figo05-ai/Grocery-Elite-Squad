<?php

$baseDir = __DIR__.'/../app';

$controllers = [
    'User/Profile/GetProfileController' => <<<PHP
<?php
namespace App\Http\Controllers\User\Profile\GetProfileController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\Auth\MeResponse\MeResponse;
use Illuminate\Http\JsonResponse;

class GetProfileController extends Controller
{
    public function __invoke(Request \$request): JsonResponse
    {
        return MeResponse::make(\$request->user());
    }
}
PHP,
    'User/Favorite/GetFavoritesController' => <<<PHP
<?php
namespace App\Http\Controllers\User\Favorite\GetFavoritesController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\Shared\SuccessResponse;
use Illuminate\Http\JsonResponse;

class GetFavoritesController extends Controller
{
    public function __invoke(Request \$request): JsonResponse
    {
        \$user = \$request->user();
        \$favorites = \$user->favorites()->with('meal')->get();
        return SuccessResponse::make('Favorites retrieved successfully', ['favorites' => \$favorites], 200);
    }
}
PHP,
    'User/Favorite/ToggleFavoriteController' => <<<PHP
<?php
namespace App\Http\Controllers\User\Favorite\ToggleFavoriteController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User\Favorite\ToggleFavoriteService\ToggleFavoriteService;
use App\Http\Responses\Shared\SuccessResponse;
use Illuminate\Http\JsonResponse;

class ToggleFavoriteController extends Controller
{
    public function __construct(protected ToggleFavoriteService \$service) {}
    public function __invoke(Request \$request, string \$mealId): JsonResponse
    {
        \$result = \$this->service->execute(\$request->user(), \$mealId);
        return SuccessResponse::make(\$result['message'], ['is_favorite' => \$result['is_favorite']], 200);
    }
}
PHP,
    'User/Loyalty/GetLoyaltyPointsController' => <<<PHP
<?php
namespace App\Http\Controllers\User\Loyalty\GetLoyaltyPointsController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LoyaltyService;
use App\Http\Responses\Shared\SuccessResponse;
use Illuminate\Http\JsonResponse;

class GetLoyaltyPointsController extends Controller
{
    public function __construct(protected LoyaltyService \$service) {}
    public function __invoke(Request \$request): JsonResponse
    {
        \$data = \$this->service->getLoyaltyData(\$request->user());
        return SuccessResponse::make('Loyalty data retrieved successfully', \$data, 200);
    }
}
PHP,
];

foreach ($controllers as $controller => $content) {
    $parts = explode('/', $controller);
    $className = end($parts);
    if (! is_dir("$baseDir/Http/Controllers/$controller")) {
        mkdir("$baseDir/Http/Controllers/$controller", 0755, true);
    }
    file_put_contents("$baseDir/Http/Controllers/$controller/$className.php", $content);
}

// Favorite Service
if (! is_dir("$baseDir/Services/User/Favorite/ToggleFavoriteService")) {
    mkdir("$baseDir/Services/User/Favorite/ToggleFavoriteService", 0755, true);
}
$content = <<<PHP
<?php
namespace App\Services\User\Favorite\ToggleFavoriteService;

use App\Models\User\User\User;

class ToggleFavoriteService
{
    public function execute(User \$user, string \$mealId): array
    {
        \$favorite = \$user->favorites()->where('meal_id', \$mealId)->first();
        if (\$favorite) {
            \$favorite->delete();
            return ['message' => 'Meal removed from favorites', 'is_favorite' => false];
        } else {
            \$user->favorites()->create(['meal_id' => \$mealId]);
            return ['message' => 'Meal added to favorites', 'is_favorite' => true];
        }
    }
}
PHP;
file_put_contents("$baseDir/Services/User/Favorite/ToggleFavoriteService/ToggleFavoriteService.php", $content);

echo "Partial User Domain Controllers & Services implemented.\n";
