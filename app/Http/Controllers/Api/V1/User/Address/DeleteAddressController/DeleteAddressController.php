<?php

namespace App\Http\Controllers\Api\V1\User\Address\DeleteAddressController;

use App\Http\Controllers\Controller;
use App\Models\User\Address\Address;
use App\Services\User\Address\DeleteAddressService\DeleteAddressService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DeleteAddressController extends Controller
{
    use ApiResponse;

    public function __construct(protected DeleteAddressService $service) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $address = Address::findOrFail($id);
        Gate::authorize('delete', $address);

        $this->service->execute($request->user(), $id);

        return self::successResponse('Address deleted successfully', [], 200);
    }
}
