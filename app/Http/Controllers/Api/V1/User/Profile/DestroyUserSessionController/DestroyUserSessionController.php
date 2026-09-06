<?php

namespace App\Http\Controllers\Api\V1\User\Profile\DestroyUserSessionController;

use App\Http\Controllers\Controller;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\TransientToken;

class DestroyUserSessionController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $user = $request->user();
        $currentTokenId = $user->currentAccessToken() && ! ($user->currentAccessToken() instanceof TransientToken) ? $user->currentAccessToken()->id : null;

        if ((string) $id === (string) $currentTokenId) {
            return self::errorResponse('Cannot revoke your current session from this request. Use logout instead.', [], 400);
        }

        $token = $user->tokens()->find($id);
        if (! $token) {
            return self::errorResponse('Session not found', [], 404);
        }

        $token->delete();

        return self::successResponse('Session revoked successfully');
    }
}
