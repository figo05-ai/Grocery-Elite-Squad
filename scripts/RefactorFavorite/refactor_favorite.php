<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// Favorite Domain

// 1. Move Favorite Model
if (file_exists("$baseDir/Models/Favorite.php")) {
    createDir("$baseDir/Models/User/Favorite");
    $content = file_get_contents("$baseDir/Models/Favorite.php");
    $content = str_replace("namespace App\Models;", "namespace App\Models\User\Favorite;", $content);
    file_put_contents("$baseDir/Models/User/Favorite/Favorite.php", $content);
    unlink("$baseDir/Models/Favorite.php");
}

// 2. Favorite Resource
createDir("$baseDir/Http/Resources/User/Favorite/FavoriteResource");
$content = <<<PHP
<?php

namespace App\Http\Resources\User\Favorite\FavoriteResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        \$meal = \$this->meal;

        return [
            'id' => \$meal->id,
            'title' => \$meal->title,
            'slug' => \$meal->slug,
            'image_url' => \$meal->image_url,
            'price' => (float) \$meal->price,
            'has_offer' => \$meal->hasOffer(),
            'category' => \$meal->category ? ['id' => \$meal->category->id, 'name' => \$meal->category->name] : null,
            'is_favorited' => true,
            'favorited_at' => \$this->created_at?->toIso8601String(),
        ];
    }
}
PHP;
file_put_contents("$baseDir/Http/Resources/User/Favorite/FavoriteResource/FavoriteResource.php", $content);

// 3. Favorite Controllers
$controllers = [
    'GetFavoritesController' => [
        'use' => "use App\Http\Resources\User\Favorite\FavoriteResource\FavoriteResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $user = $request->user();
        $favorites = $user->favorites()->with(['meal.category', 'meal.subcategory'])->orderBy('created_at', 'desc')->get();
        return self::successResponse('Favorites retrieved successfully', [
            'favorites' => FavoriteResource::collection($favorites)
        ], 200);
PHP
    ],
    'ToggleFavoriteController' => [
        'use' => "use App\Services\User\Favorite\ToggleFavoriteService\ToggleFavoriteService;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $service = app(ToggleFavoriteService::class);
        $result = $service->execute($request->user(), $mealId);
        return self::successResponse($result['message'], ['is_favorite' => $result['is_favorite']], 200);
PHP
    ],
    'CheckFavoriteController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $user = $request->user();
        $isFavorite = $user->favorites()->where('meal_id', $mealId)->exists();
        return self::successResponse('Favorite status checked', ['is_favorite' => $isFavorite], 200);
PHP
    ],
    'RemoveFavoriteController' => [
        'use' => "use App\Services\User\Favorite\ToggleFavoriteService\ToggleFavoriteService;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $service = app(ToggleFavoriteService::class);
        $result = $service->execute($request->user(), $mealId); // The service naturally toggles it, but typically we want a direct delete.
        // For simplicity, we just delete here since it's a simple Eloquent query and doesn't orchestrate complex logic.
        // Actually, let's use the DB query directly to avoid "service explosion" for a single line of logic.
        $deleted = $request->user()->favorites()->where('meal_id', $mealId)->delete();
        if ($deleted) {
            return self::successResponse('Meal removed from favorites', ['is_favorite' => false], 200);
        }
        return self::errorResponse('Favorite not found', [], 404);
PHP
    ],
];

foreach ($controllers as $controller => $data) {
    $path = "$baseDir/Http/Controllers/User/Favorite/$controller/$controller.php";
    createDir("$baseDir/Http/Controllers/User/Favorite/$controller");

    $param = 'Request $request';
    if (in_array($controller, ['ToggleFavoriteController', 'CheckFavoriteController', 'RemoveFavoriteController'])) {
        $param = 'Request $request, string $mealId';
    }

    $content = <<<PHP
<?php

namespace App\Http\Controllers\User\Favorite\\$controller;

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

// 4. Update routes
$file = __DIR__.'/../routes/api.php';
$content = file_get_contents($file);

$imports = [
    'use App\Http\Controllers\User\Favorite\GetFavoritesController\GetFavoritesController;',
    'use App\Http\Controllers\User\Favorite\ToggleFavoriteController\ToggleFavoriteController;',
    'use App\Http\Controllers\User\Favorite\CheckFavoriteController\CheckFavoriteController;',
    'use App\Http\Controllers\User\Favorite\RemoveFavoriteController\RemoveFavoriteController;',
];
$content = str_replace('use App\Http\Controllers\Api\FavoriteController;', implode("\n", $imports), $content);
$content = str_replace("Route::get('/favorites', [FavoriteController::class, 'index']);", "Route::get('/favorites', GetFavoritesController::class);", $content);
$content = str_replace("Route::post('/favorites/toggle/{mealId}', [FavoriteController::class, 'toggle']);", "Route::post('/favorites/toggle/{mealId}', ToggleFavoriteController::class);", $content);
$content = str_replace("Route::get('/favorites/check/{mealId}', [FavoriteController::class, 'check']);", "Route::get('/favorites/check/{mealId}', CheckFavoriteController::class);", $content);
$content = str_replace("Route::delete('/favorites/{mealId}', [FavoriteController::class, 'remove']);", "Route::delete('/favorites/{mealId}', RemoveFavoriteController::class);", $content);
file_put_contents($file, $content);
@unlink("$baseDir/Http/Controllers/Api/FavoriteController.php");

echo "Favorite Domain corrections completed.\n";
