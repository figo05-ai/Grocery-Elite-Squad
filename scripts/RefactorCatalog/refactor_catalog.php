<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 1. Resources
createDir("$baseDir/Http/Resources/Catalog/Category/CategoryResource");
$content = <<<PHP
<?php
namespace App\Http\Resources\Catalog\Category\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        return [
            'id' => \$this->id,
            'name' => \$this->name,
            'slug' => \$this->slug,
            'description' => \$this->description,
            'image_url' => \$this->image_url,
            'banner_url' => \$this->banner_url,
            'status' => \$this->status,
            'sort_order' => \$this->sort_order,
            'is_featured' => \$this->is_featured,
            'created_at' => \$this->created_at,
        ];
    }
}
PHP;
file_put_contents("$baseDir/Http/Resources/Catalog/Category/CategoryResource/CategoryResource.php", $content);

createDir("$baseDir/Http/Resources/Catalog/Subcategory/SubcategoryResource");
$content = <<<PHP
<?php
namespace App\Http\Resources\Catalog\Subcategory\SubcategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryResource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        return [
            'id' => \$this->id,
            'category_id' => \$this->category_id,
            'name' => \$this->name,
            'slug' => \$this->slug,
            'description' => \$this->description,
            'image_url' => \$this->image_url,
            'status' => \$this->status,
            'sort_order' => \$this->sort_order,
            'created_at' => \$this->created_at,
        ];
    }
}
PHP;
file_put_contents("$baseDir/Http/Resources/Catalog/Subcategory/SubcategoryResource/SubcategoryResource.php", $content);

createDir("$baseDir/Http/Resources/Catalog/Meal/MealResource");
$content = <<<PHP
<?php
namespace App\Http\Resources\Catalog\Meal\MealResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Catalog\Category\CategoryResource\CategoryResource;
use App\Http\Resources\Catalog\Subcategory\SubcategoryResource\SubcategoryResource;

class MealResource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        \$user = \$request->user('sanctum');
        \$isFavorited = false;
        
        // This could be optimized if favorite_meal_ids is passed in via additional data or loaded relation
        if (\$user && \$this->relationLoaded('favorites')) {
            \$isFavorited = \$this->favorites->where('user_id', \$user->id)->isNotEmpty();
        }

        return [
            'id' => \$this->id,
            'title' => \$this->title,
            'slug' => \$this->slug,
            'description' => \$this->description,
            'image_url' => \$this->image_url,
            'offer_title' => \$this->offer_title,
            ...\$this->getApiPriceAttributes(),
            'has_offer' => \$this->hasOffer(),
            'rating' => (float) \$this->rating,
            'rating_count' => (int) \$this->rating_count,
            'size' => \$this->size,
            'brand' => \$this->brand,
            'stock_quantity' => (int) \$this->stock_quantity,
            'in_stock' => \$this->isInStock(),
            'is_featured' => \$this->is_featured,
            'sold_count' => \$this->sold_count,
            'category' => \$this->whenLoaded('category', fn() => new CategoryResource(\$this->category)),
            'subcategory' => \$this->whenLoaded('subcategory', fn() => new SubcategoryResource(\$this->subcategory)),
            'features' => \$this->features,
            'is_favorited' => \$isFavorited,
            'recommendation_reason' => \$this->additional['recommendation_reason'] ?? null,
            'created_at' => \$this->created_at,
        ];
    }
}
PHP;
file_put_contents("$baseDir/Http/Resources/Catalog/Meal/MealResource/MealResource.php", $content);

// 2. Controllers
// Categories
$categoryControllers = [
    'GetCategoriesController' => [
        'use' => "use App\Models\Category;\nuse App\Http\Resources\Catalog\Category\CategoryResource\CategoryResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $query = Category::active();
        if ($request->boolean('featured')) {
            $query->featured();
        }
        $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
        $categories = $query->get();
        return self::successResponse('Categories retrieved successfully', CategoryResource::collection($categories), 200);
PHP
    ],
    'GetCategoryController' => [
        'use' => "use App\Models\Category;\nuse App\Http\Resources\Catalog\Category\CategoryResource\CategoryResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $category = Category::with(['subcategories' => function($q) {
            $q->active()->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
        }])->active()->findOrFail($id);
        return self::successResponse('Category retrieved successfully', new CategoryResource($category), 200);
PHP
    ],
];

