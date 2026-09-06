<?php

namespace App\Http\Controllers\Api\V1\Support\SubmitContactMessageController;

use App\Http\Controllers\Controller;
use App\Models\Support\ContactMessage\ContactMessage;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubmitContactMessageController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create([
            'user_id' => $request->user()->id,
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'status' => 'new',
        ]);

        return self::successResponse('Message sent successfully', [], 201);
    }
}
