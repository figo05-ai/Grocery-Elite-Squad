<?php

namespace App\Http\Controllers\Api\V1\User\Loyalty\GetLoyaltyPointsController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetLoyaltyPointsController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();
        $data = [
            'loyalty_points' => $user->loyalty_points,
            'tier' => 'Bronze', // Placeholder logic based on original service
            'points_to_next_tier' => 500,
            'history' => [],
        ];

        return self::successResponse('Loyalty data retrieved successfully', $data, 200);
    }
}
