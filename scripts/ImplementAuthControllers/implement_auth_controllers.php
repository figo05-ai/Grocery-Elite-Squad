<?php

$baseDir = __DIR__.'/../app';

$controllers = [
    'RegisterController' => <<<PHP
<?php

namespace App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest\RegisterRequest;
use App\Services\Auth\RegisterUserService\RegisterUserService;
use App\Http\Responses\Auth\AuthResponse\AuthResponse;
use Illuminate\Http\JsonResponse;
use Exception;

class RegisterController extends Controller
{
    public function __construct(protected RegisterUserService \$service) {}

    public function __invoke(RegisterRequest \$request): JsonResponse
    {
        try {
            \$result = \$this->service->execute(\$request->validated());
            return AuthResponse::make('Registration successful', \$result, 201);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'Registration failed.',
                'data' => null
            ], 500);
        }
    }
}
PHP,
    'LoginController' => <<<PHP
<?php

namespace App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest\LoginRequest;
use App\Services\Auth\LoginUserService\LoginUserService;
use App\Http\Responses\Auth\AuthResponse\AuthResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Exception;

class LoginController extends Controller
{
    public function __construct(protected LoginUserService \$service) {}

    public function __invoke(LoginRequest \$request): JsonResponse
    {
        try {
            \$result = \$this->service->execute(
                \$request->input('login'),
                \$request->input('password')
            );
            return AuthResponse::make('Login Successfully', \$result, 200);
        } catch (ValidationException \$e) {
            return response()->json([
                'status' => 401,
                'message' => 'Login Failed',
                'data' => null
            ], 401);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'Login Failed',
                'data' => null
            ], 500);
        }
    }
}
PHP,
    'LogoutController' => <<<PHP
<?php

namespace App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Auth\LogoutUserService\LogoutUserService;
use App\Http\Responses\Shared\SuccessResponse;
use Illuminate\Http\JsonResponse;
use Exception;

class LogoutController extends Controller
{
    public function __construct(protected LogoutUserService \$service) {}

    public function __invoke(Request \$request): JsonResponse
    {
        try {
            \$this->service->execute(\$request->user());
            return SuccessResponse::make('Logout successfull', [], 200);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'Logout Failed',
                'data' => null
            ], 500);
        }
    }
}
PHP,
    'ForgotPasswordController' => <<<PHP
<?php

namespace App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest\ForgotPasswordRequest;
use App\Services\Auth\ForgotPasswordService\ForgotPasswordService;
use App\Http\Responses\Shared\SuccessResponse;
use Illuminate\Http\JsonResponse;
use Exception;

class ForgotPasswordController extends Controller
{
    public function __construct(protected ForgotPasswordService \$service) {}

    public function __invoke(ForgotPasswordRequest \$request): JsonResponse
    {
        try {
            \$this->service->execute(\$request->input('identifier'));
            return SuccessResponse::make('OTP sent successfully . Please check your email', [], 200);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to send OTP',
                'data' => null
            ], 500);
        }
    }
}
PHP,
    'VerifyOtpController' => <<<PHP
<?php

namespace App\Http\Controllers\Auth\VerifyOtpController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyOtpRequest\VerifyOtpRequest;
use App\Services\Auth\VerifyOtpService\VerifyOtpService;
use App\Http\Responses\Shared\SuccessResponse;
use Illuminate\Http\JsonResponse;
use Exception;

class VerifyOtpController extends Controller
{
    public function __construct(protected VerifyOtpService \$service) {}

    public function __invoke(VerifyOtpRequest \$request): JsonResponse
    {
        try {
            \$isValid = \$this->service->execute(
                \$request->input('identifier'),
                \$request->input('otp')
            );

            if (!\$isValid) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid or expired OTP',
                    'data' => null
                ], 400);
            }

            return SuccessResponse::make('OTP verified successfully', [], 200);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'OTP verification failed',
                'data' => null
            ], 500);
        }
    }
}
PHP,
    'ResetPasswordController' => <<<PHP
<?php

namespace App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService\ResetPasswordService;
use App\Http\Responses\Shared\SuccessResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Exception;

class ResetPasswordController extends Controller
{
    public function __construct(protected ResetPasswordService \$service) {}

    public function __invoke(ResetPasswordRequest \$request): JsonResponse
    {
        try {
            \$this->service->execute(
                \$request->input('identifier'),
                \$request->input('otp'),
                \$request->input('password')
            );
            return SuccessResponse::make('Password reset successfully', [], 200);
        } catch (ValidationException \$e) {
            return response()->json([
                'status' => 400,
                'message' => 'Password reset failed',
                'data' => null
            ], 400);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'Password reset failed',
                'data' => null
            ], 500);
        }
    }
}
PHP,
    'MeController' => <<<PHP
<?php

namespace App\Http\Controllers\Auth\MeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\Auth\MeResponse\MeResponse;
use Illuminate\Http\JsonResponse;

class MeController extends Controller
{
    public function __invoke(Request \$request): JsonResponse
    {
        return MeResponse::make(\$request->user());
    }
}
PHP,
    'DeleteAccountController' => <<<PHP
<?php

namespace App\Http\Controllers\Auth\DeleteAccountController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DeleteAccountRequest\DeleteAccountRequest;
use App\Services\Auth\DeleteAccountService\DeleteAccountService;
use App\Http\Responses\Shared\SuccessResponse;
use Illuminate\Http\JsonResponse;
use Exception;

class DeleteAccountController extends Controller
{
    public function __construct(protected DeleteAccountService \$service) {}

    public function __invoke(DeleteAccountRequest \$request): JsonResponse
    {
        try {
            \$this->service->execute(\$request->user());
            return SuccessResponse::make('Account deleted successfully', [], 200);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete account',
                'data' => null
            ], 500);
        }
    }
}
PHP,
    'ChangePasswordController' => <<<PHP
<?php

namespace App\Http\Controllers\Auth\ChangePasswordController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest\ChangePasswordRequest;
use App\Services\Auth\ChangePasswordService\ChangePasswordService;
use App\Http\Responses\Shared\SuccessResponse;
use Illuminate\Http\JsonResponse;
use Exception;

class ChangePasswordController extends Controller
{
    public function __construct(protected ChangePasswordService \$service) {}

    public function __invoke(ChangePasswordRequest \$request): JsonResponse
    {
        try {
            \$this->service->execute(\$request->user(), \$request->input('password'));
            return SuccessResponse::make('Password changed successfully', [], 200);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to change password',
                'data' => null
            ], 500);
        }
    }
}
PHP,
];

foreach ($controllers as $controller => $content) {
    file_put_contents("$baseDir/Http/Controllers/Auth/$controller/$controller.php", $content);
}

// Cleanup old files
@unlink("$baseDir/Http/Controllers/Api/AuthController.php");
@unlink("$baseDir/Services/AuthService.php");
@unlink("$baseDir/Services/OtpService.php");

echo "Controllers updated and old files deleted.\n";
