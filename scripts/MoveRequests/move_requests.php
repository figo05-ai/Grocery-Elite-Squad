<?php

$baseDir = __DIR__.'/../app';
$projectDir = __DIR__.'/..';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

$moves = [
    'CreateStripeCheckoutSessionRequest' => 'Order\CreateStripeCheckoutSessionRequest\CreateStripeCheckoutSessionRequest',
    'StoreOrderRequest' => 'Order\StoreOrderRequest\StoreOrderRequest',
];

foreach ($moves as $request => $newPath) {
    $oldFile = "$baseDir/Http/Requests/$request.php";
    if (! file_exists($oldFile)) {
        continue;
    }

    $parts = explode('\\', $newPath);
    $className = array_pop($parts);
    $namespaceSuffix = implode('\\', $parts);

    $newDir = "$baseDir/Http/Requests/".str_replace('\\', '/', $namespaceSuffix);
    createDir($newDir);

    $newFile = "$newDir/$className.php";

    $content = file_get_contents($oldFile);
    $content = preg_replace('/namespace App\\\\Http\\\\Requests;/', "namespace App\Http\Requests\\$namespaceSuffix;", $content);

    file_put_contents($newFile, $content);
    unlink($oldFile);
}

// 2. Replace usages
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

$directoriesToSearch = [
    "$projectDir/app",
];
$allFiles = [];
foreach ($directoriesToSearch as $dir) {
    $allFiles = array_merge($allFiles, scanAllFiles($dir));
}

foreach ($allFiles as $file) {
    $content = file_get_contents($file);
    $original = $content;

    foreach ($moves as $request => $newPath) {
        $content = str_replace("use App\\Http\\Requests\\$request;", "use App\\Http\\Requests\\$newPath;", $content);
    }

    if ($content !== $original) {
        file_put_contents($file, $content);
    }
}

// Cleanup old Api requests folder if any
exec('rm -rf '.escapeshellarg("$baseDir/Http/Requests/Api"));

echo "Request migration completed successfully.\n";