foreach ($categoryControllers as $controller => $data) {
    createDir("$baseDir/Http/Controllers/Catalog/Category/$controller");
    $param = 'Request $request';
    if ($controller === 'GetCategoryController') {
        $param = 'Request $request, string $id';
    }

    $content = <<<PHP
<?php
namespace App\Http\Controllers\Catalog\Category\\$controller;
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
    file_put_contents("$baseDir/Http/Controllers/Catalog/Category/$controller/$controller.php", $content);
}

// Meals
$mealControllers = [
    'GetMealsController' => [
        'use' => "use App\Models\Meal;\nuse App\Http\Resources\Catalog\Meal\MealResource\MealResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $query = Meal::with(['category', 'subcategory'])->available();
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(fn($q) => $q->where('title', 'like', "%$search%")->orWhere('description', 'like', "%$search%"));
        }
        if ($request->has('category_id')) $query->where('category_id', $request->input('category_id'));
        if ($request->has('subcategory_id')) $query->where('subcategory_id', $request->input('subcategory_id'));
        
        $meals = $query->orderBy('created_at', 'desc')->paginate(20);
        return self::successResponse('Meals retrieved successfully', MealResource::collection($meals), 200);
PHP
    ],
    'GetMealController' => [
        'use' => "use App\Models\Meal;\nuse App\Http\Resources\Catalog\Meal\MealResource\MealResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $meal = Meal::with(['category', 'subcategory'])->available()->findOrFail($id);
        return self::successResponse('Meal retrieved successfully', new MealResource($meal), 200);
PHP
    ],
    'GetDealsOfTheDayController' => [
        'use' => "use App\Models\Meal;\nuse App\Http\Resources\Catalog\Meal\MealResource\MealResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $meals = Meal::with('category')->available()->withActiveDiscount()->orderBy('created_at', 'desc')->get();
        return self::successResponse("Today's deals retrieved successfully", MealResource::collection($meals), 200);
PHP
    ],
];

foreach ($mealControllers as $controller => $data) {
    createDir("$baseDir/Http/Controllers/Catalog/Meal/$controller");
    $param = 'Request $request';
    if ($controller === 'GetMealController') {
        $param = 'Request $request, string $id';
    }

    $content = <<<PHP
<?php
namespace App\Http\Controllers\Catalog\Meal\\$controller;
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
    file_put_contents("$baseDir/Http/Controllers/Catalog/Meal/$controller/$controller.php", $content);
}

// Routes update
$file = __DIR__.'/../routes/api.php';
$content = file_get_contents($file);

$imports = [
    'use App\Http\Controllers\Catalog\Category\GetCategoriesController\GetCategoriesController;',
    'use App\Http\Controllers\Catalog\Category\GetCategoryController\GetCategoryController;',
    'use App\Http\Controllers\Catalog\Meal\GetMealsController\GetMealsController;',
    'use App\Http\Controllers\Catalog\Meal\GetMealController\GetMealController;',
    'use App\Http\Controllers\Catalog\Meal\GetDealsOfTheDayController\GetDealsOfTheDayController;',
];
$content = preg_replace('/use App\\\\Http\\\\Controllers\\\\Api\\\\CategoryController;/', '', $content);
$content = preg_replace('/use App\\\\Http\\\\Controllers\\\\Api\\\\MealController;/', '', $content);
$content = implode("\n", $imports)."\n".$content;

$content = str_replace("Route::get('/categories', [CategoryController::class, 'index']);", "Route::get('/categories', GetCategoriesController::class);", $content);
$content = str_replace("Route::get('/categories/{id}', [CategoryController::class, 'show']);", "Route::get('/categories/{id}', GetCategoryController::class);", $content);
$content = preg_replace("/Route::get\('\/categories\/\{id\}\/meals', \[CategoryController::class, 'meals'\]\);/", '', $content);

$content = str_replace("Route::get('/meals', [MealController::class, 'index']);", "Route::get('/meals', GetMealsController::class);", $content);
$content = str_replace("Route::get('/meals/today', [MealController::class, 'today']);", "Route::get('/meals/today', GetDealsOfTheDayController::class);", $content);
$content = str_replace("Route::get('/meals/{id}', [MealController::class, 'show']);", "Route::get('/meals/{id}', GetMealController::class);", $content);

file_put_contents($file, $content);

echo "Catalog Domain initial controllers completed.\n";
