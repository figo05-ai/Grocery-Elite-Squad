<?php

namespace App\Http\Controllers\Api\V1\User\Address\CreateAddressController;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Address\AddressRequest\AddressRequest;
use App\Http\Resources\User\Address\AddressResource\AddressResource;
use App\Models\User\Address\Address;
use App\Services\User\Address\CreateAddressService\CreateAddressService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class CreateAddressController extends Controller
{
    use ApiResponse;

    public function __construct(protected CreateAddressService $service) {}

    public function __invoke(AddressRequest $request): JsonResponse
    {
        Gate::authorize('create', Address::class);

        $address = $this->service->execute($request->user(), $request->validated());

        return self::successResponse('Address created successfully', new AddressResource($address), 201);
    }
}
