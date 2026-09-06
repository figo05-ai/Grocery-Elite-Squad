<?php

namespace Tests\Feature;

use App\Models\Catalog\Meal\Meal;
use App\Models\User\Favorite\Favorite;
use App\Models\User\User\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteApiTest extends TestCase
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

    public function test_user_can_get_favorites()
    {
        Favorite::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user)->getJson('/api/v1/user/favorites');
        $response->assertStatus(200);
    }

    public function test_user_can_toggle_favorite()
    {
        $meal = Meal::factory()->create();
        $response = $this->actingAs($this->user)->postJson('/api/v1/user/favorites/toggle', [
            'meal_id' => $meal->id,
        ]);
        $response->assertStatus(200);
    }

    public function test_user_can_check_favorite()
    {
        $meal = Meal::factory()->create();
        $response = $this->actingAs($this->user)->getJson('/api/v1/user/favorites/check/'.$meal->id);
        $response->assertStatus(200);
    }
}
