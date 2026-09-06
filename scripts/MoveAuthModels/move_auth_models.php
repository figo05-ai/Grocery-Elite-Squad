<?php

$baseDir = __DIR__.'/../app';
$routesDir = __DIR__.'/../routes';
$configDir = __DIR__.'/../config';
$databaseDir = __DIR__.'/../database';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// Move User Model
createDir("$baseDir/Models/User/User");
if (file_exists("$baseDir/Models/User.php")) {
    $content = file_get_contents("$baseDir/Models/User.php");
    $content = str_replace("namespace App\Models;", "namespace App\Models\User\User;", $content);
    file_put_contents("$baseDir/Models/User/User/User.php", $content);
    unlink("$baseDir/Models/User.php");
}

// Move Otp Model
createDir("$baseDir/Models/Auth/Otp");
if (file_exists("$baseDir/Models/Otp.php")) {
    $content = file_get_contents("$baseDir/Models/Otp.php");
    $content = str_replace("namespace App\Models;", "namespace App\Models\Auth\Otp;", $content);
    file_put_contents("$baseDir/Models/Auth/Otp/Otp.php", $content);
    unlink("$baseDir/Models/Otp.php");
}

// Mass search and replace in app, routes, config, database
$dirs = [$baseDir, $routesDir, $configDir, $databaseDir];
foreach ($dirs as $dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $path = $file->getPathname();
            $content = file_get_contents($path);
            $newContent = $content;

            $newContent = str_replace("App\Models\User;", "App\Models\User\User\User;", $newContent);
            $newContent = str_replace("App\Models\User::", "App\Models\User\User\User::", $newContent);
            $newContent = preg_replace('/use App\\\\Models\\\\User;/', 'use App\\Models\\User\\User\\User;', $newContent);

            $newContent = str_replace("App\Models\Otp;", "App\Models\Auth\Otp\Otp;", $newContent);
            $newContent = str_replace("App\Models\Otp::", "App\Models\Auth\Otp\Otp::", $newContent);
            $newContent = preg_replace('/use App\\\\Models\\\\Otp;/', 'use App\\Models\\Auth\\Otp\\Otp;', $newContent);

            if ($content !== $newContent) {
                file_put_contents($path, $newContent);
            }
        }
    }
}

echo "Models moved and namespaces updated.\n";
