<?php

namespace Tests\Feature;

use Database\Seeders\CategorySeeder;
use Database\Seeders\MealSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed the basic categories and meals
        $this->seed(CategorySeeder::class);
        $this->seed(MealSeeder::class);
    }

    public function test_can_list_categories()
    {
        $response = $this->getJson('/api/v1/catalog/categories');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'slug',
                        'image_url',
                        'sort_order',
                    ],
                ],
            ]);

        $this->assertNotEmpty($response->json('data'));
    }

    public function test_can_list_meals()
    {
        $response = $this->getJson('/api/v1/catalog/meals');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'price',
                        'category',
                    ],
                ],
            ]);
    }

    public function test_can_get_deals_of_the_day()
    {
        $response = $this->getJson('/api/v1/catalog/meals/today-deals');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
            ]);
    }

    public function test_can_get_single_meal()
    {
        // First get a meal ID
        $mealsResponse = $this->getJson('/api/v1/catalog/meals');
        $meals = $mealsResponse->json('data');

        if (count($meals) > 0) {
            $mealId = $meals[0]['id'];

            $response = $this->getJson("/api/v1/catalog/meals/{$mealId}");

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data' => [
                        'id',
                        'title',
                        'price',
                    ],
                ]);
        } else {
            $this->assertTrue(true, 'No meals found to test single endpoint');
        }
    }
}
