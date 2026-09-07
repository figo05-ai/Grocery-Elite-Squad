<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LoyaltyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoyaltyController extends Controller
{
    public function __construct(
        private readonly LoyaltyService $loyaltyService
    ) {}

    /**
     * Display the authenticated user's loyalty summary.
     */
    public function index(Request $request): JsonResponse
    {
        return $this->successResponse(
            'Loyalty data retrieved successfully',
            $this->loyaltyService->buildSummary($request->user())
        );
    }
}
