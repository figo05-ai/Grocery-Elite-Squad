<?php

namespace App\Http\Controllers\Api\V1\User\Address\DeleteAddressController;

use App\Http\Controllers\Controller;
use App\Services\User\Address\DeleteAddressService\DeleteAddressService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class DeleteAddressController extends Controller
{
    use ApiResponse;

    public function __construct(protected DeleteAddressService $service) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $address = \App\Models\User\Address\Address::findOrFail($id);
        Gate::authorize('delete', $address);

        $this->service->execute($request->user(), $id);

        return self::successResponse('Address deleted successfully', [], 200);
    }
}
