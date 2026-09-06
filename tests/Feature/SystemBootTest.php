<?php

namespace Tests\Feature;

use Tests\TestCase;

class SystemBootTest extends TestCase
{
    /**
     * A basic test to verify the system boots up and health check passes.
     */
    public function test_the_system_boots_and_health_check_returns_successful_response(): void
    {
        $response = $this->get('/api/v1/health');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }
}
