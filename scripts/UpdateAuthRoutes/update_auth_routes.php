<?php

$file = __DIR__.'/../routes/api.php';
$content = file_get_contents($file);

$imports = [
    'use App\Http\Controllers\Auth\RegisterController\RegisterController;',
    'use App\Http\Controllers\Auth\LoginController\LoginController;',
    'use App\Http\Controllers\Auth\LogoutController\LogoutController;',
    'use App\Http\Controllers\Auth\ForgotPasswordController\ForgotPasswordController;',
    'use App\Http\Controllers\Auth\VerifyOtpController\VerifyOtpController;',
    'use App\Http\Controllers\Auth\ResetPasswordController\ResetPasswordController;',
    'use App\Http\Controllers\Auth\MeController\MeController;',
    'use App\Http\Controllers\Auth\DeleteAccountController\DeleteAccountController;',
    'use App\Http\Controllers\Auth\ChangePasswordController\ChangePasswordController;',
];

$content = str_replace('use App\Http\Controllers\Api\AuthController;', implode("\n", $imports), $content);

$content = str_replace("Route::post('/register', [AuthController::class, 'register']);", "Route::post('/register', RegisterController::class);", $content);
$content = str_replace("Route::post('/login', [AuthController::class, 'login']);", "Route::post('/login', LoginController::class);", $content);
$content = str_replace("Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);", "Route::post('/forgot-password', ForgotPasswordController::class);", $content);
$content = str_replace("Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);", "Route::post('/verify-otp', VerifyOtpController::class);", $content);
$content = str_replace("Route::post('/reset-password', [AuthController::class, 'resetPassword']);", "Route::post('/reset-password', ResetPasswordController::class);", $content);

$content = str_replace("Route::post('/logout', [AuthController::class, 'logout']);", "Route::post('/logout', LogoutController::class);", $content);
$content = str_replace("Route::post('/change-password', [AuthController::class, 'changePassword']);", "Route::post('/change-password', ChangePasswordController::class);", $content);
$content = str_replace("Route::delete('/delete-account', [AuthController::class, 'deleteAccount']);", "Route::delete('/delete-account', DeleteAccountController::class);", $content);
$content = str_replace("Route::get('/me', [AuthController::class, 'me']);", "Route::get('/me', MeController::class);", $content);

file_put_contents($file, $content);
echo "Routes updated.\n";
