<?php

namespace App\Http\Controllers\Api\V1\Auth\DeleteAccountController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DeleteAccountRequest\DeleteAccountRequest;
use App\Services\Auth\DeleteAccountService\DeleteAccountService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;

class DeleteAccountController extends Controller
{
    use ApiResponse;

    public function __construct(protected DeleteAccountService $service) {}

    public function __invoke(DeleteAccountRequest $request): JsonResponse
    {
        $this->service->execute($request->user());

        return self::successResponse('Account deleted successfully', [], 200);
    }
}
