<?php

$baseDir = __DIR__.'/../app';
$projectDir = __DIR__.'/..';

$moves = [
    // Cart Domain
    'Cart' => 'Cart\Cart\Cart',
    'CartItem' => 'Cart\CartItem\CartItem',

    // Catalog Domain
    'Category' => 'Catalog\Category\Category',
    'Subcategory' => 'Catalog\Subcategory\Subcategory',
    'Meal' => 'Catalog\Meal\Meal',
    'Offer' => 'Catalog\Offer\Offer',
    'Review' => 'Catalog\Review\Review',
    'SmartList' => 'Catalog\SmartList\SmartList',
    'SmartListMeal' => 'Catalog\SmartListMeal\SmartListMeal',

    // Order Domain
    'Order' => 'Order\Order\Order',
    'OrderItem' => 'Order\OrderItem\OrderItem',
    'OrderNote' => 'Order\OrderNote\OrderNote',
    'SpecialNote' => 'Order\SpecialNote\SpecialNote',

    // Support Domain
    'ContactMessage' => 'Support\ContactMessage\ContactMessage',
    'Faq' => 'Support\Faq\Faq',
    'ChatbotMessage' => 'Support\ChatbotMessage\ChatbotMessage',
    'SupportReport' => 'Support\SupportReport\SupportReport',

    // System Domain
    'Setting' => 'System\Setting\Setting',
    'StaticPage' => 'System\StaticPage\StaticPage',

    // User Domain Extras
    'UserNotificationSetting' => 'User\NotificationSetting\UserNotificationSetting',
    'Notification' => 'User\Notification\Notification', // If it's custom
];

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 1. Move and update models
foreach ($moves as $model => $newPath) {
    $oldFile = "$baseDir/Models/$model.php";
    if (! file_exists($oldFile)) {
        continue;
    }

    $parts = explode('\\', $newPath);
    $className = array_pop($parts);
    $namespaceSuffix = implode('\\', $parts);

    $newDir = "$baseDir/Models/".str_replace('\\', '/', $namespaceSuffix);
    createDir($newDir);

    $newFile = "$newDir/$className.php";

    $content = file_get_contents($oldFile);
    $content = preg_replace('/namespace App\\\\Models;/', "namespace App\Models\\$namespaceSuffix;", $content);

    file_put_contents($newFile, $content);
    unlink($oldFile);
}

// 2. Replace usages in all files
$directoriesToSearch = [
    "$projectDir/app",
    "$projectDir/database",
    "$projectDir/routes",
    "$projectDir/tests",
];

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

$allFiles = [];
foreach ($directoriesToSearch as $dir) {
    $allFiles = array_merge($allFiles, scanAllFiles($dir));
}

foreach ($allFiles as $file) {
    $content = file_get_contents($file);
    $original = $content;

    foreach ($moves as $model => $newPath) {
        // Replace `use App\Models\Model;` -> `use App\Models\Domain\Model\Model;`
        $content = str_replace("use App\\Models\\$model;", "use App\\Models\\$newPath;", $content);
        // Replace `\App\Models\Model::` -> `\App\Models\Domain\Model\Model::`
        $content = str_replace("\\App\\Models\\$model::", "\\App\\Models\\$newPath::", $content);
    }

    if ($content !== $original) {
        file_put_contents($file, $content);
    }
}

echo "Model migration completed successfully.\n";
