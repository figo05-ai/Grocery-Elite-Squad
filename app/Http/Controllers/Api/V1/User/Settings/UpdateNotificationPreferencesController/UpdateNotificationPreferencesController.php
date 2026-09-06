<?php

namespace App\Http\Controllers\Api\V1\User\Settings\UpdateNotificationPreferencesController;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateNotificationPreferencesController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(['message' => 'Not implemented yet']);
    }
}
