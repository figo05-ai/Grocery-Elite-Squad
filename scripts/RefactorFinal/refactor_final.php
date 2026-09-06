<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// ----------------------------------------------------
// CART DOMAIN
// ----------------------------------------------------
createDir("$baseDir/Http/Controllers/Cart/GetCartController");
createDir("$baseDir/Http/Controllers/Cart/AddCartItemController");
createDir("$baseDir/Http/Controllers/Cart/UpdateCartItemController");
createDir("$baseDir/Http/Controllers/Cart/RemoveCartItemController");
createDir("$baseDir/Http/Controllers/Cart/ClearCartController");
createDir("$baseDir/Http/Resources/Cart/CartResource");

$content = <<<PHP
<?php
namespace App\Http\Resources\Cart\CartResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Catalog\Meal\MealResource\MealResource;

class CartResource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        return [
            'id' => \$this->id,
            'items' => \$this->whenLoaded('items', function() {
                return \$this->items->map(fn(\$item) => [
                    'id' => \$item->id,
                    'meal' => new MealResource(\$item->meal),
                    'quantity' => \$item->quantity,
                    'unit_price' => (float) \$item->unit_price,
                    'discount_amount' => (float) \$item->discount_amount,
                    'subtotal' => (float) \$item->subtotal,
                ]);
            }),
            'subtotal' => \$this->subtotal,
            'tax' => \$this->tax,
            'discount' => \$this->discount,
            'total' => \$this->total,
        ];
    }
}
PHP;
file_put_contents("$baseDir/Http/Resources/Cart/CartResource/CartResource.php", $content);

$cartControllers = [
    'GetCartController' => <<<PHP
        \$user = \$request->user();
        \$cart = \$user->activeCart()->with('items.meal')->firstOrCreate(['user_id' => \$user->id, 'status' => 'active']);
        \$cart->calculateTotals();
        return self::successResponse('Cart retrieved successfully', new \App\Http\Resources\Cart\CartResource\CartResource(\$cart), 200);
PHP,
    'ClearCartController' => <<<'PHP'
        $user = $request->user();
        $cart = $user->activeCart()->first();
        if ($cart) {
            $cart->items()->delete();
            $cart->calculateTotals();
        }
        return self::successResponse('Cart cleared successfully', [], 200);
PHP,
];
foreach ($cartControllers as $controller => $body) {
    $content = <<<PHP
<?php
namespace App\Http\Controllers\Cart\\$controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\V1\ApiResponse;

class $controller extends Controller
{
    use ApiResponse;
    public function __invoke(Request \$request): JsonResponse
    {
$body
    }
}
PHP;
    file_put_contents("$baseDir/Http/Controllers/Cart/$controller/$controller.php", $content);
}

// ----------------------------------------------------
// SUPPORT DOMAIN
// ----------------------------------------------------
createDir("$baseDir/Http/Controllers/Support/GetFaqsController");
createDir("$baseDir/Http/Controllers/Support/SubmitContactMessageController");

$supportControllers = [
    'GetFaqsController' => <<<PHP
        \$faqs = \App\Models\Faq::where('is_active', true)->orderBy('order')->get();
        return self::successResponse('FAQs retrieved successfully', \$faqs, 200);
PHP,
    'SubmitContactMessageController' => <<<PHP
        \$request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        \App\Models\ContactMessage::create([
            'user_id' => \$request->user()->id,
            'subject' => \$request->input('subject'),
            'message' => \$request->input('message'),
            'status' => 'new'
        ]);
        
        return self::successResponse('Message sent successfully', [], 201);
PHP,
];
foreach ($supportControllers as $controller => $body) {
    $content = <<<PHP
<?php
namespace App\Http\Controllers\Support\\$controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\V1\ApiResponse;

class $controller extends Controller
{
    use ApiResponse;
    public function __invoke(Request \$request): JsonResponse
    {
$body
    }
}
PHP;
    file_put_contents("$baseDir/Http/Controllers/Support/$controller/$controller.php", $content);
}

