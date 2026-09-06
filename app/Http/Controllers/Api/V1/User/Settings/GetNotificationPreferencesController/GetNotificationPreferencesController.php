<?php

namespace App\Http\Controllers\Api\V1\User\Settings\GetNotificationPreferencesController;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetNotificationPreferencesController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(['message' => 'Not implemented yet']);
    }
}
