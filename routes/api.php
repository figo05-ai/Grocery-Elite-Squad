<?php

use App\Http\Controllers\Api\V1\Auth\ChangePasswordController\ChangePasswordController;
// Auth Domain
use App\Http\Controllers\Api\V1\Auth\DeleteAccountController\DeleteAccountController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\LoginController\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController\LogoutController;
use App\Http\Controllers\Api\V1\Auth\MeController\MeController;
use App\Http\Controllers\Api\V1\Auth\RegisterController\RegisterController;
use App\Http\Controllers\Api\V1\Auth\ResetPasswordController\ResetPasswordController;
use App\Http\Controllers\Api\V1\Auth\VerifyOtpController\VerifyOtpController;
use App\Http\Controllers\Api\V1\Cart\ClearCartController\ClearCartController;
// User Domain (Profile, Address, Favorites, Loyalty, NotificationSettings, Settings)
use App\Http\Controllers\Api\V1\Cart\GetCartController\GetCartController;
use App\Http\Controllers\Api\V1\Catalog\Category\GetCategoriesController\GetCategoriesController;
use App\Http\Controllers\Api\V1\Catalog\Category\GetCategoryController\GetCategoryController;
use App\Http\Controllers\Api\V1\Catalog\Meal\GetDealsOfTheDayController\GetDealsOfTheDayController;
use App\Http\Controllers\Api\V1\Catalog\Meal\GetMealController\GetMealController;
use App\Http\Controllers\Api\V1\Catalog\Meal\GetMealsController\GetMealsController;
use App\Http\Controllers\Api\V1\Order\CreateOrderController\CreateOrderController;
use App\Http\Controllers\Api\V1\Order\GetOrderController\GetOrderController;
use App\Http\Controllers\Api\V1\Order\GetOrdersController\GetOrdersController;
use App\Http\Controllers\Api\V1\Order\TrackOrderController\TrackOrderController;
use App\Http\Controllers\Api\V1\Support\GetFaqsController\GetFaqsController;
use App\Http\Controllers\Api\V1\Support\SubmitContactMessageController\SubmitContactMessageController;
use App\Http\Controllers\Api\V1\System\GetAppConfigController\GetAppConfigController;
use App\Http\Controllers\Api\V1\System\GetStaticPageController\GetStaticPageController;
use App\Http\Controllers\Api\V1\User\Address\CreateAddressController\CreateAddressController;
use App\Http\Controllers\Api\V1\User\Address\DeleteAddressController\DeleteAddressController;
use App\Http\Controllers\Api\V1\User\Address\GetAddressController\GetAddressController;
use App\Http\Controllers\Api\V1\User\Address\GetAddressesController\GetAddressesController;
use App\Http\Controllers\Api\V1\User\Address\SetDefaultAddressController\SetDefaultAddressController;
use App\Http\Controllers\Api\V1\User\Address\UpdateAddressController\UpdateAddressController;
// Catalog Domain
use App\Http\Controllers\Api\V1\User\Favorite\CheckFavoriteController\CheckFavoriteController;
use App\Http\Controllers\Api\V1\User\Favorite\GetFavoritesController\GetFavoritesController;
use App\Http\Controllers\Api\V1\User\Favorite\ToggleFavoriteController\ToggleFavoriteController;
use App\Http\Controllers\Api\V1\User\Loyalty\GetLoyaltyPointsController\GetLoyaltyPointsController;
use App\Http\Controllers\Api\V1\User\NotificationSettings\GetNotificationSettingsController\GetNotificationSettingsController;
// Order Domain
use App\Http\Controllers\Api\V1\User\NotificationSettings\UpdateNotificationSettingsController\UpdateNotificationSettingsController;
use App\Http\Controllers\Api\V1\User\Profile\DeleteProfileImageController\DeleteProfileImageController;
use App\Http\Controllers\Api\V1\User\Profile\GetProfileController\GetProfileController;
use App\Http\Controllers\Api\V1\User\Profile\UpdateProfileImageController\UpdateProfileImageController;
// Cart Domain
use App\Http\Controllers\Api\V1\User\Profile\UpdateProfileInfoController\UpdateProfileInfoController;
use App\Http\Controllers\Api\V1\User\Settings\GetAppearanceController\GetAppearanceController;
// Support Domain
use App\Http\Controllers\Api\V1\User\Settings\GetLanguageController\GetLanguageController;
use App\Http\Controllers\Api\V1\User\Settings\UpdateAppearanceController\UpdateAppearanceController;
// System Domain
use App\Http\Controllers\Api\V1\User\Settings\UpdateLanguageController\UpdateLanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // ----------------------------------------------------
    // Public Routes
    // ----------------------------------------------------

    Route::prefix('auth')->group(function () {
        Route::post('/register', RegisterController::class);
        Route::post('/login', LoginController::class);
        Route::post('/forgot-password', ForgotPasswordController::class);
        Route::post('/verify-otp', VerifyOtpController::class);
        Route::post('/reset-password', ResetPasswordController::class);
    });

    Route::prefix('catalog')->group(function () {
        Route::get('/categories', GetCategoriesController::class);
        Route::get('/categories/{id}', GetCategoryController::class);
        Route::get('/meals', GetMealsController::class);
        Route::get('/meals/today-deals', GetDealsOfTheDayController::class);
        Route::get('/meals/{id}', GetMealController::class);
    });

    Route::prefix('support')->group(function () {
        Route::get('/faqs', GetFaqsController::class);
        Route::post('/contact', SubmitContactMessageController::class);
    });

    Route::prefix('system')->group(function () {
        Route::get('/pages/{slug}', GetStaticPageController::class);
        Route::get('/settings/config', GetAppConfigController::class);
    });

    // ----------------------------------------------------
    // Authenticated Routes
    // ----------------------------------------------------
    Route::middleware('auth:sanctum')->group(function () {

        // Auth / Account
        Route::prefix('auth')->group(function () {
            Route::get('/me', MeController::class);
            Route::post('/logout', LogoutController::class);
            Route::delete('/account', DeleteAccountController::class);
            Route::post('/change-password', ChangePasswordController::class);
        });

        // User Data (Profile, Addresses, Favorites, Loyalty, Settings)
        Route::prefix('user')->group(function () {
            // Profile
            Route::get('/profile', GetProfileController::class);
            Route::put('/profile', UpdateProfileInfoController::class);
            Route::post('/profile/image', UpdateProfileImageController::class);
            Route::delete('/profile/image', DeleteProfileImageController::class);

            // Addresses
            Route::prefix('addresses')->group(function () {
                Route::get('/', GetAddressesController::class);
                Route::post('/', CreateAddressController::class);
                Route::get('/{address}', GetAddressController::class);
                Route::put('/{address}', UpdateAddressController::class);
                Route::delete('/{address}', DeleteAddressController::class);
                Route::post('/{address}/default', SetDefaultAddressController::class);
            });

            // Favorites
            Route::prefix('favorites')->group(function () {
                Route::get('/', GetFavoritesController::class);
                Route::post('/toggle', ToggleFavoriteController::class);
                Route::get('/check/{meal_id}', CheckFavoriteController::class);
            });

            // Loyalty
            Route::get('/loyalty', GetLoyaltyPointsController::class);

            // Preferences
            Route::get('/notification-settings', GetNotificationSettingsController::class);
            Route::put('/notification-settings', UpdateNotificationSettingsController::class);
            Route::get('/language', GetLanguageController::class);
            Route::put('/language', UpdateLanguageController::class);
            Route::get('/appearance', GetAppearanceController::class);
            Route::put('/appearance', UpdateAppearanceController::class);
        });

        // Cart
        Route::prefix('cart')->group(function () {
            Route::get('/', GetCartController::class);
            Route::delete('/', ClearCartController::class);
        });

        // Orders
        Route::prefix('orders')->group(function () {
            Route::get('/', GetOrdersController::class);
            Route::post('/', CreateOrderController::class);
            Route::get('/track', TrackOrderController::class);
            Route::get('/{order}', GetOrderController::class);
        });

    });

    // Health check route
    Route::get('/health', function () {
        return response()->json([
            'success' => true,
            'message' => 'API is running successfully on v1 Architecture.',
            'timestamp' => now(),
        ]);
    });
});
