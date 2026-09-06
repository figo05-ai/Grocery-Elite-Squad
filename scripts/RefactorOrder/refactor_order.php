<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 1. Resources
createDir("$baseDir/Http/Resources/Order/OrderResource");
$content = <<<PHP
<?php
namespace App\Http\Resources\Order\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\Address\AddressResource\AddressResource;
use App\Http\Resources\Catalog\Meal\MealResource\MealResource;

class OrderResource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        return [
            'id' => \$this->id,
            'order_number' => \$this->order_number,
            'payment_method' => \$this->payment_method,
            'stripe_payment_intent_id' => \$this->stripe_payment_intent_id,
            'delivery_type' => \$this->delivery_type,
            'status' => \$this->status,
            'status_position' => \$this->status_position,
            'status_description' => \$this->status_description,
            'items' => \$this->whenLoaded('items', function () {
                return \$this->items->map(fn(\$item) => [
                    'id' => \$item->id,
                    'meal' => new MealResource(\$item->meal),
                    'quantity' => \$item->quantity,
                    'unit_price' => (float) \$item->unit_price,
                    'discount_amount' => (float) \$item->discount_amount,
                    'subtotal' => (float) \$item->subtotal,
                ]);
            }),
            'address' => \$this->whenLoaded('address', fn() => new AddressResource(\$this->address)),
            'subtotal' => \$this->subtotal,
            'tax' => \$this->tax,
            'discount' => \$this->discount,
            'shipping_fee' => (float) (\$this->shipping_fee ?? 0),
            'total' => \$this->total,
            'notes' => \$this->notes,
            'created_at' => \$this->created_at,
            'updated_at' => \$this->updated_at,
            'placed_at' => \$this->placed_at,
            'processing_at' => \$this->processing_at,
            'shipping_at' => \$this->shipping_at,
            'out_for_delivery_at' => \$this->out_for_delivery_at,
            'delivered_at' => \$this->delivered_at,
            'estimated_delivery_time' => \$this->estimated_delivery_time,
            'special_note' => \$this->special_note,
            'schedule_delivery' => \$this->schedule_delivery,
            'delivery_speed' => \$this->delivery_speed,
        ];
    }
}
PHP;
file_put_contents("$baseDir/Http/Resources/Order/OrderResource/OrderResource.php", $content);

// 2. PaymentGatewayInterface & Stripe implementation
createDir("$baseDir/Services/Order/Payment");
$content = <<<PHP
<?php
namespace App\Services\Order\Payment;
use App\Models\User\User\User;

interface PaymentGatewayInterface
{
    public function charge(User \$user, float \$amount, string \$paymentMethodId): array;
}
PHP;
file_put_contents("$baseDir/Services/Order/Payment/PaymentGatewayInterface.php", $content);

createDir("$baseDir/Infrastructure/Payment");
$content = <<<PHP
<?php
namespace App\Infrastructure\Payment;

use App\Services\Order\Payment\PaymentGatewayInterface;
use App\Models\User\User\User;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePaymentGateway implements PaymentGatewayInterface
{
    public function charge(User \$user, float \$amount, string \$paymentMethodId): array
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        if (!\$user->stripe_customer_id) {
            return ['success' => false, 'message' => 'Stripe customer not found. Please add a payment method first.'];
        }

        try {
            \$paymentIntent = PaymentIntent::create([
                'amount' => (int)(\$amount * 100),
                'currency' => 'usd',
                'customer' => \$user->stripe_customer_id,
                'payment_method' => \$paymentMethodId,
                'off_session' => true,
                'confirm' => true,
            ]);

            if (\$paymentIntent->status !== 'succeeded') {
                return ['success' => false, 'message' => 'Payment failed: ' . \$paymentIntent->status];
            }

            return ['success' => true, 'transaction_id' => \$paymentIntent->id];
        } catch (\Exception \$e) {
            return ['success' => false, 'message' => 'Payment processing failed: ' . \$e->getMessage()];
        }
    }
}
PHP;
file_put_contents("$baseDir/Infrastructure/Payment/StripePaymentGateway.php", $content);

// Bind interface to implementation
$provider = "$baseDir/Providers/AppServiceProvider.php";
if (file_exists($provider)) {
    $content = file_get_contents($provider);
    if (! str_contains($content, 'PaymentGatewayInterface::class')) {
        $content = str_replace(
            "public function register(): void\n    {",
            "public function register(): void\n    {\n        \$this->app->bind(\\App\\Services\\Order\\Payment\\PaymentGatewayInterface::class, \\App\\Infrastructure\\Payment\\StripePaymentGateway::class);",
            $content
        );
        file_put_contents($provider, $content);
    }
}

// 3. CreateOrderService
createDir("$baseDir/Services/Order/CreateOrderService");
$content = <<<PHP
<?php
namespace App\Services\Order\CreateOrderService;

