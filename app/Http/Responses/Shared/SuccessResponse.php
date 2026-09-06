<?php

namespace App\Http\Responses\Shared;

use Illuminate\Http\JsonResponse;

class SuccessResponse
{
    public static function make(string $message = 'Success', array $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => empty($data) ? null : $data,
        ], $status);
    }
}
