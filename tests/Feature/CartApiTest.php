<?php

namespace Tests\Feature;

use App\Models\Cart\Cart\Cart;
use App\Models\User\User\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Cart $cart;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
        $this->user = User::factory()->create();
        $this->user->assignRole('customer');

        $this->cart = Cart::factory()->create(['user_id' => $this->user->id]);
    }

    public function test_user_can_get_cart()
    {
        $response = $this->actingAs($this->user)->getJson('/api/v1/cart');

        $response->assertStatus(200);
    }

    public function test_user_can_clear_cart()
    {
        $response = $this->actingAs($this->user)->deleteJson('/api/v1/cart');

        $response->assertStatus(200);
    }
}
