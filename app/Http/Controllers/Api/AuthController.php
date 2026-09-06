<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\V1\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->register($request->validated());

            return self::successResponse(
                'Registration successful',
                [
                    'user' => [
                        'id' => $result['user']->id,
                        'username' => $result['user']->username,
                        'email' => $result['user']->email,
                        'phone' => $result['user']->phone,
                        'created_at' => $result['user']->created_at,
                    ],
                    'token' => $result['token'],
                ],
                201
            );
        } catch (\Exception $e) {
        return self::errorResponse("Registration failed.",500);
        }

    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login(
                $request->input('login'),
                $request->input('password')
            );

            return self::successResponse("Login Successfully",[
                "user"=>[
                    "id"=>$result["user"]->id,
                    "email"=>$result["user"]->email,
                    "phone"=>$result["user"]->phone
                ],
                "token"=>$result["token"],
            ],200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return self::errorResponse("Login Failed",null,401);

        } catch (\Exception $e) {
            self::errorResponse("Login Failed",500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request->user());

            return self::successResponse("Logout successfull",null,200);

        } catch (\Exception $e) {
            return self::errorResponse("Logout Failed",null,500);
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {

        try {
            $this->authService->forgotPassword($request->input('identifier'));

            return self::successResponse("OTP sent successfully . Please check your email",null,200);
        } catch (\Exception $e) {
            return self::errorResponse("Failed to send OTP",null,500);
        }
    }

    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        try {
            $isValid = $this->authService->verifyOtp(
                $request->input('identifier'),
                $request->input('otp')
            );

            if (! $isValid) {
                return self::errorResponse("Invalid or expired OTP", null, 400);
            }

            return self::successResponse("OTP verified successfully", null, 200);

        } catch (\Exception $e) {
            return self::errorResponse("OTP verification failed", null, 500);
        }
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $this->authService->resetPassword(
                $request->input('identifier'),
                $request->input('otp'),
                $request->input('password')
            );

            return self::successResponse("Password reset successfully", null, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return self::errorResponse("Password reset failed", null, 400);

        } catch (\Exception $e) {

            self::errorResponse("Password reset failed", null, 500);
        }
    }

    public function me(Request $request): JsonResponse
    {
        return self::successResponse(
            "User retrieved successfully",
            [
                'user' => [
                    'id' => $request->user()->id,
                    'username' => $request->user()->username,
                    'email' => $request->user()->email,
                    'phone' => $request->user()->phone,
                    'email_verified' => $request->user()->email_verified,
                    'phone_verified' => $request->user()->phone_verified,
                    'created_at' => $request->user()->created_at,
                ],
            ],
            200
        );
    }

    public function deleteAccount(DeleteAccountRequest $request): JsonResponse
    {
        try {
            $this->authService->deleteAccount($request->user());
        } catch (\Exception $e) {
            return self::errorResponse("Failed to delete account", null, 500);
        }

        return self::successResponse("Account deleted successfully", null, 200);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $user = $request->user();

            // Let the User model's "hashed" cast hash the plain password once (avoid double hashing).
            $user->update([
                'password' => $request->input('password'),
            ]);

            return self::successResponse("Password changed successfully", null, 200);

        } catch (\Exception $e) {
            return self::errorResponse("Failed to change password");
        }
    }
}
