<?php

namespace Tests\Feature;

use App\Models\User\User\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User\Address\Address;

class AddressApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->user = User::factory()->create();
        $this->user->assignRole('customer');
    }

    public function test_user_can_create_address()
    {
        $response = $this->actingAs($this->user)->postJson('/api/v1/user/addresses', [
            'label' => 'Home',
            'full_name' => 'John Doe',
            'phone' => '+201000000000',
            'latitude' => 30.0444,
            'longitude' => 31.2357,
            'street_address' => 'Test Street',
            'city' => 'Cairo',
            'state' => 'Cairo',
            'postal_code' => '11511',
            'country' => 'Egypt'
        ]);
        $response->assertStatus(201);
    }
    
    public function test_user_can_list_addresses()
    {
        Address::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user)->getJson('/api/v1/user/addresses');
        $response->assertStatus(200);
    }
    
    public function test_user_can_delete_address()
    {
        $address = Address::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user)->deleteJson("/api/v1/user/addresses/{$address->id}");
        $response->assertStatus(200);
    }
}
