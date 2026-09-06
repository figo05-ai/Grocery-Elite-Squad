<?php

namespace App\Http\Controllers\Api\V1\User\Address\UpdateAddressController;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Address\AddressRequest\AddressRequest;
use App\Http\Resources\User\Address\AddressResource\AddressResource;
use App\Services\User\Address\UpdateAddressService\UpdateAddressService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class UpdateAddressController extends Controller
{
    use ApiResponse;

    public function __construct(protected UpdateAddressService $service) {}

    public function __invoke(AddressRequest $request, string $id): JsonResponse
    {
        Gate::authorize('update', $address);

        $address = $this->service->execute($request->user(), $id, $request->validated());

        return self::successResponse('Address updated successfully', new AddressResource($address), 200);
    }
}
