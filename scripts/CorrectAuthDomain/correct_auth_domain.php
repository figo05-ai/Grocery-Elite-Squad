<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 1. Create Auth Domain Exceptions
createDir("$baseDir/Exceptions/Auth");
$exceptions = [
    'InvalidCredentialsException' => 'The credentials provided are incorrect.',
    'UserDeactivatedException' => 'Your account has been deactivated.',
    'UserNotFoundException' => 'User not found.',
];

foreach ($exceptions as $className => $message) {
    $content = <<<PHP
<?php

namespace App\Exceptions\Auth;

use Exception;

class $className extends Exception
{
    public function __construct(string \$message = '$message', int \$code = 400, ?\Throwable \$previous = null)
    {
        parent::__construct(\$message, \$code, \$previous);
    }
}
PHP;
    file_put_contents("$baseDir/Exceptions/Auth/$className.php", $content);
}

// 2. Create Auth Resources (JsonResource)
createDir("$baseDir/Http/Resources/Auth/AuthResource");
$content = <<<PHP
<?php

namespace App\Http\Resources\Auth\AuthResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        return [
            'user' => [
                'id' => \$this->resource['user']->id,
                'username' => \$this->resource['user']->username,
                'email' => \$this->resource['user']->email,
                'phone' => \$this->resource['user']->phone,
                // Add other user fields as necessary
            ],
            'token' => \$this->resource['token'],
        ];
    }
}
PHP;
file_put_contents("$baseDir/Http/Resources/Auth/AuthResource/AuthResource.php", $content);

// 3. Update Auth Services to use Domain Exceptions
$loginService = "$baseDir/Services/Auth/LoginUserService/LoginUserService.php";
if (file_exists($loginService)) {
    $content = file_get_contents($loginService);
    $content = str_replace('use Illuminate\Validation\ValidationException;', 'use App\Exceptions\Auth\InvalidCredentialsException;'."\n".'use App\Exceptions\Auth\UserDeactivatedException;'."\n".'use App\Exceptions\Auth\UserNotFoundException;', $content);
    $content = str_replace(
        "throw ValidationException::withMessages([\n                'login' => ['Unable to sign in. Please try again.'],\n            ]);",
        "throw new UserNotFoundException('Unable to sign in. Please try again.', 401);",
        $content
    );
    $content = str_replace(
        "throw ValidationException::withMessages([\n                'password' => ['The password you entered is incorrect.'],\n            ]);",
        "throw new InvalidCredentialsException('The password you entered is incorrect.', 401);",
        $content
    );
    $content = str_replace(
        "throw ValidationException::withMessages([\n                'login' => ['Your account has been deactivated.'],\n            ]);",
        "throw new UserDeactivatedException('Your account has been deactivated.', 403);",
        $content
    );
    file_put_contents($loginService, $content);
}

$forgotPasswordService = "$baseDir/Services/Auth/ForgotPasswordService/ForgotPasswordService.php";
if (file_exists($forgotPasswordService)) {
    $content = file_get_contents($forgotPasswordService);
    $content = str_replace('use Illuminate\Validation\ValidationException;', 'use App\Exceptions\Auth\UserNotFoundException;', $content);
    $content = str_replace(
        "throw ValidationException::withMessages([\n                'identifier' => ['User not found.'],\n            ]);",
        'throw new UserNotFoundException();',
        $content
    );
    file_put_contents($forgotPasswordService, $content);
}

$resetPasswordService = "$baseDir/Services/Auth/ResetPasswordService/ResetPasswordService.php";
if (file_exists($resetPasswordService)) {
    $content = file_get_contents($resetPasswordService);
    $content = str_replace('use Illuminate\Validation\ValidationException;', 'use App\Exceptions\Auth\UserNotFoundException;', $content);
    $content = str_replace(
        "throw ValidationException::withMessages([\n                'identifier' => ['User not found.'],\n            ]);",
        'throw new UserNotFoundException();',
        $content
    );
    file_put_contents($resetPasswordService, $content);
}

