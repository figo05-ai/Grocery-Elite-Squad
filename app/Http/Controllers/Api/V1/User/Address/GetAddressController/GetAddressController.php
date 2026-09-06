<?php

namespace App\Http\Controllers\Api\V1\User\Address\GetAddressController;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Address\AddressResource\AddressResource;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GetAddressController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, string $id): JsonResponse
    {
        Gate::authorize('view', $address);

        $user = $request->user();
        $address = $user->addresses()->findOrFail($id);

        return self::successResponse('Address retrieved successfully', new AddressResource($address), 200);
    }
}
