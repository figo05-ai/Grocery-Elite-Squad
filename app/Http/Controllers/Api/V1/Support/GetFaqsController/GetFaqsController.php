<?php

namespace App\Http\Controllers\Api\V1\Support\GetFaqsController;

use App\Http\Controllers\Controller;
use App\Models\Support\Faq\Faq;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetFaqsController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $faqs = Faq::where('is_active', true)->orderBy('order')->get();

        return self::successResponse('FAQs retrieved successfully', $faqs, 200);
    }
}