use App\Models\User\User\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderNote;
use App\Services\ShippingService;
use App\Services\Order\Payment\PaymentGatewayInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class CreateOrderService
{
    public function __construct(
        private readonly ShippingService \$shippingService,
        private readonly PaymentGatewayInterface \$paymentGateway
    ) {}

    public function execute(User \$user, array \$validated): Order
    {
        \$cart = \$user->activeCart()->with('items.meal')->first();
        if (!\$cart || \$cart->isEmpty()) {
            throw new Exception('Your cart is empty. Please add items to your cart before placing an order.');
        }

        \$items = [];
        \$subtotal = 0;
        foreach (\$cart->items as \$cartItem) {
            \$meal = \$cartItem->meal;
            if (!\$meal || !\$meal->is_available) {
                throw new Exception("One or more items in your cart are no longer available.");
            }
            if (\$meal->stock_quantity < \$cartItem->quantity) {
                throw new Exception("Only {\$meal->stock_quantity} items available for '{\$meal->title}'");
            }
            \$maxPerProduct = config('cart.max_quantity_per_product', 10);
            if (\$cartItem->quantity > \$maxPerProduct) {
                throw new Exception("Maximum {\$maxPerProduct} units per product allowed.");
            }
            \$items[] = [
                'meal' => \$meal,
                'quantity' => \$cartItem->quantity,
                'unit_price' => \$cartItem->unit_price,
                'discount_amount' => \$cartItem->discount_amount,
                'subtotal' => \$cartItem->subtotal,
            ];
        }

        \$cart->calculateTotals();
        \$shippingFee = \$this->shippingService->calculateShippingFee((float) \$cart->subtotal, \$validated['delivery_type']);
        \$total = (float) \$cart->subtotal + (float) \$cart->tax + \$shippingFee;

        return DB::transaction(function () use (\$user, \$validated, \$cart, \$items, \$total, \$shippingFee) {
            \$stripePaymentIntentId = null;

            // Handle Inline Card Payment
            if (\$validated['payment_method'] === 'card') {
                \$paymentResult = \$this->paymentGateway->charge(\$user, \$total, \$validated['payment_method_id']);
                if (!\$paymentResult['success']) {
                    throw new Exception(\$paymentResult['message']);
                }
                \$stripePaymentIntentId = \$paymentResult['transaction_id'];
            }

            \$isHostedStripe = \$validated['payment_method'] === 'stripe_checkout';

            \$order = Order::create([
                'user_id' => \$user->id,
                'address_id' => \$validated['delivery_type'] === 'delivery' ? \$validated['address_id'] : null,
                'payment_method' => \$validated['payment_method'],
                'stripe_payment_intent_id' => \$stripePaymentIntentId,
                'delivery_type' => \$validated['delivery_type'],
                'status' => \$isHostedStripe ? 'awaiting_payment' : 'placed',
                'subtotal' => \$cart->subtotal,
                'tax' => \$cart->tax,
                'discount' => \$cart->discount,
                'shipping_fee' => \$shippingFee,
                'total' => \$total,
                'notes' => \$validated['notes'] ?? null,
                'placed_at' => \$isHostedStripe ? null : now(),
            ]);

            foreach (\$items as \$item) {
                OrderItem::create([
                    'order_id' => \$order->id,
                    'meal_id' => \$item['meal']->id,
                    'quantity' => \$item['quantity'],
                    'unit_price' => \$item['unit_price'],
                    'discount_amount' => \$item['discount_amount'],
                    'subtotal' => \$item['subtotal'],
                ]);
                \$item['meal']->decrement('stock_quantity', \$item['quantity']);
            }

            // Clear Cart
            \$cart->items()->delete();
            \$cart->update(['status' => 'completed']);

            // Order Notes
            if (isset(\$validated['special_note_id'])) {
                OrderNote::create([
                    'order_id' => \$order->id,
                    'special_note_id' => \$validated['special_note_id'],
                    'notes' => \$validated['notes'] ?? null,
                ]);
            } elseif (isset(\$validated['notes'])) {
                OrderNote::create([
                    'order_id' => \$order->id,
                    'notes' => \$validated['notes'],
                ]);
            }

            return \$order;
        });
    }
}
PHP;
file_put_contents("$baseDir/Services/Order/CreateOrderService/CreateOrderService.php", $content);

