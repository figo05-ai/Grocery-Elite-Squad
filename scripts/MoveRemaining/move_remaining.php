<?php

$baseDir = __DIR__.'/../app';
$routesFile = __DIR__.'/../routes/web.php';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 1. Move StripePaymentCallbackController
$oldStripe = "$baseDir/Http/Controllers/StripePaymentCallbackController.php";
if (file_exists($oldStripe)) {
    createDir("$baseDir/Http/Controllers/Order/StripePaymentCallbackController");
    $content = file_get_contents($oldStripe);
    $content = str_replace('namespace App\Http\Controllers;', 'namespace App\Http\Controllers\Order\StripePaymentCallbackController;', $content);
    file_put_contents("$baseDir/Http/Controllers/Order/StripePaymentCallbackController/StripePaymentCallbackController.php", $content);
    unlink($oldStripe);
}

// 2. Move WebChatController
$oldChat = "$baseDir/Http/Controllers/WebChatController.php";
if (file_exists($oldChat)) {
    createDir("$baseDir/Http/Controllers/Support/WebChatController");
    $content = file_get_contents($oldChat);
    $content = str_replace('namespace App\Http\Controllers;', 'namespace App\Http\Controllers\Support\WebChatController;', $content);
    file_put_contents("$baseDir/Http/Controllers/Support/WebChatController/WebChatController.php", $content);
    unlink($oldChat);
}

// 3. Update routes/web.php if needed
if (file_exists($routesFile)) {
    $content = file_get_contents($routesFile);

    // Stripe
    $content = str_replace('App\Http\Controllers\StripePaymentCallbackController', 'App\Http\Controllers\Order\StripePaymentCallbackController\StripePaymentCallbackController', $content);

    // WebChat
    $content = str_replace('App\Http\Controllers\WebChatController', 'App\Http\Controllers\Support\WebChatController\WebChatController', $content);

    file_put_contents($routesFile, $content);
}

echo "Remaining controllers moved successfully.\n";
