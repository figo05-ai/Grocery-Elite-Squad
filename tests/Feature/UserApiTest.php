<?php

namespace Tests\Feature;

use App\Models\User\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_user_can_get_profile()
    {
        $response = $this->actingAs($this->user)->getJson('/api/v1/user/profile');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'me' => [
                        'id',
                        'email',
                    ],
                ],
            ]);
    }

    public function test_user_can_update_profile()
    {
        $response = $this->actingAs($this->user)->putJson('/api/v1/user/profile', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'phone' => '01012345678',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);
    }

    public function test_user_can_get_addresses()
    {
        $response = $this->actingAs($this->user)->getJson('/api/v1/user/addresses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
            ]);
    }
}
