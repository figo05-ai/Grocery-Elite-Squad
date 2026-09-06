<?php

$baseDir = __DIR__.'/../app/Http';
$projectDir = __DIR__.'/..';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

$moves = [
    // Auth
    'Middleware/Authenticate' => 'Middleware/Auth/Authenticate/Authenticate',
    'Middleware/RedirectIfAuthenticated' => 'Middleware/Auth/RedirectIfAuthenticated/RedirectIfAuthenticated',
    'Middleware/EnsureUserIsAdmin' => 'Middleware/Auth/EnsureUserIsAdmin/EnsureUserIsAdmin',

    // System
    'Middleware/EncryptCookies' => 'Middleware/System/EncryptCookies/EncryptCookies',
    'Middleware/PreventRequestsDuringMaintenance' => 'Middleware/System/PreventRequestsDuringMaintenance/PreventRequestsDuringMaintenance',
    'Middleware/TrimStrings' => 'Middleware/System/TrimStrings/TrimStrings',
    'Middleware/TrustProxies' => 'Middleware/System/TrustProxies/TrustProxies',
    'Middleware/ValidateSignature' => 'Middleware/System/ValidateSignature/ValidateSignature',
    'Middleware/VerifyCsrfToken' => 'Middleware/System/VerifyCsrfToken/VerifyCsrfToken',
];

foreach ($moves as $oldPath => $newPath) {
    $oldFile = "$baseDir/$oldPath.php";
    if (! file_exists($oldFile)) {
        continue;
    }

    $parts = explode('/', $newPath);
    $className = array_pop($parts);
    $namespaceSuffix = implode('\\', $parts);

    $newDir = "$baseDir/".str_replace('\\', '/', $namespaceSuffix);
    createDir($newDir);

    $newFile = "$newDir/$className.php";

    $content = file_get_contents($oldFile);

    // Replace old namespace App\Http\Middleware with new namespace App\Http\Middleware\Domain\Class
    $content = str_replace('namespace App\Http\Middleware;', "namespace App\Http\\$namespaceSuffix;", $content);

    file_put_contents($newFile, $content);
    unlink($oldFile);
}

// Now we need to update app/Http/Kernel.php
$kernelPath = "$baseDir/Kernel.php";
$kernelContent = file_get_contents($kernelPath);

foreach ($moves as $oldPath => $newPath) {
    $oldClassPath = str_replace('/', '\\', $oldPath);
    $newClassPath = str_replace('/', '\\', $newPath);

    $oldClass = 'App\Http\\'.$oldClassPath;
    $newClass = 'App\Http\\'.$newClassPath;

    $kernelContent = str_replace("$oldClass::class", "$newClass::class", $kernelContent);
}

file_put_contents($kernelPath, $kernelContent);

// Search inside other files (like bootstrap/app.php or providers) just in case EnsureUserIsAdmin is used elsewhere
function scanAllFiles($dir)
{
    $result = [];
    if (! is_dir($dir)) {
        return $result;
    }
    foreach (scandir($dir) as $filename) {
        if ($filename[0] === '.') {
            continue;
        }
        $filePath = $dir.'/'.$filename;
        if (is_dir($filePath)) {
            $result = array_merge($result, scanAllFiles($filePath));
        } else {
            if (pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
                $result[] = $filePath;
            }
        }
    }

    return $result;
}

$allFiles = array_merge(scanAllFiles("$projectDir/app"), scanAllFiles("$projectDir/bootstrap"), scanAllFiles("$projectDir/routes"));

foreach ($allFiles as $file) {
    $content = file_get_contents($file);
    $original = $content;

    foreach ($moves as $oldPath => $newPath) {
        $oldClassPath = str_replace('/', '\\', $oldPath);
        $newClassPath = str_replace('/', '\\', $newPath);

        $oldClass = 'App\Http\\'.$oldClassPath;
        $newClass = 'App\Http\\'.$newClassPath;

        $content = str_replace("use $oldClass;", "use $newClass;", $content);
        $content = str_replace("\\$oldClass::class", "\\$newClass::class", $content);

        // Specially for middleware names passed to routes like `middleware(\App\Http\Middleware\EnsureUserIsAdmin::class)`
        $content = str_replace("$oldClass::class", "$newClass::class", $content);
    }

    if ($content !== $original) {
        file_put_contents($file, $content);
    }
}

echo "Middleware refactored successfully.\n";