// 4. Update Auth Controllers to remove generic try-catch and use JsonResource
$controllers = [
    'RegisterController' => [
        'use' => "use App\Http\Resources\Auth\AuthResource\AuthResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $result = $this->service->execute($request->validated());
        return self::successResponse('Registration successful', new AuthResource($result), 201);
PHP
    ],
    'LoginController' => [
        'use' => "use App\Http\Resources\Auth\AuthResource\AuthResource;\nuse App\Traits\V1\ApiResponse;\nuse App\Exceptions\Auth\InvalidCredentialsException;\nuse App\Exceptions\Auth\UserNotFoundException;\nuse App\Exceptions\Auth\UserDeactivatedException;",
        'body' => <<<'PHP'
        try {
            $result = $this->service->execute($request->input('login'), $request->input('password'));
            return self::successResponse('Login Successfully', new AuthResource($result), 200);
        } catch (InvalidCredentialsException | UserNotFoundException $e) {
            return self::errorResponse('Login Failed', ['login' => [$e->getMessage()]], 401);
        } catch (UserDeactivatedException $e) {
            return self::errorResponse('Login Failed', ['login' => [$e->getMessage()]], 403);
        }
PHP
    ],
    'LogoutController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $this->service->execute($request->user());
        return self::successResponse('Logout successfull', [], 200);
PHP
    ],
    'ForgotPasswordController' => [
        'use' => "use App\Traits\V1\ApiResponse;\nuse App\Exceptions\Auth\UserNotFoundException;",
        'body' => <<<'PHP'
        try {
            $this->service->execute($request->input('identifier'));
            return self::successResponse('OTP sent successfully . Please check your email', [], 200);
        } catch (UserNotFoundException $e) {
            return self::errorResponse('Failed to send OTP', ['identifier' => [$e->getMessage()]], 404);
        }
PHP
    ],
    'VerifyOtpController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $isValid = $this->service->execute($request->input('identifier'), $request->input('otp'));
        if (!$isValid) {
            return self::errorResponse('Invalid or expired OTP', [], 400);
        }
        return self::successResponse('OTP verified successfully', [], 200);
PHP
    ],
    'ResetPasswordController' => [
        'use' => "use App\Traits\V1\ApiResponse;\nuse App\Exceptions\Auth\UserNotFoundException;",
        'body' => <<<'PHP'
        try {
            $this->service->execute($request->input('identifier'), $request->input('otp'), $request->input('password'));
            return self::successResponse('Password reset successfully', [], 200);
        } catch (UserNotFoundException $e) {
            return self::errorResponse('Password reset failed', ['identifier' => [$e->getMessage()]], 404);
        }
PHP
    ],
    'DeleteAccountController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $this->service->execute($request->user());
        return self::successResponse('Account deleted successfully', [], 200);
PHP
    ],
    'ChangePasswordController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $this->service->execute($request->user(), $request->input('password'));
        return self::successResponse('Password changed successfully', [], 200);
PHP
    ],
];

foreach ($controllers as $controller => $data) {
    $path = "$baseDir/Http/Controllers/Auth/$controller/$controller.php";
    if (! file_exists($path)) {
        continue;
    }

    $content = file_get_contents($path);

    // Add trait to class
    if (! str_contains($content, 'use ApiResponse;')) {
        $content = preg_replace('/class\s+'.$controller.'\s+extends\s+Controller\s*{/', "class $controller extends Controller\n{\n    use ApiResponse;\n", $content);
    }

    // Replace imports
    $content = preg_replace('/use App\\\\Http\\\\Responses\\\\Auth\\\\AuthResponse\\\\AuthResponse;/', '', $content);
    $content = preg_replace('/use App\\\\Http\\\\Responses\\\\Shared\\\\SuccessResponse;/', '', $content);
    $content = preg_replace('/use Exception;/', '', $content);
    $content = preg_replace('/use Illuminate\\\\Validation\\\\ValidationException;/', '', $content);

    // Insert new imports
    $content = str_replace('use Illuminate\Http\JsonResponse;', "use Illuminate\Http\JsonResponse;\n".$data['use'], $content);

    // Replace __invoke body
    $content = preg_replace('/public function __invoke\([^)]+\)\s*:\s*JsonResponse\s*\{.*?\n    \}/s', 'public function __invoke('.preg_replace('/.*public function __invoke\(([^)]+)\).*/s', '$1', $content)."): JsonResponse\n    {\n".$data['body']."\n    }", $content);

    file_put_contents($path, $content);
}

// 5. Cleanup Custom Responses
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != '.' && $object != '..') {
                if (is_dir($dir.DIRECTORY_SEPARATOR.$object) && ! is_link($dir.'/'.$object)) {
                    rrmdir($dir.DIRECTORY_SEPARATOR.$object);
                } else {
                    unlink($dir.DIRECTORY_SEPARATOR.$object);
                }
            }
        }
        rmdir($dir);
    }
}
rrmdir("$baseDir/Http/Responses/Auth");

echo "Auth Domain corrections completed.\n";
