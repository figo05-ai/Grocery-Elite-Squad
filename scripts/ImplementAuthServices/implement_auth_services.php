<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// Implement RegisterUserService
$content = <<<PHP
<?php

namespace App\Services\Auth\RegisterUserService;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\NotificationService;

class RegisterUserService
{
    public function __construct(protected NotificationService \$notificationService) {}

    public function execute(array \$data): array
    {
        \$user = User::create([
            'username' => \$data['username'],
            'email' => \$data['email'] ?? null,
            'phone' => \$data['phone'] ?? null,
            'password' => Hash::make(\$data['password']),
            'agree_terms' => \$data['agree_terms'],
        ]);

        \$token = \$user->createToken('auth_token')->plainTextToken;

        if (\$user->email) {
            \$this->notificationService->sendWelcomeEmail(\$user->email, \$user->username);
        }

        return [
            'user' => \$user,
            'token' => \$token,
        ];
    }
}
PHP;
file_put_contents("$baseDir/Services/Auth/RegisterUserService/RegisterUserService.php", $content);

// Implement LoginUserService
$content = <<<PHP
<?php

namespace App\Services\Auth\LoginUserService;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUserService
{
    public function execute(string \$identifier, string \$password): array
    {
        \$user = User::findByIdentifier(\$identifier);

        if (! \$user) {
            throw ValidationException::withMessages([
                'login' => ['Unable to sign in. Please try again.'],
            ]);
        }

        if (! Hash::check(\$password, \$user->password)) {
            throw ValidationException::withMessages([
                'password' => ['The password you entered is incorrect.'],
            ]);
        }

        if (! \$user->is_active) {
            throw ValidationException::withMessages([
                'login' => ['Your account has been deactivated.'],
            ]);
        }

        \$token = \$user->createToken('auth_token')->plainTextToken;

        return [
            'user' => \$user,
            'token' => \$token,
        ];
    }
}
PHP;
file_put_contents("$baseDir/Services/Auth/LoginUserService/LoginUserService.php", $content);

// Implement LogoutUserService
$content = <<<PHP
<?php

namespace App\Services\Auth\LogoutUserService;

use App\Models\User;

class LogoutUserService
{
    public function execute(User \$user): bool
    {
        \$user->tokens()->delete();
        return true;
    }
}
PHP;
file_put_contents("$baseDir/Services/Auth/LogoutUserService/LogoutUserService.php", $content);

// Implement ForgotPasswordService
$content = <<<PHP
<?php

namespace App\Services\Auth\ForgotPasswordService;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use App\Services\Auth\OtpService\OtpService;
use App\Services\NotificationService;

class ForgotPasswordService
{
    public function __construct(
        protected OtpService \$otpService,
        protected NotificationService \$notificationService
    ) {}

    public function execute(string \$identifier): bool
    {
        \$user = User::findByIdentifier(\$identifier);

        if (! \$user) {
            throw ValidationException::withMessages([
                'identifier' => ['User not found.'],
            ]);
        }

        \$otp = \$this->otpService->generate(\$identifier, 'password_reset');

        if (filter_var(\$identifier, FILTER_VALIDATE_EMAIL)) {
            \$this->notificationService->sendOtpEmail(\$identifier, \$otp, 'password_reset');
        } else {
            \$this->notificationService->sendOtpSms(\$identifier, \$otp, 'password_reset');
        }

        return true;
    }
}
PHP;
file_put_contents("$baseDir/Services/Auth/ForgotPasswordService/ForgotPasswordService.php", $content);

// Implement VerifyOtpService
$content = <<<PHP
<?php

namespace App\Services\Auth\VerifyOtpService;

use App\Services\Auth\OtpService\OtpService;

class VerifyOtpService
{
    public function __construct(protected OtpService \$otpService) {}

    public function execute(string \$identifier, string \$otp): bool
    {
        return \$this->otpService->verify(\$identifier, \$otp, 'password_reset');
    }
}
PHP;
file_put_contents("$baseDir/Services/Auth/VerifyOtpService/VerifyOtpService.php", $content);

// Implement ResetPasswordService
$content = <<<PHP
<?php

namespace App\Services\Auth\ResetPasswordService;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Services\Auth\OtpService\OtpService;

class ResetPasswordService
{
    public function __construct(protected OtpService \$otpService) {}

    public function execute(string \$identifier, string \$otp, string \$newPassword): bool
    {
        \$user = User::findByIdentifier(\$identifier);

        if (! \$user) {
            throw ValidationException::withMessages([
                'identifier' => ['User not found.'],
            ]);
        }

        \$user->password = Hash::make(\$newPassword);
        \$user->save();

        \$this->otpService->verify(\$identifier, \$otp, 'password_reset');
        \$user->tokens()->delete();

        return true;
    }
}
PHP;
file_put_contents("$baseDir/Services/Auth/ResetPasswordService/ResetPasswordService.php", $content);

// Implement DeleteAccountService
$content = <<<PHP
<?php

namespace App\Services\Auth\DeleteAccountService;

use App\Models\User;

class DeleteAccountService
{
    public function execute(User \$user): bool
    {
        \$user->delete();
        \$user->tokens()->delete();
        return true;
    }
}
PHP;
file_put_contents("$baseDir/Services/Auth/DeleteAccountService/DeleteAccountService.php", $content);

// Implement ChangePasswordService
$content = <<<PHP
<?php

namespace App\Services\Auth\ChangePasswordService;

use App\Models\User;

class ChangePasswordService
{
    public function execute(User \$user, string \$newPassword): bool
    {
        \$user->update([
            'password' => \$newPassword,
        ]);

        return true;
    }
}
PHP;
file_put_contents("$baseDir/Services/Auth/ChangePasswordService/ChangePasswordService.php", $content);

// Move OtpService
createDir("$baseDir/Services/Auth/OtpService");
$oldOtpService = file_get_contents("$baseDir/Services/OtpService.php");
$newOtpService = str_replace('namespace App\\Services;', 'namespace App\\Services\\Auth\\OtpService;', $oldOtpService);
file_put_contents("$baseDir/Services/Auth/OtpService/OtpService.php", $newOtpService);

echo "Services implemented.\n";
