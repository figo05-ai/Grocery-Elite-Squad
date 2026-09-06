<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 1. Setup Controllers
$controllers = [
    'RegisterController' => [
        'request' => 'RegisterRequest',
        'service' => 'RegisterUserService',
        'response' => 'AuthResponse',
        'method' => 'register',
    ],
    'LoginController' => [
        'request' => 'LoginRequest',
        'service' => 'LoginUserService',
        'response' => 'AuthResponse',
        'method' => 'login',
    ],
    'LogoutController' => [
        'request' => 'Request',
        'service' => 'LogoutUserService',
        'response' => 'SuccessResponse',
        'method' => 'logout',
    ],
    'ForgotPasswordController' => [
        'request' => 'ForgotPasswordRequest',
        'service' => 'ForgotPasswordService',
        'response' => 'SuccessResponse',
        'method' => 'forgotPassword',
    ],
    'VerifyOtpController' => [
        'request' => 'VerifyOtpRequest',
        'service' => 'VerifyOtpService',
        'response' => 'SuccessResponse',
        'method' => 'verifyOtp',
    ],
    'ResetPasswordController' => [
        'request' => 'ResetPasswordRequest',
        'service' => 'ResetPasswordService',
        'response' => 'SuccessResponse',
        'method' => 'resetPassword',
    ],
    'MeController' => [
        'request' => 'Request',
        'service' => null, // Just returns the user
        'response' => 'MeResponse',
        'method' => 'me',
    ],
    'DeleteAccountController' => [
        'request' => 'DeleteAccountRequest',
        'service' => 'DeleteAccountService',
        'response' => 'SuccessResponse',
        'method' => 'deleteAccount',
    ],
    'ChangePasswordController' => [
        'request' => 'ChangePasswordRequest',
        'service' => 'ChangePasswordService', // We'll extract this logic from controller
        'response' => 'SuccessResponse',
        'method' => 'changePassword',
    ],
];

foreach ($controllers as $controller => $info) {
    $dir = "$baseDir/Http/Controllers/Auth/$controller";
    createDir($dir);

    $reqImport = $info['request'] === 'Request'
        ? 'use Illuminate\\Http\\Request;'
        : "use App\\Http\\Requests\\Auth\\{$info['request']}\\{$info['request']};";

    $serviceImport = $info['service']
        ? "use App\\Services\\Auth\\{$info['service']}\\{$info['service']};\n"
        : '';

    $serviceProp = $info['service']
        ? "    public function __construct(protected {$info['service']} \$service) {}\n\n"
        : '';

    $responseImport = '';
    if ($info['response'] === 'SuccessResponse') {
        $responseImport = 'use App\\Http\\Responses\\Shared\\SuccessResponse;';
    } elseif ($info['response'] === 'AuthResponse') {
        $responseImport = 'use App\\Http\\Responses\\Auth\\AuthResponse\\AuthResponse;';
    } elseif ($info['response'] === 'MeResponse') {
        $responseImport = 'use App\\Http\\Responses\\Auth\\MeResponse\\MeResponse;';
    }

    $content = <<<PHP
<?php

namespace App\Http\Controllers\Auth\\$controller;

use App\Http\Controllers\Controller;
$reqImport
$serviceImport
$responseImport
use Illuminate\Http\JsonResponse;

class $controller extends Controller
{
$serviceProp
    public function __invoke({$info['request']} \$request): JsonResponse
    {
        // TODO: Implement
    }
}
PHP;
    file_put_contents("$dir/$controller.php", $content);
}

// Create Responses
createDir("$baseDir/Http/Responses/Shared");
file_put_contents("$baseDir/Http/Responses/Shared/SuccessResponse.php", <<<PHP
<?php

namespace App\Http\Responses\Shared;

use Illuminate\Http\JsonResponse;

class SuccessResponse
{
    public static function make(string \$message = 'Success', array \$data = [], int \$status = 200): JsonResponse
    {
        return response()->json([
            'status' => \$status,
            'message' => \$message,
            'data' => empty(\$data) ? null : \$data,
        ], \$status);
    }
}
PHP
);

createDir("$baseDir/Http/Responses/Auth/AuthResponse");
file_put_contents("$baseDir/Http/Responses/Auth/AuthResponse/AuthResponse.php", <<<PHP
<?php

namespace App\Http\Responses\Auth\AuthResponse;

use Illuminate\Http\JsonResponse;

class AuthResponse
{
    public static function make(string \$message, array \$result, int \$status = 200): JsonResponse
    {
        return response()->json([
            'status' => \$status,
            'message' => \$message,
            'data' => [
                'user' => [
                    'id' => \$result['user']->id,
                    'username' => \$result['user']->username,
                    'email' => \$result['user']->email,
                    'phone' => \$result['user']->phone,
                    'created_at' => \$result['user']->created_at,
                ],
                'token' => \$result['token'],
            ],
        ], \$status);
    }
}
PHP
);

createDir("$baseDir/Http/Responses/Auth/MeResponse");
file_put_contents("$baseDir/Http/Responses/Auth/MeResponse/MeResponse.php", <<<PHP
<?php

namespace App\Http\Responses\Auth\MeResponse;

use Illuminate\Http\JsonResponse;
use App\Models\User\User\User;

class MeResponse
{
    public static function make(User \$user): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'User retrieved successfully',
            'data' => [
                'user' => [
                    'id' => \$user->id,
                    'username' => \$user->username,
                    'email' => \$user->email,
                    'phone' => \$user->phone,
                    'email_verified' => \$user->email_verified,
                    'phone_verified' => \$user->phone_verified,
                    'created_at' => \$user->created_at,
                ]
            ],
        ], 200);
    }
}
PHP
);

echo "Directories and files generated.\n";
