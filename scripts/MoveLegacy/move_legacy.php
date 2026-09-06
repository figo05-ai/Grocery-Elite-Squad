<?php

$moves = [
    'app/Ai/Agents/GroceryAssistant.php' => 'app/Ai/Catalog/GroceryAssistant/GroceryAssistant.php',
    'app/Ai/Agents/OffersAgent.php' => 'app/Ai/Catalog/OffersAgent/OffersAgent.php',
    'app/Ai/Tools/CheckOffersTool.php' => 'app/Ai/Catalog/CheckOffersTool/CheckOffersTool.php',
    'app/Ai/Tools/ListCategoriesTool.php' => 'app/Ai/Catalog/ListCategoriesTool/ListCategoriesTool.php',
    'app/Ai/Tools/SearchProductsTool.php' => 'app/Ai/Catalog/SearchProductsTool/SearchProductsTool.php',

    'app/Filters/MealFilter.php' => 'app/Filters/Catalog/MealFilter/MealFilter.php',
    'app/Filters/QueryFilter.php' => 'app/Filters/System/QueryFilter/QueryFilter.php',

    'app/Jobs/CreateInvoiceJob.php' => 'app/Jobs/Order/CreateInvoiceJob/CreateInvoiceJob.php',
    'app/Jobs/SendEmailJob.php' => 'app/Jobs/System/SendEmailJob/SendEmailJob.php',
    'app/Jobs/SendInvoiceEmailJob.php' => 'app/Jobs/Order/SendInvoiceEmailJob/SendInvoiceEmailJob.php',
    'app/Jobs/SendInvoiceJob.php' => 'app/Jobs/Order/SendInvoiceJob/SendInvoiceJob.php',
    'app/Jobs/SendToInventroyJob.php' => 'app/Jobs/Order/SendToInventroyJob/SendToInventroyJob.php',

    'app/Mail/ContactAutoReply.php' => 'app/Mail/Support/ContactAutoReply/ContactAutoReply.php',
    'app/Mail/ContactMessageReceived.php' => 'app/Mail/Support/ContactMessageReceived/ContactMessageReceived.php',
    'app/Mail/InvoiceMail.php' => 'app/Mail/Order/InvoiceMail/InvoiceMail.php',

    'app/Notifications/WishlistPriceAlertNotification.php' => 'app/Notifications/User/WishlistPriceAlertNotification/WishlistPriceAlertNotification.php',

    'app/Traits/HasNotificationPreferences.php' => 'app/Support/Traits/HasNotificationPreferences/HasNotificationPreferences.php',

    'app/Http/Resources/Api/MealResource.php' => 'app/Http/Resources/Catalog/MealResource/MealResource.php',
    'app/Http/Resources/Api/NotificationCollection.php' => 'app/Http/Resources/User/NotificationCollection/NotificationCollection.php',
    'app/Http/Resources/Api/NotificationResource.php' => 'app/Http/Resources/User/NotificationResource/NotificationResource.php',
    'app/Http/Resources/Api/OfferResource.php' => 'app/Http/Resources/Catalog/OfferResource/OfferResource.php',
    'app/Http/Resources/Api/ReviewResource.php' => 'app/Http/Resources/Catalog/ReviewResource/ReviewResource.php',
    'app/Http/Resources/Api/SmartListResource.php' => 'app/Http/Resources/User/SmartListResource/SmartListResource.php',
    'app/Http/Resources/Api/SpecialNoteResource.php' => 'app/Http/Resources/Order/SpecialNoteResource/SpecialNoteResource.php',
    'app/Http/Resources/Api/SupportReportResource.php' => 'app/Http/Resources/Support/SupportReportResource/SupportReportResource.php',
    'app/Http/Resources/Api/V1/MealResource.php' => 'app/Http/Resources/Catalog/MealResource/MealResource.php',
    'app/Http/Resources/ContactMessageCollection.php' => 'app/Http/Resources/Support/ContactMessageCollection/ContactMessageCollection.php',
    'app/Http/Resources/ContactMessageResource.php' => 'app/Http/Resources/Support/ContactMessageResource/ContactMessageResource.php',
    'app/Http/Resources/FaqCollection.php' => 'app/Http/Resources/Support/FaqCollection/FaqCollection.php',
    'app/Http/Resources/FaqResource.php' => 'app/Http/Resources/Support/FaqResource/FaqResource.php',
    'app/Http/Resources/SettingResource.php' => 'app/Http/Resources/System/SettingResource/SettingResource.php',
    'app/Http/Resources/StaticPageCollection.php' => 'app/Http/Resources/System/StaticPageCollection/StaticPageCollection.php',
    'app/Http/Resources/StaticPageResource.php' => 'app/Http/Resources/System/StaticPageResource/StaticPageResource.php',
];

foreach ($moves as $source => $destination) {
    if (file_exists($source)) {
        $dir = dirname($destination);
        if (! is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        rename($source, $destination);
        echo "Moved $source to $destination\n";
    } else {
        echo "Source not found: $source\n";
    }
}

echo "Done moving legacy files.\n";
