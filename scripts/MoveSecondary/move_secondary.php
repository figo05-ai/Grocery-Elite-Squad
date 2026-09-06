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
    // Services
    'Services/ChatbotService' => 'Services/Support/ChatbotService/ChatbotService',
    'Services/FrequencyService' => 'Services/Catalog/FrequencyService/FrequencyService',
    'Services/LoyaltyService' => 'Services/User/LoyaltyService/LoyaltyService',
    'Services/NotificationService' => 'Services/System/NotificationService/NotificationService',
    'Services/ShippingService' => 'Services/Order/ShippingService/ShippingService',
    'Services/StripeCheckoutService' => 'Services/Order/StripeCheckoutService/StripeCheckoutService',
    'Services/StripeWebhookService' => 'Services/Order/StripeWebhookService/StripeWebhookService',
    'Services/WishlistAlertService' => 'Services/Catalog/WishlistAlertService/WishlistAlertService',

    // Rules
    'Rules/EgyptianPhoneRules' => 'Rules/User/EgyptianPhoneRule/EgyptianPhoneRule',
    'Rules/UsernameMustContainLetter' => 'Rules/User/UsernameMustContainLetter/UsernameMustContainLetter',
    'Rules/EmailValidation' => 'Rules/User/EmailValidation/EmailValidation',

    // Jobs
    'Jobs/CreateInvoiceJob' => 'Jobs/Order/CreateInvoiceJob/CreateInvoiceJob',
    'Jobs/SendEmailJob' => 'Jobs/System/SendEmailJob/SendEmailJob',
    'Jobs/SendInvoiceEmailJob' => 'Jobs/Order/SendInvoiceEmailJob/SendInvoiceEmailJob',
    'Jobs/SendInvoiceJob' => 'Jobs/Order/SendInvoiceJob/SendInvoiceJob',
    'Jobs/SendToInventroyJob' => 'Jobs/Catalog/SendToInventoryJob/SendToInventoryJob', // Renaming typo here too!

    // Mail
    'Mail/InvoiceMail' => 'Mail/Order/InvoiceMail/InvoiceMail',
    'Mail/ContactAutoReply' => 'Mail/Support/ContactAutoReply/ContactAutoReply',
    'Mail/ContactMessageReceived' => 'Mail/Support/ContactMessageReceived/ContactMessageReceived',

    // Notifications
    'Notifications/WishlistPriceAlertNotification' => 'Notifications/Catalog/WishlistPriceAlertNotification/WishlistPriceAlertNotification',

    // AI Agents
    'Ai/Agents/GroceryAssistant' => 'Ai/Agents/Support/GroceryAssistant/GroceryAssistant',
    'Ai/Agents/OffersAgent' => 'Ai/Agents/Catalog/OffersAgent/OffersAgent',

    // AI Tools
    'Ai/Tools/CheckOffersTool' => 'Ai/Tools/Catalog/CheckOffersTool/CheckOffersTool',
    'Ai/Tools/ListCategoriesTool' => 'Ai/Tools/Catalog/ListCategoriesTool/ListCategoriesTool',
    'Ai/Tools/SearchProductsTool' => 'Ai/Tools/Catalog/SearchProductsTool/SearchProductsTool',

    // Filters
    'Filters/MealFilter' => 'Filters/Catalog/MealFilter/MealFilter',
    'Filters/QueryFilter' => 'Filters/System/QueryFilter/QueryFilter',
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

    // Dynamic namespace replacement
    $oldNamespaceParts = explode('/', ltrim($oldPath, '/'));
    array_pop($oldNamespaceParts); // remove class name
    $oldNamespace = 'App\\'.implode('\\', $oldNamespaceParts);
    $newNamespace = 'App\\'.$namespaceSuffix;

    $content = str_replace("namespace $oldNamespace;", "namespace $newNamespace;", $content);

    if (basename($oldFile, '.php') !== $className) {
        $oldClass = basename($oldFile, '.php');
        $content = preg_replace('/class\s+'.$oldClass.'\b/', 'class '.$className, $content);
    }

    file_put_contents($newFile, $content);
    unlink($oldFile);
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

$directoriesToSearch = [
    "$projectDir/app",
    "$projectDir/routes",
];
$allFiles = [];
foreach ($directoriesToSearch as $dir) {
    $allFiles = array_merge($allFiles, scanAllFiles($dir));
}

foreach ($allFiles as $file) {
    $content = file_get_contents($file);
    $original = $content;

    foreach ($moves as $oldPath => $newPath) {
        $oldClassPath = str_replace('/', '\\', $oldPath);
        $newClassPath = str_replace('/', '\\', $newPath);

        $oldClass = 'App\\'.$oldClassPath;
        $newClass = 'App\\'.$newClassPath;

        $content = str_replace("use $oldClass;", "use $newClass;", $content);
        $content = str_replace("\\$oldClass::", "\\$newClass::", $content);

        if (basename($oldPath) !== basename($newPath)) {
            $content = str_replace(basename($oldPath), basename($newPath), $content);
        }
    }

    if ($content !== $original) {
        file_put_contents($file, $content);
    }
}

// Cleanup old directories
$dirsToCheck = ['Services', 'Rules', 'Jobs', 'Mail', 'Notifications', 'Ai/Agents', 'Ai/Tools', 'Ai', 'Filters'];
// For services we ONLY delete specific files, the folder already contains 'Auth', 'User' etc.
// So we won't delete the root Services folder, but we can delete others.
foreach (['Rules', 'Jobs', 'Mail', 'Notifications', 'Ai', 'Filters'] as $dir) {
    exec('rm -rf '.escapeshellarg("$baseDir/$dir").' 2>/dev/null');
}

echo "Secondary folders domain migration completed successfully.\n";
