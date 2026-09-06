<?php

namespace App\Http\Controllers\Api\V1\User\Address\SetDefaultAddressController;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Address\AddressResource\AddressResource;
use App\Services\User\Address\SetDefaultAddressService\SetDefaultAddressService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class SetDefaultAddressController extends Controller
{
    use ApiResponse;

    public function __construct(protected SetDefaultAddressService $service) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        Gate::authorize('update', $address);

        $result = $this->service->execute($request->user(), $id);

        $message = $result['already_default'] ? 'This address is already your default.' : 'Default address updated successfully';

        return self::successResponse($message, [
            'already_default' => $result['already_default'],
            'address' => new AddressResource($result['address']),
        ], 200);
    }
}
