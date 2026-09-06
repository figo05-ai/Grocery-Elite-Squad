<?php

namespace App\Http\Controllers\Api\V1\System\GetAppConfigController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetAppConfigController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $config = [
            'app_name' => config('app.name'),
            'currency' => config('app.currency', 'EGP'),
            'tax_rate' => config('app.tax_rate', 14),
            'delivery_fee' => config('app.delivery_fee', 25),
        ];

        return self::successResponse('App config retrieved successfully', $config, 200);
    }
}
