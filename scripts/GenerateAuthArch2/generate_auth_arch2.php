<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 2. Setup Services
$services = [
    'RegisterUserService',
    'LoginUserService',
    'LogoutUserService',
    'ForgotPasswordService',
    'VerifyOtpService',
    'ResetPasswordService',
    'DeleteAccountService',
    'ChangePasswordService',
];

foreach ($services as $service) {
    $dir = "$baseDir/Services/Auth/$service";
    createDir($dir);

    $content = <<<PHP
<?php

namespace App\Services\Auth\\$service;

class $service
{
    public function execute()
    {
        // TODO: Implement
    }
}
PHP;
    file_put_contents("$dir/$service.php", $content);
}

// 3. Move Requests
$requests = [
    'RegisterRequest',
    'LoginRequest',
    'ForgotPasswordRequest',
    'VerifyOtpRequest',
    'ResetPasswordRequest',
    'DeleteAccountRequest',
    'ChangePasswordRequest',
];

foreach ($requests as $request) {
    $oldPath = "$baseDir/Http/Requests/$request.php";
    $newDir = "$baseDir/Http/Requests/Auth/$request";
    createDir($newDir);
    $newPath = "$newDir/$request.php";

    if (file_exists($oldPath)) {
        $content = file_get_contents($oldPath);
        $content = str_replace("namespace App\Http\Requests;", "namespace App\Http\Requests\Auth\\$request;", $content);
        file_put_contents($newPath, $content);
        unlink($oldPath);
    }
}

echo "Services created and Requests moved.\n";
