<?php

namespace Tests\Feature;

use App\Models\Cart\Cart\Cart;
use App\Models\Cart\CartItem\CartItem;
use App\Models\Catalog\Category\Category;
use App\Models\Catalog\Meal\Meal;
use App\Models\Order\Order\Order;
use App\Models\Order\OrderItem\OrderItem;
use App\Models\User\Address\Address;
use App\Models\User\User\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);

        $this->user = User::factory()->create();
        $this->user->assignRole('customer');
    }

    public function test_user_can_list_orders()
    {
        $address = Address::create([
            'user_id' => $this->user->id,
            'label' => 'Home',
            'full_name' => 'John Doe',
            'phone' => '01012345678',
            'street_address' => '123 St',
            'city' => 'Cairo',
            'state' => 'Cairo',
            'country' => 'Egypt',
            'is_default' => true,
        ]);

        $order = Order::create([
            'user_id' => $this->user->id,
            'address_id' => $address->id,
            'order_number' => 'ORD-12345',
            'payment_method' => 'cash_on_delivery',
            'delivery_type' => 'delivery',
            'status' => 'placed',
            'subtotal' => 10,
            'tax' => 0,
            'delivery_fee' => 0,
            'total' => 10,
        ]);

        $category = Category::create(['name' => 'Cat', 'slug' => 'cat', 'description' => 'Test', 'image' => 'default.png']);
        $meal = Meal::create(['category_id' => $category->id, 'title' => 'Meal', 'slug' => 'meal', 'price' => 10, 'description' => 'Test', 'image' => 'default.png']);

        OrderItem::create([
            'order_id' => $order->id,
            'meal_id' => $meal->id,
            'quantity' => 1,
            'unit_price' => 10,
            'subtotal' => 10,
        ]);

        $response = $this->actingAs($this->user)->getJson('/api/v1/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'data',
                    'total_count',
                ],
            ]);
    }

    public function test_user_can_view_specific_order()
    {
        $address = Address::create([
            'user_id' => $this->user->id,
            'label' => 'Home',
            'full_name' => 'John Doe',
            'phone' => '01012345678',
            'street_address' => '123 St',
            'city' => 'Cairo',
            'state' => 'Cairo',
            'country' => 'Egypt',
            'is_default' => true,
        ]);

        $order = Order::create([
            'user_id' => $this->user->id,
            'address_id' => $address->id,
            'order_number' => 'ORD-12345',
            'payment_method' => 'cash_on_delivery',
            'delivery_type' => 'delivery',
            'status' => 'placed',
            'subtotal' => 10,
            'tax' => 0,
            'delivery_fee' => 0,
            'total' => 10,
        ]);

        $category = Category::create(['name' => 'Cat', 'slug' => 'cat', 'description' => 'Test', 'image' => 'default.png']);
        $meal = Meal::create(['category_id' => $category->id, 'title' => 'Meal', 'slug' => 'meal', 'price' => 10, 'description' => 'Test', 'image' => 'default.png']);

        OrderItem::create([
            'order_id' => $order->id,
            'meal_id' => $meal->id,
            'quantity' => 1,
            'unit_price' => 10,
            'subtotal' => 10,
        ]);

        $response = $this->actingAs($this->user)->getJson("/api/v1/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'order_number',
                ],
            ]);
    }

    public function test_user_can_create_order()
    {
        $address = Address::create([
            'user_id' => $this->user->id,
            'label' => 'Home',
            'full_name' => 'John Doe',
            'phone' => '01012345678',
            'street_address' => '123 St',
            'city' => 'Cairo',
            'state' => 'Cairo',
            'country' => 'Egypt',
            'is_default' => true,
        ]);

        $category = Category::create(['name' => 'Cat', 'slug' => 'cat', 'description' => 'Test', 'image' => 'default.png']);
        $meal = Meal::create(['category_id' => $category->id, 'title' => 'Meal', 'slug' => 'meal', 'price' => 10, 'description' => 'Test', 'image' => 'default.png', 'is_available' => true, 'stock_quantity' => 100]);

        $cart = Cart::create([
            'user_id' => $this->user->id,
            'status' => 'active',
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'meal_id' => $meal->id,
            'quantity' => 1,
            'unit_price' => 10,
            'subtotal' => 10,
        ]);

        $payload = [
            'payment_method' => 'cash_on_delivery',
            'delivery_type' => 'delivery',
            'address_id' => $address->id,
            'amount' => 10,
        ];

        $response = $this->actingAs($this->user)->postJson('/api/v1/orders', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'order_number',
                ],
            ]);
    }

    public function test_user_can_track_order()
    {
        $address = Address::create([
            'user_id' => $this->user->id,
            'label' => 'Home',
            'full_name' => 'John Doe',
            'phone' => '01012345678',
            'street_address' => '123 St',
            'city' => 'Cairo',
            'state' => 'Cairo',
            'country' => 'Egypt',
            'is_default' => true,
        ]);

        $order = Order::create([
            'user_id' => $this->user->id,
            'address_id' => $address->id,
            'order_number' => 'ORD-12345',
            'payment_method' => 'cash_on_delivery',
            'delivery_type' => 'delivery',
            'status' => 'placed',
            'subtotal' => 10,
            'tax' => 0,
            'delivery_fee' => 0,
            'total' => 10,
        ]);

        $response = $this->actingAs($this->user)->getJson("/api/v1/orders/track?order_number={$order->order_number}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'order' => [
                        'id',
                        'order_number',
                    ],
                    'tracking' => [
                        'position',
                        'status',
                    ],
                ],
            ]);
    }
}