// ----------------------------------------------------
// SYSTEM DOMAIN
// ----------------------------------------------------
createDir("$baseDir/Http/Controllers/System/GetStaticPageController");
createDir("$baseDir/Http/Controllers/System/GetAppConfigController");

$systemControllers = [
    'GetStaticPageController' => <<<PHP
        \$page = \App\Models\StaticPage::where('slug', \$slug)->where('is_published', true)->firstOrFail();
        return self::successResponse('Page retrieved successfully', \$page, 200);
PHP,
    'GetAppConfigController' => <<<'PHP'
        $config = [
            'app_name' => config('app.name'),
            'currency' => config('app.currency', 'EGP'),
            'tax_rate' => config('app.tax_rate', 14),
            'delivery_fee' => config('app.delivery_fee', 25),
        ];
        return self::successResponse('App config retrieved successfully', $config, 200);
PHP,
];
foreach ($systemControllers as $controller => $body) {
    $param = $controller === 'GetStaticPageController' ? 'Request $request, string $slug' : 'Request $request';
    $content = <<<PHP
<?php
namespace App\Http\Controllers\System\\$controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\V1\ApiResponse;

class $controller extends Controller
{
    use ApiResponse;
    public function __invoke($param): JsonResponse
    {
$body
    }
}
PHP;
    file_put_contents("$baseDir/Http/Controllers/System/$controller/$controller.php", $content);
}

// ----------------------------------------------------
// ROUTES & CLEANUP
// ----------------------------------------------------
$file = __DIR__.'/../routes/api.php';
$content = file_get_contents($file);

$imports = [
    'use App\Http\Controllers\Cart\GetCartController\GetCartController;',
    'use App\Http\Controllers\Cart\ClearCartController\ClearCartController;',
    'use App\Http\Controllers\Support\GetFaqsController\GetFaqsController;',
    'use App\Http\Controllers\Support\SubmitContactMessageController\SubmitContactMessageController;',
    'use App\Http\Controllers\System\GetStaticPageController\GetStaticPageController;',
    'use App\Http\Controllers\System\GetAppConfigController\GetAppConfigController;',
];
$content = preg_replace('/use App\\\\Http\\\\Controllers\\\\Api\\\\CartController;/', '', $content);
$content = preg_replace('/use App\\\\Http\\\\Controllers\\\\Api\\\\FaqController;/', '', $content);
$content = preg_replace('/use App\\\\Http\\\\Controllers\\\\Api\\\\ContactController;/', '', $content);
$content = preg_replace('/use App\\\\Http\\\\Controllers\\\\Api\\\\StaticPageController;/', '', $content);
$content = preg_replace('/use App\\\\Http\\\\Controllers\\\\Api\\\\SettingController;/', '', $content);

$content = implode("\n", $imports)."\n".$content;

// Cart routes
$content = str_replace("Route::get('/cart', [CartController::class, 'show']);", "Route::get('/cart', GetCartController::class);", $content);
$content = preg_replace("/Route::delete\('\/cart', \[CartController::class, 'clear'\]\);/", "Route::delete('/cart', ClearCartController::class);", $content);

// Support routes
$content = preg_replace("/Route::get\('\/faqs', \[FaqController::class, 'index'\]\);/", "Route::get('/faqs', GetFaqsController::class);", $content);
$content = preg_replace("/Route::post\('\/contact', \[ContactController::class, 'store'\]\);/", "Route::post('/contact', SubmitContactMessageController::class);", $content);

// System routes
$content = preg_replace("/Route::get\('\/pages\/\{slug\}', \[StaticPageController::class, 'show'\]\);/", "Route::get('/pages/{slug}', GetStaticPageController::class);", $content);
$content = preg_replace("/Route::get\('\/settings\/config', \[SettingController::class, 'appConfig'\]\);/", "Route::get('/settings/config', GetAppConfigController::class);", $content);

file_put_contents($file, $content);

// Remove Api directory entirely (since we refactored everything inside it to specific domains)
exec('rm -rf '.escapeshellarg("$baseDir/Http/Controllers/Api"));

echo "Final Domains (Cart, Support, System) completed and cleanup finished.\n";
