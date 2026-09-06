<?php

namespace App\Http\Controllers\Api\V1\System\GetStaticPageController;

use App\Http\Controllers\Controller;
use App\Models\System\StaticPage\StaticPage;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetStaticPageController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, string $slug): JsonResponse
    {
        $page = StaticPage::where('slug', $slug)->where('is_published', true)->firstOrFail();

        return self::successResponse('Page retrieved successfully', $page, 200);
    }
}
