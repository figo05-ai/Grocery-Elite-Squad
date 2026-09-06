<?php

namespace App\Http\Controllers\Api\V1\Auth\LoginController;

use App\Exceptions\Auth\InvalidCredentialsException\InvalidCredentialsException;
use App\Exceptions\Auth\UserDeactivatedException\UserDeactivatedException;
use App\Exceptions\Auth\UserNotFoundException\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest\LoginRequest;
use App\Http\Resources\Auth\AuthResource\AuthResource;
use App\Services\Auth\LoginUserService\LoginUserService;
use App\Support\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    use ApiResponse;

    public function __construct(protected LoginUserService $service) {}

    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->service->execute($request->input('login'), $request->input('password'));

            return self::successResponse('Login Successfully', new AuthResource($result), 200);
        } catch (InvalidCredentialsException|UserNotFoundException $e) {
            return self::errorResponse('Login Failed', ['login' => [$e->getMessage()]], 401);
        } catch (UserDeactivatedException $e) {
            return self::errorResponse('Login Failed', ['login' => [$e->getMessage()]], 403);
        }
    }
}