// 4. Controllers
$controllers = [
    'GetOrdersController' => [
        'use' => "use App\Models\Order;\nuse App\Http\Resources\Order\OrderResource\OrderResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $user = $request->user();
        $orders = Order::where('user_id', $user->id)->with(['items.meal.category', 'items.meal.subcategory', 'address'])->orderBy('created_at', 'desc')->get();
        return self::successResponse('Orders retrieved successfully', [
            'data' => OrderResource::collection($orders),
            'total_count' => $orders->count()
        ], 200);
PHP
    ],
    'GetOrderController' => [
        'use' => "use App\Models\Order;\nuse App\Http\Resources\Order\OrderResource\OrderResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $order = Order::where('user_id', $request->user()->id)->with(['items.meal', 'address'])->findOrFail($id);
        return self::successResponse('Order retrieved successfully', new OrderResource($order), 200);
PHP
    ],
    'CreateOrderController' => [
        'use' => "use App\Http\Requests\StoreOrderRequest;\nuse App\Services\Order\CreateOrderService\CreateOrderService;\nuse App\Http\Resources\Order\OrderResource\OrderResource;\nuse App\Traits\V1\ApiResponse;\nuse Exception;",
        'body' => <<<'PHP'
        try {
            $service = app(CreateOrderService::class);
            $order = $service->execute($request->user(), $request->validated());
            $order->load(['items.meal', 'address']);
            return self::successResponse('Order created successfully', new OrderResource($order), 201);
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage(), [], 400);
        }
PHP
    ],
    'TrackOrderController' => [
        'use' => "use App\Models\Order;\nuse App\Http\Resources\Order\OrderResource\OrderResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $user = $request->user();
        $order = Order::where('user_id', $user->id)
            ->whereNotIn('status', ['cancelled', 'delivered'])
            ->with(['items.meal.category', 'items.meal.subcategory', 'address'])
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$order) {
            return self::errorResponse('No active order found', [], 404);
        }

        if ($order->status === 'awaiting_payment') {
            return self::successResponse('Order is waiting for payment. Complete checkout to continue.', [
                'order' => new OrderResource($order),
                'awaiting_payment' => true,
                'tracking' => null,
            ], 200);
        }

        $tracking = [
            'position' => $order->status_position,
            'status' => $order->status,
            'status_description' => $order->status_description,
            'positions' => [
                ['position' => 1, 'status' => 'placed', 'label' => 'Order Placed', 'completed' => in_array($order->status, ['placed', 'processing', 'shipping', 'out_for_delivery', 'delivered']), 'timestamp' => $order->placed_at],
                ['position' => 2, 'status' => 'processing', 'label' => 'Processing', 'completed' => in_array($order->status, ['processing', 'shipping', 'out_for_delivery', 'delivered']), 'timestamp' => $order->processing_at],
                ['position' => 3, 'status' => 'shipping', 'label' => 'Shipping', 'completed' => in_array($order->status, ['shipping', 'out_for_delivery', 'delivered']), 'timestamp' => $order->shipping_at],
                ['position' => 4, 'status' => 'out_for_delivery', 'label' => 'Out for Delivery', 'completed' => in_array($order->status, ['out_for_delivery', 'delivered']), 'timestamp' => $order->out_for_delivery_at],
                ['position' => 5, 'status' => 'delivered', 'label' => 'Delivered', 'completed' => $order->status === 'delivered', 'timestamp' => $order->delivered_at],
            ]
        ];

        return self::successResponse('Order tracking retrieved successfully', [
            'order' => new OrderResource($order),
            'tracking' => $tracking,
        ], 200);
PHP
    ],
];

foreach ($controllers as $controller => $data) {
    createDir("$baseDir/Http/Controllers/Order/$controller");
    $param = 'Request $request';
    if ($controller === 'CreateOrderController') {
        $param = 'StoreOrderRequest $request';
    }
    if ($controller === 'GetOrderController') {
        $param = 'Request $request, string $id';
    }

    $content = <<<PHP
<?php
namespace App\Http\Controllers\Order\\$controller;
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
    file_put_contents("$baseDir/Http/Controllers/Order/$controller/$controller.php", $content);
}

// Ensure the new routes are mapped
$file = __DIR__.'/../routes/api.php';
$content = file_get_contents($file);

$imports = [
    'use App\Http\Controllers\Order\GetOrdersController\GetOrdersController;',
    'use App\Http\Controllers\Order\GetOrderController\GetOrderController;',
    'use App\Http\Controllers\Order\CreateOrderController\CreateOrderController;',
    'use App\Http\Controllers\Order\TrackOrderController\TrackOrderController;',
];
$content = preg_replace('/use App\\\\Http\\\\Controllers\\\\Api\\\\OrderController;/', implode("\n", $imports), $content);

$content = str_replace("Route::get('/orders', [OrderController::class, 'index']);", "Route::get('/orders', GetOrdersController::class);", $content);
$content = str_replace("Route::post('/orders', [OrderController::class, 'store']);", "Route::post('/orders', CreateOrderController::class);", $content);
$content = str_replace("Route::get('/orders/track', [OrderController::class, 'track']);", "Route::get('/orders/track', TrackOrderController::class);", $content);
$content = str_replace("Route::get('/orders/{order}', [OrderController::class, 'show']);", "Route::get('/orders/{order}', GetOrderController::class);", $content);

file_put_contents($file, $content);
@unlink("$baseDir/Http/Controllers/Api/OrderController.php");

echo "Order Domain controllers completed.\n";
