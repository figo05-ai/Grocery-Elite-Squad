<?php

namespace App\Http\Controllers\Api\V1\User\Address\GetAddressesController;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Address\AddressResource\AddressResource;
use App\Models\User\Address\Address;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GetAddressesController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        Gate::authorize('viewAny', Address::class);

        if ($request->allFiles() !== []) {
            return self::errorResponse('This endpoint does not accept file uploads.', ['files' => ['Remove file attachments from the request.']], 422);
        }

        $user = $request->user();
        $addresses = $user->addresses()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return self::successResponse('Addresses retrieved successfully', [
            'addresses' => AddressResource::collection($addresses),
            'total_count' => $addresses->count(),
        ], 200);
    }
}
