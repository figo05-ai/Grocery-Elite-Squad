<?php

$baseDir = __DIR__.'/../app';
$projectDir = __DIR__.'/..';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

$oldTrait = "$baseDir/Traits/V1/ApiResponse.php";
if (file_exists($oldTrait)) {
    createDir("$baseDir/Support/Traits/ApiResponse");
    $content = file_get_contents($oldTrait);
    $content = str_replace('namespace App\Traits\V1;', 'namespace App\Support\Traits\ApiResponse;', $content);
    file_put_contents("$baseDir/Support/Traits/ApiResponse/ApiResponse.php", $content);
    unlink($oldTrait);
}

// Global replacement
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

$allFiles = scanAllFiles("$projectDir/app");
foreach ($allFiles as $file) {
    $content = file_get_contents($file);
    $original = $content;

    $content = str_replace('use App\Traits\V1\ApiResponse;', 'use App\Support\Traits\ApiResponse\ApiResponse;', $content);

    if ($content !== $original) {
        file_put_contents($file, $content);
    }
}

exec('rm -rf '.escapeshellarg("$baseDir/Traits"));

echo "Traits migration completed successfully.\n";
