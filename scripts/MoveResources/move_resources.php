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
    // Root Resources
    'ContactMessageCollection' => 'Support\ContactMessage\ContactMessageCollection\ContactMessageCollection',
    'ContactMessageResource' => 'Support\ContactMessage\ContactMessageResource\ContactMessageResource',
    'FaqCollection' => 'Support\Faq\FaqCollection\FaqCollection',
    'FaqResource' => 'Support\Faq\FaqResource\FaqResource',
    'SettingResource' => 'System\Setting\SettingResource\SettingResource',
    'StaticPageCollection' => 'System\StaticPage\StaticPageCollection\StaticPageCollection',
    'StaticPageResource' => 'System\StaticPage\StaticPageResource\StaticPageResource',

    // Api Resources
    'Api\NotificationCollection' => 'User\Notification\NotificationCollection\NotificationCollection',
    'Api\NotificationResource' => 'User\Notification\NotificationResource\NotificationResource',
    'Api\OfferResource' => 'Catalog\Offer\OfferResource\OfferResource',
    'Api\ReviewResource' => 'Catalog\Review\ReviewResource\ReviewResource',
    'Api\SmartListResource' => 'Catalog\SmartList\SmartListResource\SmartListResource',
    'Api\SpecialNoteResource' => 'Order\SpecialNote\SpecialNoteResource\SpecialNoteResource',
    'Api\SupportReportResource' => 'Support\SupportReport\SupportReportResource\SupportReportResource',
];

foreach ($moves as $oldPath => $newPath) {
    $oldFile = "$baseDir/Http/Resources/$oldPath.php";
    if (! file_exists($oldFile)) {
        continue;
    }

    $parts = explode('\\', $newPath);
    $className = array_pop($parts);
    $namespaceSuffix = implode('\\', $parts);

    $newDir = "$baseDir/Http/Resources/".str_replace('\\', '/', $namespaceSuffix);
    createDir($newDir);

    $newFile = "$newDir/$className.php";

    $content = file_get_contents($oldFile);

    // Replace old namespace
    $oldNamespacePart = strpos($oldPath, 'Api\\') === 0 ? 'App\Http\Resources\Api' : 'App\Http\Resources';
    $content = preg_replace("/namespace $oldNamespacePart;/", "namespace App\Http\Resources\\$namespaceSuffix;", $content);

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
$allFiles = scanAllFiles("$projectDir/app");

foreach ($allFiles as $file) {
    $content = file_get_contents($file);
    $original = $content;

    foreach ($moves as $oldPath => $newPath) {
        $oldClass = strpos($oldPath, 'Api\\') === 0 ? 'App\\Http\\Resources\\'.str_replace('/', '\\', $oldPath) : 'App\\Http\\Resources\\'.$oldPath;
        $newClass = "App\\Http\\Resources\\$newPath";

        $content = str_replace("use $oldClass;", "use $newClass;", $content);

        $oldBaseName = basename(str_replace('\\', '/', $oldPath));
        // Be careful not to replace `new FaqResource` indiscriminately unless we check imports, but string replacement on `new \App\Http\Resources\...`
        $content = str_replace("\\$oldClass", "\\$newClass", $content);
    }

    if ($content !== $original) {
        file_put_contents($file, $content);
    }
}

// Cleanup old Api requests folder if any
exec('rm -rf '.escapeshellarg("$baseDir/Http/Resources/Api"));

echo "Resource migration completed successfully.\n";
