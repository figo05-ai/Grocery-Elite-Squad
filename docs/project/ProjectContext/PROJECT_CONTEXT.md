# Laravel Brain AI Context
> Project: Grocery | Analyzed: 2026-09-04T21:08:17+00:00 | Focal: Full project summary | Budget: 50000 tokens

## Call Chain (depth ≤ 3)
admin:create-user 
                            {--username= : Username for the admin user}
                            {--email= : Email for the admin user}
                            {--password= : Password for the admin user} → CreateAdminUser@option

## Complexity Hotspots
| Label | Cyclomatic | Lines |
|-------|-----------|-------|
| MealController@index | 17 | 143 |
| CategoryController@meals | 11 | 118 |
| CartController@addItem | 10 | 114 |
| ChatbotController@chat | 10 | 94 |
| SubcategoryController@meals | 10 | 92 |
| GoogleAuthController@login | 9 | 111 |
| GoogleAuthController@isValidGooglePayload | 7 | 17 |
| Client@__construct | 7 | 74 |
| GoogleAuthController@uniqueUsernameForGoogle | 6 | 28 |
| FaqController@index | 6 | 48 |
| NotificationController@clearAll | 6 | 50 |
| NotificationController@indexWithResources | 6 | 108 |
| OrderController@store | 6 | 104 |
| OrderController@validateAndProcessCartItems | 6 | 67 |
| ProfileController@updateImage | 6 | 62 |
| ProfileController@updateInfo | 6 | 94 |
| StripePaymentCallbackController@success | 6 | 54 |
| CartController@updateItem | 5 | 60 |
| DashboardController@getCategoryDistribution | 5 | 50 |
| MealController@frequency | 5 | 71 |
| OfferController@index | 5 | 40 |
| StripeCheckoutController@verifySession | 5 | 67 |
| UpdateNotificationSettingsRequest@validated | 5 | 16 |
| ChatbotService@chat | 5 | 45 |
| StripeWebhookService@onCheckoutSessionCompleted | 5 | 33 |
| ContactController@submit | 4 | 58 |
| DashboardController@getOverview | 4 | 64 |
| DashboardController@getShoppingInsights | 4 | 73 |
| FavoriteController@remove | 4 | 36 |
| FavoriteController@toggle | 4 | 48 |
| MealController@getRecommendationReason | 4 | 16 |
| NotificationController@buildNotificationsQuery | 4 | 31 |
| NotificationController@notificationDataAsArray | 4 | 14 |
| OfferController@validateOffer | 4 | 38 |
| OrderController@track | 4 | 92 |
| ProfileController@deleteImage | 4 | 32 |
| SmartListController@update | 4 | 28 |
| StaticPageController@index | 4 | 30 |
| StripeCheckoutController@store | 4 | 41 |
| StripeWebhookController@handle | 4 | 30 |
| SupportController@store | 4 | 55 |
| AuthService@login | 4 | 30 |
| AuthController@login | 3 | 47 |
| AuthController@resetPassword | 3 | 35 |
| AuthController@verifyOtp | 3 | 32 |
| GoogleAuthController@allowedGoogleClientIds | 3 | 17 |
| CartController@index | 3 | 29 |
| CartController@removeItem | 3 | 36 |
| CategoryController@show | 3 | 51 |
| ContactController@isSpam | 3 | 17 |
| FavoriteController@check | 3 | 28 |
| MealController@show | 3 | 92 |
| NotificationSettingsController@updateCategory | 3 | 29 |
| PaymentController@receipt | 3 | 30 |
| ProfileController@destroySession | 3 | 27 |
| SmartListController@store | 3 | 26 |
| StaticPageController@showBySlug | 3 | 19 |
| SubcategoryController@index | 3 | 43 |
| SubcategoryController@show | 3 | 53 |
| StripePaymentCallbackController@resolveOrder | 3 | 13 |
| AuthService@forgotPassword | 3 | 24 |
| LoyaltyService@resolveCurrentTier | 3 | 12 |
| LoyaltyService@resolveNextTier | 3 | 10 |
| OtpService@generateOtpCode | 3 | 16 |
| StripeWebhookService@resolveOrderFromSession | 3 | 13 |
| admin:create-user 
                            {--username= : Username for the admin user}
                            {--email= : Email for the admin user}
                            {--password= : Password for the admin user} | 3 | 57 |
| Client@verifyIdToken | 3 | 23 |
| AddressController@index | 2 | 27 |
| AddressController@setDefault | 2 | 27 |
| AuthController@changePassword | 2 | 28 |
| AuthController@deleteAccount | 2 | 19 |
| AuthController@forgotPassword | 2 | 20 |
| AuthController@logout | 2 | 20 |
| AuthController@register | 2 | 24 |
| CartController@clear | 2 | 27 |
| CartController@formatCart | 2 | 52 |
| CategoryController@index | 2 | 33 |
| ChatbotController@history | 2 | 43 |
| DashboardController@index | 2 | 24 |
| FavoriteController@index | 2 | 66 |
| LoyaltyController@index | 2 | 16 |
| MealController@hot | 2 | 46 |
| MealController@newProducts | 2 | 22 |
| MealController@recommendations | 2 | 59 |
| MealController@today | 2 | 46 |
| NotificationController@destroyMultiple | 2 | 24 |
| NotificationController@markAllAsRead | 2 | 19 |
| NotificationController@markAsRead | 2 | 20 |
| NotificationController@markAsUnread | 2 | 20 |
| NotificationController@show | 2 | 15 |
| NotificationController@transformNotification | 2 | 28 |
| NotificationSettingsController@index | 2 | 17 |
| OrderController@clearUserCart | 2 | 8 |
| OrderController@createOrderItems | 2 | 15 |
| OrderController@index | 2 | 27 |
| PaymentController@paymentHistory | 2 | 44 |
| ProfileController@show | 2 | 83 |
| StripeController@createSetupIntent | 2 | 20 |
| StripeController@listCards | 2 | 14 |
| UserAppSettingsController@updateAppearance | 2 | 23 |
| UserAppSettingsController@updateLanguage | 2 | 23 |
| UserAppSettingsController@updateNotificationPreferences | 2 | 26 |
| WebChatController@send | 2 | 32 |
| AuthService@register | 2 | 25 |
| AuthService@resetPassword | 2 | 30 |
| LoyaltyService@profileInitial | 2 | 11 |
| NotificationService@sendOtpEmail | 2 | 17 |
| NotificationService@sendOtpSms | 2 | 30 |
| NotificationService@sendWelcomeEmail | 2 | 19 |
| OtpService@normalizeIdentifier | 2 | 10 |
| OtpService@verify | 2 | 19 |
| StripeWebhookService@onCheckoutSessionAbandoned | 2 | 26 |
| UserAppSettingsService@normalizeLanguage | 2 | 4 |
| UserAppSettingsService@normalizeTheme | 2 | 4 |
| mutateFormDataBeforeCreate | 2 | 9 |
| mutateFormDataBeforeSave | 2 | 9 |
| AddressController@destroy | 1 | 19 |
| AddressController@formatAddress | 1 | 27 |
| AddressController@show | 1 | 10 |
| AddressController@store | 1 | 26 |
| AddressController@update | 1 | 21 |
| AuthController@me | 1 | 33 |
| ChatbotController@suggestions | 1 | 27 |
| DashboardController@getRecentOrders | 1 | 20 |
| DashboardController@getTopPurchases | 1 | 28 |
| DataManagementController@delete | 1 | 10 |
| DataManagementController@download | 1 | 12 |
| MealController@bestSells | 1 | 14 |
| MealController@brands | 1 | 10 |
| MealController@moreToExplore | 1 | 13 |
| MealController@slider | 1 | 32 |
| NotificationController@byType | 1 | 23 |
| NotificationController@destroy | 1 | 12 |
| NotificationController@getIconForType | 1 | 19 |
| NotificationController@index | 1 | 24 |
| NotificationController@recent | 1 | 23 |
| NotificationController@stats | 1 | 50 |
| NotificationController@unreadCount | 1 | 13 |
| NotificationSettingsController@defaultSettingsStructure | 1 | 41 |
| NotificationSettingsController@formatSettings | 1 | 41 |
| NotificationSettingsController@getCategoryFields | 1 | 11 |
| NotificationSettingsController@update | 1 | 14 |
| OfferController@featured | 1 | 9 |
| OfferController@showByCode | 1 | 6 |
| OrderController@createOrder | 1 | 21 |
| OrderController@formatOrder | 1 | 73 |
| OrderController@show | 1 | 10 |
| PaymentController@formatReceipt | 1 | 100 |
| PaymentController@getPaymentMethodDisplay | 1 | 11 |
| ProfileController@formatAddress | 1 | 23 |
| ProfileController@formatNotification | 1 | 15 |
| ProfileController@formatOrderSummary | 1 | 13 |
| ProfileController@formatOrderWithTracking | 1 | 40 |
| ProfileController@formatSessions | 1 | 13 |
| ProfileController@formatWishlistItem | 1 | 16 |
| ProfileController@sessions | 1 | 21 |
| SettingController@index | 1 | 8 |
| SmartListController@addMeal | 1 | 12 |
| SmartListController@destroy | 1 | 11 |
| SmartListController@index | 1 | 9 |
| SmartListController@removeMeal | 1 | 11 |
| SmartListController@show | 1 | 9 |
| SpecialNoteController@index | 1 | 8 |
| StaticPageController@importantPages | 1 | 11 |
| StripeController@chargeSavedCard | 1 | 21 |
| StripeController@deleteCard | 1 | 9 |
| UserAppSettingsController@showAppearance | 1 | 7 |
| UserAppSettingsController@showLanguage | 1 | 7 |
| UserAppSettingsController@showNotificationPreferences | 1 | 7 |
| CategoryController@index | 1 | 7 |
| MealController@index | 1 | 6 |
| StripePaymentCallbackController@cancel | 1 | 8 |
| StripePaymentCallbackController@jsonOrHtml | 1 | 8 |
| WebChatController@getOrCreateDemoUser | 1 | 12 |
| WebChatController@index | 1 | 4 |
| WebChatController@reset | 1 | 6 |
| UpdateNotificationSettingsRequest@rules | 1 | 19 |
| MealResource@toArray | 1 | 11 |
| OfferResource@getTypeLabel | 1 | 10 |
| OfferResource@toArray | 1 | 24 |
| SmartListResource@toArray | 1 | 14 |
| SpecialNoteResource@toArray | 1 | 7 |
| SupportReportResource@toArray | 1 | 11 |
| ContactMessageResource@toArray | 1 | 15 |
| FaqCollection@toArray | 1 | 20 |
| SettingResource@toArray | 1 | 30 |
| StaticPageCollection@toArray | 1 | 12 |
| StaticPageResource@toArray | 1 | 16 |
| GroceryAssistant@__construct | 1 | 1 |
| ContactAutoReply@build | 1 | 11 |
| ContactMessageReceived@build | 1 | 9 |
| AuthService@deleteAccount | 1 | 9 |
| AuthService@logout | 1 | 7 |
| AuthService@verifyOtp | 1 | 4 |
| LoyaltyService@buildSummary | 1 | 23 |
| LoyaltyService@discountLabel | 1 | 10 |
| LoyaltyService@formatCoupons | 1 | 22 |
| LoyaltyService@formatMembership | 1 | 25 |
| LoyaltyService@tierDefinitions | 1 | 14 |
| NotificationService@getEmailMessage | 1 | 16 |
| NotificationService@getEmailSubject | 1 | 9 |
| NotificationService@getSmsMessage | 1 | 6 |
| OtpService@generate | 1 | 20 |
| OtpService@normalizeOtpInput | 1 | 4 |
| StripeCheckoutService@createSessionForOrder | 1 | 40 |
| StripeWebhookService@handleEvent | 1 | 10 |
| UserAppSettingsService@buildDataExport | 1 | 41 |
| UserAppSettingsService@getAppearance | 1 | 6 |
| UserAppSettingsService@getLanguage | 1 | 6 |
| UserAppSettingsService@getNotificationPreferences | 1 | 11 |
| UserAppSettingsService@updateAppearance | 1 | 6 |
| UserAppSettingsService@updateLanguage | 1 | 6 |
| UserAppSettingsService@updateNotificationPreferences | 1 | 12 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 4 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |
| getHeaderActions | 1 | 6 |

## Database Operations
- eloquent with meals (via MealController@index)
- eloquent findOrFail categories (via CategoryController@meals)
- eloquent findOrFail meals (via CartController@addItem)
- eloquent where chatbot_messages (via ChatbotController@chat)
- eloquent findOrFail subcategories (via SubcategoryController@meals)
- eloquent where users (via GoogleAuthController@login)
- eloquent create users (via GoogleAuthController@login)
- eloquent query faqs (via FaqController@index)
- eloquent query meals (via NotificationController@indexWithResources)
- eloquent query orders (via NotificationController@indexWithResources)
- eloquent create order_notes (via OrderController@store)
- eloquent query orders (via StripeCheckoutController@verifySession)
- eloquent create contact_messages (via ContactController@submit)
- eloquent findOrFail meals (via FavoriteController@remove)
- eloquent findOrFail meals (via FavoriteController@toggle)
- eloquent where offers (via OfferController@validateOffer)
- eloquent where orders (via OrderController@track)
- eloquent where smart_lists (via SmartListController@update)
- eloquent query static_pages (via StaticPageController@index)
- eloquent query orders (via StripeCheckoutController@store)
- eloquent query orders (via StripeWebhookController@handle)
- eloquent query orders (via SupportController@store)
- eloquent create support_reports (via SupportController@store)
- eloquent where otps (via AuthController@resetPassword)
- eloquent where otps (via AuthController@verifyOtp)
- eloquent with categories (via CategoryController@show)
- eloquent findOrFail meals (via FavoriteController@check)
- eloquent with meals (via MealController@show)
- eloquent load orders (via PaymentController@receipt)
- eloquent create smart_lists (via SmartListController@store)
- eloquent with subcategories (via SubcategoryController@index)
- eloquent with subcategories (via SubcategoryController@show)
- eloquent where otps (via AuthController@forgotPassword)
- eloquent create otps (via AuthController@forgotPassword)
- eloquent create users (via AuthController@register)
- eloquent with meals (via MealController@hot)
- eloquent with meals (via MealController@newProducts)
- eloquent with meals (via MealController@recommendations)
- eloquent with meals (via MealController@today)
- eloquent with orders (via OrderController@index)
- eloquent where orders (via PaymentController@paymentHistory)
- eloquent where orders (via ProfileController@show)
- eloquent with meals (via MealController@bestSells)
- eloquent with meals (via MealController@moreToExplore)
- eloquent with meals (via MealController@slider)
- eloquent where offers (via OfferController@showByCode)
- eloquent load orders (via OrderController@show)
- eloquent where smart_lists (via SmartListController@addMeal)
- eloquent where smart_lists (via SmartListController@destroy)
- eloquent where smart_lists (via SmartListController@index)
- eloquent where smart_lists (via SmartListController@removeMeal)
- eloquent where smart_lists (via SmartListController@show)
- eloquent all special_notes (via SpecialNoteController@index)
- eloquent query categories (via CategoryController@index)
- eloquent query meals (via MealController@index)

## Backend Packages (composer.json)
| Package | Version | Dev |
|---------|---------|-----|
| barryvdh/laravel-dompdf | ^3.1 |  |
| fakerphp/faker | ^1.23 | yes |
| filament/filament | ^3.3 |  |
| google/apiclient | ^2.19 |  |
| guzzlehttp/guzzle | ^7.2 |  |
| intervention/image | ^2.7 |  |
| laramint/laravel-brain | ^2.6 |  |
| laravel/ai | ^0.7 |  |
| laravel/framework | ^12.0 |  |
| laravel/pint | ^1.18 | yes |
| laravel/sail | ^1.41 | yes |
| laravel/sanctum | ^4.0 |  |
| laravel/socialite | ^5.24 |  |
| laravel/tinker | ^2.10 |  |
| mockery/mockery | ^1.6 | yes |
| nunomaduro/collision | ^8.6 | yes |
| phpunit/phpunit | ^11.5 | yes |
| spatie/laravel-ignition | ^2.9 | yes |
| stripe/stripe-php | ^19.1 |  |
## Source: MealController@index (focal)
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Services\FrequencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class MealController extends Controller
{
    /**
     * Get meals the authenticated user orders most often (personalized by frequency type).
     * Query param: frequency_type = daily|weekly|monthly (default: weekly).
     */
    public function frequency(Request $request): JsonResponse
    {
        try {
            $frequencyType = $request->input('frequency_type', FrequencyService::FREQUENCY_WEEKLY);
            if (! in_array($frequencyType, FrequencyService::VALID_TYPES, true)) {
                $frequencyType = FrequencyService::FREQUENCY_WEEKLY;
            }

            $user = $request->user();
            if ($user === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required to view frequency meals.',
                ], 401);
            }

            $subcategoryId = $request->input('subcategory_id');
            $subcategoryId = is_numeric($subcategoryId) ? (int) $subcategoryId : null;

            $service = app(FrequencyService::class);
            $meals = $service->getFrequentlyOrderedMeals($user, $frequencyType, 50, $subcategoryId);

            $data = $meals->map(function ($meal) {
                return [
                    'id' => $meal->id,
                    'title' => $meal->title,
                    'slug' => $meal->slug,
                    'description' => $meal->description,
                    'image_url' => $meal->image_url,
                    'offer_title' => $meal->offer_title,
                    ...$meal->getApiPriceAttributes(),
                    'has_offer' => $meal->hasOffer(),
                    'category' => $meal->category ? [
                        'id' => $meal->category->id,
                        'name' => $meal->category->name,
                    ] : null,
                    'subcategory' => $meal->subcategory ? [
                        'id' => $meal->subcategory->id,
                        'name' => $meal->subcategory->name,
                    ] : null,
                    'features' => $meal->features,
                    'available_date' => $meal->available_date,
                    'created_at' => $meal->created_at,
                    'order_count' => (int) $meal->getAttribute('order_count'),
                ];
            })->values();

            $payload = [
                'success' => true,
                'message' => 'Frequency meals retrieved successfully',
                'frequency_type' => $frequencyType,
                'data' => $data,
            ];
            if ($subcategoryId !== null) {
                $payload['subcategory_id'] = $subcategoryId;
            }

            return response()->json($payload);
        } catch (Throwable $e) {
            Log::error('Frequency meals error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load frequency meals',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    public function moreToExplore(Request $request)
    {
        $meals = Meal::with('category')
            ->available()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'More to explore retrieved successfully',
            'data' => $meals,
        ]);
    }

    public function brands(Request $request)
    {
        $brands = Meal::distinct()->pluck('brand');

        return response()->json([
            'success' => true,
            'message' => 'Brands retrieved successfully',
            'data' => $brands,
        ]);
    }

    public function slider(Request $request)
    {
        $meals = Meal::with('category')
            ->available()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($meal) {
                return [
                    'id' => $meal->id,
                    'title' => $meal->title,
                    'slug' => $meal->slug,
                    'description' => $meal->description,
                    'image_url' => $meal->image_url,
                    'offer_title' => $meal->offer_title,
                    ...$meal->getApiPriceAttributes(),
                    'has_offer' => $meal->hasOffer(),
                    'category' => [
                        'id' => $meal->category->id,
                        'name' => $meal->category->name,
                    ],
                    'features' => $meal->features,
                    'available_date' => $meal->available_date,
                    'created_at' => $meal->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Today\'s meals retrieved successfully',
            'data' => $meals,
        ]);
    }

    public function bestSells(Request $request)
    {
        $meals = Meal::with('category')
            ->available()

            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Best sells retrieved successfully',
            'data' => $meals,
        ]);
    }

    public function newProducts(Request $request)
    {

        try {
            $meals = Meal::with('category')
                ->available()
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'New products retrieved successfully',
                'data' => $meals,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve meals',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get hot / Ready-to-eat meals only.
     */
    public function hot(Request $request): JsonResponse
    {
        try {
            $meals = Meal::with('category')
                ->available()
                ->hot()
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($meal) {
                    return [
                        'id' => $meal->id,
                        'title' => $meal->title,
                        'slug' => $meal->slug,
                        'description' => $meal->description,
                        'image_url' => $meal->image_url,
                        'offer_title' => $meal->offer_title,
                        ...$meal->getApiPriceAttributes(),
                        'has_offer' => $meal->hasOffer(),
                        'rating' => (float) $meal->rating,
                        'rating_count' => (int) $meal->rating_count,
                        'brand' => $meal->brand,
                        'stock_quantity' => (int) $meal->stock_quantity,
                        'in_stock' => $meal->isInStock(),
                        'category' => [
                            'id' => $meal->category->id,
                            'name' => $meal->category->name,
                        ],
                        'features' => $meal->features,
                        'available_date' => $meal->available_date,
                        'created_at' => $meal->created_at,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Hot meals retrieved successfully',
                'data' => $meals,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve hot meals',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get today's deals (meals with active discounts)
     */
    public function today(Request $request): JsonResponse
    {
        try {
            $meals = Meal::with('category')
                ->available()
                ->withActiveDiscount()
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($meal) {
                    return [
                        'id' => $meal->id,
                        'title' => $meal->title,
                        'slug' => $meal->slug,
                        'description' => $meal->description,
                        'image_url' => $meal->image_url,
                        'offer_title' => $meal->offer_title,
                        ...$meal->getApiPriceAttributes(),
                        'has_offer' => $meal->hasOffer(),
                        'rating' => (float) $meal->rating,
                        'rating_count' => (int) $meal->rating_count,
                        'brand' => $meal->brand,
                        'stock_quantity' => (int) $meal->stock_quantity,
                        'in_stock' => $meal->isInStock(),
                        'category' => [
                            'id' => $meal->category->id,
                            'name' => $meal->category->name,
                        ],
                        'features' => $meal->features,
                        'available_date' => $meal->available_date,
                        'created_at' => $meal->created_at,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Today\'s deals retrieved successfully',
                'data' => $meals,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve today\'s deals',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all meals
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $query = Meal::with(['category', 'subcategory'])->available();

            // SEARCH by title or description
            if ($request->has('search') && $request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // FILTER by category
            if ($request->has('category_id')) {
                $query->where('category_id', $request->input('category_id'));
            }

            // FILTER by subcategory
            if ($request->has('subcategory_id')) {
                $query->where('subcategory_id', $request->input('subcategory_id'));
            }

            // FILTER by featured (featured=1/true → featured only, featured=0/false → non-featured only)
            if ($request->has('featured')) {
                $request->boolean('featured') ? $query->featured() : $query->where('is_featured', false);
            }

            // FILTER by in stock (in_stock=1/true → in stock only, in_stock=0/false → out of stock only)
            if ($request->has('in_stock')) {
                $request->boolean('in_stock') ? $query->inStock() : $query->outOfStock();
            }

            // FILTER by price range
            if ($request->has('min_price')) {
                $minPrice = $request->input('min_price');
                $query->whereRaw('COALESCE(discount_price, price) >= ?', [$minPrice]);
            }
            if ($request->has('max_price')) {
                $maxPrice = $request->input('max_price');
                $query->whereRaw('COALESCE(discount_price, price) <= ?', [$maxPrice]);
            }

            // FILTER by rating
            if ($request->has('min_rating')) {
                $minRating = $request->input('min_rating');
                $query->where('rating', '>=', $minRating);
            }

            // FILTER by brand
            if ($request->has('brand')) {
                $query->where('brand', $request->input('brand'));
            }

            // SORTING (sort_by: created_at|price|rating|title|sold_count|newest, sort_order: asc|desc)
            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = strtolower($request->input('sort_order', 'desc')) === 'asc' ? 'asc' : 'desc';
            if ($sortBy === 'newest') {
                $sortBy = 'created_at';
                $sortOrder = 'desc';
            }
            $allowedSortFields = ['created_at', 'price', 'rating', 'title', 'sold_count'];
            if (in_array($sortBy, $allowedSortFields)) {
                if ($sortBy === 'price') {
                    $query->orderByRaw('COALESCE(discount_price, price) '.$sortOrder);
                } else {
                    $query->orderBy($sortBy, $sortOrder);
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            // Get favorite meal IDs for the authenticated user
            $favoriteMealIds = [];
            if ($user) {
                $favoriteMealIds = $user->favorites()->pluck('meal_id')->toArray();
            }

            $meals = $query->get()
                ->map(function ($meal) use ($favoriteMealIds) {
                    return [
                        'id' => $meal->id,
                        'title' => $meal->title,
                        'slug' => $meal->slug,
                        'description' => $meal->description,
                        'image_url' => $meal->image_url,
                        'offer_title' => $meal->offer_title,
                        ...$meal->getApiPriceAttributes(),
                        'has_offer' => $meal->hasOffer(),
                        'rating' => (float) $meal->rating,
                        'rating_count' => (int) $meal->rating_count,
                        'size' => $meal->size,
                        'brand' => $meal->brand,
                        'stock_quantity' => $meal->stock_quantity,
                        'in_stock' => $meal->isInStock(),
                        'is_featured' => $meal->is_featured,
                        'sold_count' => $meal->sold_count,
                        'category' => [
                            'id' => $meal->category->id,
                            'name' => $meal->category->name,
                        ],
                        'subcategory' => $meal->subcategory ? [
                            'id' => $meal->subcategory->id,
                            'name' => $meal->subcategory->name,
                        ] : null,
                        'features' => $meal->features,
                        'is_favorited' => in_array($meal->id, $favoriteMealIds),
                        'created_at' => $meal->created_at,
                    ];
                });

            $totalCount = $meals->count();
            $isEmpty = $totalCount === 0;

            return response()->json(array_merge([
                'success' => true,
                'message' => $isEmpty ? 'No products match your filters.' : 'Meals retrieved successfully',
                'data' => $meals,
                'total_count' => $totalCount,
                'filters_applied' => [
                    'search' => $request->input('search'),
                    'category_id' => $request->input('category_id'),
                    'subcategory_id' => $request->input('subcategory_id'),
                    'min_price' => $request->input('min_price'),
                    'max_price' => $request->input('max_price'),
                    'min_rating' => $request->input('min_rating'),
                    'brand' => $request->input('brand'),
                    'featured' => $request->boolean('featured'),
                    'in_stock' => $request->boolean('in_stock'),
                    'sort_by' => $sortBy,
                    'sort_order' => $sortOrder,
                ],
            ], $isEmpty ? ['empty_message' => 'No products match the applied filters. Try adjusting your search or filters.'] : []));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve meals',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get recommended meals
     */
    public function recommendations(Request $request): JsonResponse
    {
        try {
            $limit = $request->input('limit', 10);

            // Get featured meals with offers
            $featuredMeals = Meal::with('category')
                ->available()
                ->featured()
                ->whereNotNull('discount_price')
                ->inRandomOrder()
                ->limit(ceil($limit / 2))
                ->get();

            // Get random meals from different categories
            $randomMeals = Meal::with('category')
                ->available()
                ->whereNotIn('id', $featuredMeals->pluck('id'))
                ->inRandomOrder()
                ->limit($limit - $featuredMeals->count())
                ->get();

            // Combine and shuffle
            $recommendations = $featuredMeals->merge($randomMeals)->shuffle()->take($limit);

            $meals = $recommendations->map(function ($meal) {
                return [
                    'id' => $meal->id,
                    'title' => $meal->title,
                    'slug' => $meal->slug,
                    'description' => $meal->description,
                    'image_url' => $meal->image_url,
                    'offer_title' => $meal->offer_title,
                    ...$meal->getApiPriceAttributes(),
                    'has_offer' => $meal->hasOffer(),
                    'is_featured' => $meal->is_featured,
                    'category' => [
                        'id' => $meal->category->id,
                        'name' => $meal->category->name,
                        'slug' => $meal->category->slug,
                    ],
                    'features' => $meal->features,
                    'recommendation_reason' => $this->getRecommendationReason($meal),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Meal recommendations retrieved successfully',
                'data' => $meals->values(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve recommendations',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get recommendation reason for a meal
     */
    private function getRecommendationReason($meal): string
    {
        if ($meal->is_featured && $meal->discount_price) {
            return 'Featured with special offer';
        }

        if ($meal->is_featured) {
            return 'Featured meal';
        }

        if ($meal->discount_price) {
            return 'Special offer';
        }

        return 'Popular choice';
    }

    /**
     * Get single meal
     */
    public function show(string $id): JsonResponse
    {
        try {
            $meal = Meal::with([
                'category',
                'subcategory',
                'reviews' => fn ($q) => $q->approved()->with('user:id,username,firstname,lastname')->orderBy('created_at', 'desc'),
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Meal retrieved successfully',
                'data' => [
                    'id' => $meal->id,
                    'title' => $meal->title,
                    'slug' => $meal->slug,
                    'description' => $meal->description,
                    'image_url' => $meal->image_url,
                    'offer_title' => $meal->offer_title,

                    // Pricing
                    ...$meal->getApiPriceAttributes(),
                    'has_offer' => $meal->hasOffer(),

                    // Rating
                    'rating' => (float) $meal->rating,
                    'rating_count' => (int) $meal->rating_count,

                    // Product details
                    'size' => $meal->size,
                    'brand' => $meal->brand,
                    'includes' => $meal->includes,
                    'how_to_use' => $meal->how_to_use,
                    'features' => $meal->features,

                    // Expiry and availability
                    'expiry_date' => $meal->expiry_date,
                    'days_until_expiry' => $meal->daysUntilExpiry(),
                    'is_expired' => $meal->isExpired(),

                    // Stock
                    'stock_quantity' => $meal->stock_quantity,
                    'in_stock' => $meal->isInStock(),
                    'sold_count' => $meal->sold_count,

                    // Status
                    'is_featured' => $meal->is_featured,
                    'is_available' => $meal->is_available,
                    'available_date' => $meal->available_date,

                    // Relationships
                    'category' => [
                        'id' => $meal->category->id,
                        'name' => $meal->category->name,
                        'slug' => $meal->category->slug,
                    ],
                    'reviews' => $meal->reviews->map(function ($review) {
                        return [
                            'id' => $review->id,
                            'user' => $review->relationLoaded('user') && $review->user ? [
                                'id' => $review->user->id,
                                'name' => $review->user->full_name ?? $review->user->username ?? 'User',
                            ] : null,
                            'rating' => (int) $review->rating,
                            'comment' => $review->comment,
                            'images' => $review->images ?? [],
                            'created_at' => $review->created_at?->toIso8601String(),
                        ];
                    })->values(),
                    'subcategory' => $meal->subcategory ? [
                        'id' => $meal->subcategory->id,
                        'name' => $meal->subcategory->name,
                        'slug' => $meal->subcategory->slug,
                    ] : null,

                    'created_at' => $meal->created_at,
                    'updated_at' => $meal->updated_at,
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Meal not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve meal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

```

## Source: CategoryController@meals
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all categories
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $categories = Category::active()
                ->ordered()
                ->withCount('meals')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'description' => $category->description,
                        'image_url' => $category->image_url,
                        'meals_count' => $category->meals_count,
                        'sort_order' => $category->sort_order,
                        'created_at' => $category->created_at,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Categories retrieved successfully',
                'data' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get single category with meals
     */
    public function show(string $id): JsonResponse
    {
        try {
            $category = Category::with(['meals' => function ($query) {
                $query->available()->orderBy('created_at', 'desc');
            }])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Category retrieved successfully',
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'image_url' => $category->image_url,
                    'sort_order' => $category->sort_order,
                    'meals' => $category->meals->map(function ($meal) {
                        return [
                            'id' => $meal->id,
                            'title' => $meal->title,
                            'slug' => $meal->slug,
                            'description' => $meal->description,
                            'image_url' => $meal->image_url,
                            'offer_title' => $meal->offer_title,
                            ...$meal->getApiPriceAttributes(),
                            'rating' => (float) $meal->rating,
                            'rating_count' => (int) $meal->rating_count,
                            'has_offer' => $meal->hasOffer(),
                            'is_featured' => $meal->is_featured,
                            'features' => $meal->features,
                        ];
                    }),
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at,
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve category',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get meals by category (paginated)
     */
    public function meals(string $id, Request $request): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);

            $query = $category->meals()->with(['subcategory'])->available();

            // Filter by featured if provided (featured=1/true → featured only, featured=0/false → non-featured only)
            if ($request->has('featured')) {
                $request->boolean('featured') ? $query->featured() : $query->where('is_featured', false);
            }

            // Filter by subcategory if provided
            if ($request->has('subcategory_id')) {
                $query->where('subcategory_id', $request->input('subcategory_id'));
            }

            // Filter by in stock (in_stock=1/true → in stock only, in_stock=0/false → out of stock only)
            if ($request->has('in_stock')) {
                $request->boolean('in_stock') ? $query->inStock() : $query->outOfStock();
            }

            // Sorting (sort_by: created_at|price|rating|title|sold_count, sort_order: asc|desc; "newest" = created_at desc)
            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = strtolower($request->input('sort_order', 'desc')) === 'asc' ? 'asc' : 'desc';
            if ($sortBy === 'newest') {
                $sortBy = 'created_at';
                $sortOrder = 'desc';
            }
            $allowedSortFields = ['created_at', 'price', 'rating', 'title', 'sold_count'];
            if (in_array($sortBy, $allowedSortFields)) {
                if ($sortBy === 'price') {
                    $query->orderByRaw('COALESCE(discount_price, price) ' . $sortOrder);
                } else {
                    $query->orderBy($sortBy, $sortOrder);
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $perPage = min(max((int) $request->input('per_page', 15), 1), 50);
            $paginator = $query
                ->paginate($perPage)
                ->through(function ($meal) {
                    return [
                        'id' => $meal->id,
                        'title' => $meal->title,
                        'slug' => $meal->slug,
                        'description' => $meal->description,
                        'image_url' => $meal->image_url,
                        'offer_title' => $meal->offer_title,

// Pricing
                        ...$meal->getApiPriceAttributes(),
                        'has_offer' => $meal->hasOffer(),

                        // Rating & Details
                        'rating' => (float) $meal->rating,
                        'rating_count' => (int) $meal->rating_count,
                        'size' => $meal->size,
                        'brand' => $meal->brand,

                        // Stock & Availability
                        'stock_quantity' => $meal->stock_quantity,
                        'in_stock' => $meal->isInStock(),
                        'is_featured' => $meal->is_featured,

                        // Expiry
                        'expiry_date' => $meal->expiry_date,
                        'days_until_expiry' => $meal->daysUntilExpiry(),
                        'is_expired' => $meal->isExpired(),

                        // Features
                        'features' => $meal->features,

                        // Subcategory
                        'subcategory' => $meal->subcategory ? [
                            'id' => $meal->subcategory->id,
                            'name' => $meal->subcategory->name,
                            'slug' => $meal->subcategory->slug,
                        ] : null,
                    ];
                });

            $total = $paginator->total();
            return response()->json(array_merge([
                'success' => true,
                'message' => $total === 0 ? 'No products match your filters.' : 'Meals retrieved successfully',
                'data' => [
                    'category' => [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                    ],
                    'meals' => $paginator->items(),
                    'pagination' => [
                        'current_page' => $paginator->currentPage(),
                        'last_page' => $paginator->lastPage(),
                        'per_page' => $paginator->perPage(),
                        'total' => $total,
                        'from' => $paginator->firstItem(),
                        'to' => $paginator->lastItem(),
                    ],
                ],
            ], $total === 0 ? ['empty_message' => 'No products match the applied filters. Try adjusting your filters.'] : []));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve meals',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

```

## Source: CartController@addItem
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Meal;
use App\Services\ShippingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    /**
     * Get user's cart
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $cart = $user->getOrCreateCart();
            $cart->load(['items.meal.category', 'items.meal.subcategory']);
            $deliveryType = $request->query('delivery_type');
            if ($deliveryType && in_array($deliveryType, ['delivery', 'pickup'], true)) {
                $shippingService = app(ShippingService::class);
                $shippingFee = $shippingService->calculateShippingFee((float) $cart->subtotal, $deliveryType);
                $totalWithShipping = (float) $cart->total + $shippingFee;
            } else {
                $shippingFee = null;
                $totalWithShipping = null;
            }

            return response()->json([
                'success' => true,
                'message' => 'Cart retrieved successfully',
                'data' => $this->formatCart($cart, $shippingFee, $totalWithShipping),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add item to cart
     */
    public function addItem(Request $request): JsonResponse
    {
        try {
            $maxPerProduct = config('cart.max_quantity_per_product', 10);
            $validated = $request->validate([
                'meal_id' => ['required', 'exists:meals,id'],
                'quantity' => ['required', 'integer', 'min:1', 'max:' . $maxPerProduct],
            ], [
                'quantity.max' => "Maximum {$maxPerProduct} units per product allowed.",
            ]);

            $user = $request->user();
            $cart = $user->getOrCreateCart();
            $meal = Meal::findOrFail($validated['meal_id']);

            // Check if meal is available
            if (!$meal->is_available) {
                return response()->json([
                    'success' => false,
                    'message' => 'This meal is currently unavailable',
                ], 400);
            }

            // Check if meal is in stock
            if (!$meal->isInStock()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This meal is out of stock',
                ], 400);
            }

            // Check if meal has expired
            // if ($meal->isExpired()) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'This meal has expired',
            //     ], 400);
            // }

            // Check stock quantity
            if ($meal->stock_quantity < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$meal->stock_quantity} items available in stock",
                ], 400);
            }

            DB::beginTransaction();

            // Check if item already exists in cart
            $cartItem = $cart->items()->where('meal_id', $meal->id)->first();

            if ($cartItem) {
                // Update quantity (enforce max per product per user)
                $newQuantity = $cartItem->quantity + $validated['quantity'];
                $effectiveMax = min($maxPerProduct, $meal->stock_quantity);
                if ($newQuantity > $effectiveMax) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Maximum {$maxPerProduct} units per product. You already have {$cartItem->quantity} in cart; maximum total is {$effectiveMax}.",
                    ], 400);
                }
                if ($meal->stock_quantity < $newQuantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Only {$meal->stock_quantity} items available in stock",
                    ], 400);
                }

                $cartItem->update([
                    'quantity' => $newQuantity,
                ]);
            } else {
                // Create new cart item
                $discountAmount = 0;
                if ($meal->resolved_discount_price) {
                    $discountAmount = ($meal->price - $meal->resolved_discount_price) * $validated['quantity'];
                }

                $cartItem = $cart->items()->create([
                    'meal_id' => $meal->id,
                    'quantity' => $validated['quantity'],
                    'unit_price' => $meal->final_price,
                    'discount_amount' => $discountAmount,
                    'subtotal' => $meal->final_price * $validated['quantity'],
                ]);
            }

            $cart->calculateTotals();
            $cart->load(['items.meal.category', 'items.meal.subcategory']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'data' => $this->formatCart($cart),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to add item to cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateItem(Request $request, string $itemId): JsonResponse
    {
        try {
            $maxPerProduct = config('cart.max_quantity_per_product', 10);
            $validated = $request->validate([
                'quantity' => ['required', 'integer', 'min:1', 'max:' . $maxPerProduct],
            ], [
                'quantity.max' => "Maximum {$maxPerProduct} units per product allowed.",
            ]);

            $user = $request->user();
            $cart = $user->getOrCreateCart();
            
            $cartItem = $cart->items()->findOrFail($itemId);
            $meal = $cartItem->meal;

            // Check stock quantity
            if ($meal->stock_quantity < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$meal->stock_quantity} items available in stock",
                ], 400);
            }

            DB::beginTransaction();

            $cartItem->update([
                'quantity' => $validated['quantity'],
            ]);

            $cart->calculateTotals();
            $cart->load(['items.meal.category', 'items.meal.subcategory']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cart item updated successfully',
                'data' => $this->formatCart($cart),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function removeItem(Request $request, string $itemId): JsonResponse
    {
        try {
            $user = $request->user();
            $cart = $user->getOrCreateCart();
            
            $cartItem = $cart->items()->findOrFail($itemId);

            DB::beginTransaction();

            $cartItem->delete();

            $cart->calculateTotals();
            $cart->load(['items.meal.category', 'items.meal.subcategory']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully',
                'data' => $this->formatCart($cart),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clear cart
     */
    public function clear(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $cart = $user->getOrCreateCart();

            DB::beginTransaction();

            $cart->items()->delete();
            $cart->calculateTotals();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'data' => $this->formatCart($cart),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Format cart data for response.
     * When shipping fee and total_with_shipping are provided (e.g. from delivery_type query), they are included.
     */
    private function formatCart(Cart $cart, ?float $shippingFee = null, ?float $totalWithShipping = null): array
    {
        $data = [
            'id' => $cart->id,
            'status' => $cart->isEmpty() ? 'empty' : 'not empty',
            'items' => $cart->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'meal' => [
                        'id' => $item->meal->id,
                        'title' => $item->meal->title,
                        'slug' => $item->meal->slug,
                        'image_url' => $item->meal->image_url,
                        ...$item->meal->getApiPriceAttributes(),
                        'rating' => (float) $item->meal->rating,
                        'size' => $item->meal->size,
                        'brand' => $item->meal->brand,
                        'stock_quantity' => $item->meal->stock_quantity,
                        'is_available' => $item->meal->is_available,
                        'in_stock' => $item->meal->isInStock(),
                        'category' => $item->meal->category ? [
                            'id' => $item->meal->category->id,
                            'name' => $item->meal->category->name,
                        ] : null,
                        'subcategory' => $item->meal->subcategory ? [
                            'id' => $item->meal->subcategory->id,
                            'name' => $item->meal->subcategory->name,
                        ] : null,
                    ],
                    'quantity' => $item->quantity,
                    'unit_price' => (float) $item->unit_price,
                    'discount_amount' => (float) $item->discount_amount,
                    'subtotal' => (float) $item->subtotal,
                ];
            }),
            'item_count' => $cart->item_count,
            'subtotal' => (float) $cart->subtotal,
            'tax' => (float) $cart->tax,
            'discount' => (float) $cart->discount,
            'total' => (float) $cart->total,
            'is_empty' => $cart->isEmpty(),
            'created_at' => $cart->created_at,
            'updated_at' => $cart->updated_at,
        ];

        if ($shippingFee !== null && $totalWithShipping !== null) {
            $data['shipping_fee'] = (float) $shippingFee;
            $data['total_with_shipping'] = (float) $totalWithShipping;
        }

        return $data;
    }
}

```

## Source: ChatbotController@chat
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatbotMessage;
use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class ChatbotController extends Controller
{
    public function __construct(private readonly ChatbotService $chatbotService) {}

    /**
     * Send a message to the AI assistant.
     *
     * Supports an optional `session_id` (UUID) to maintain conversation history across requests.
     */
    public function chat(Request $request): JsonResponse
    {
        try {
            foreach (['question', 'message'] as $key) {
                if ($request->hasFile($key)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Send the question as plain text, not as a file upload.',
                        'errors' => ['question' => ['The question must be a text value, not a file.']],
                    ], 422);
                }
            }

            if ($request->filled('message') && ! $request->filled('question')) {
                $request->merge(['question' => $request->input('message')]);
            }

            if (is_array($request->input('question'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Send a single question text only.',
                    'errors' => ['question' => ['Multiple question values are not allowed.']],
                ], 422);
            }

            $validated = $request->validate([
                'question' => ['required', 'string', 'max:1000'],
                'conversation_id' => ['nullable', 'uuid'],
                'session_id' => ['nullable', 'uuid'],       // kept for backwards compatibility
                'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
                'locale' => ['nullable', 'string', 'in:ar,en'],
            ]);

            $question = trim((string) $validated['question']);

            if ($question === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => ['question' => ['A non-empty question is required.']],
                ], 422);
            }

            $user = $request->user();
            if ($user === null) {
                return response()->json(['success' => false, 'message' => 'Authentication required'], 401);
            }

            $conversationId = $validated['conversation_id'] ?? $validated['session_id'] ?? null;

            $result = $this->chatbotService->chat(
                user: $user,
                question: $question,
                conversationId: $conversationId,
                locale: $validated['locale'] ?? null,
            );

            if (isset($validated['rating'])) {
                ChatbotMessage::where('id', $result['id'])->update(['rating' => $validated['rating']]);
                $result['rating'] = $validated['rating'];
            }

            return response()->json([
                'success' => true,
                'message' => 'Chat response generated successfully',
                'data' => [
                    'id' => $result['id'],
                    'conversation_id' => $result['conversation_id'],
                    'session_id' => $result['conversation_id'],  // backwards compatibility
                    'question' => $result['question'],
                    'answer' => $result['answer'],
                    'rating' => $result['rating'],
                ],
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Throwable $e) {
            Log::error('Chatbot Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process chat request',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Get current user's chatbot conversation history (paginated).
     */
    public function history(Request $request): JsonResponse
    {
        try {
            $perPage = min(max((int) $request->input('per_page', 15), 1), 50);
            $messages = $request->user()
                ->chatbotMessages()
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            $items = $messages->getCollection()->map(fn (ChatbotMessage $m) => [
                'id' => $m->id,
                'session_id' => $m->session_id,
                'question' => $m->question,
                'answer' => $m->answer,
                'rating' => $m->rating,
                'created_at' => $m->created_at,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Chat history retrieved successfully',
                'data' => [
                    'items' => $items,
                    'pagination' => [
                        'current_page' => $messages->currentPage(),
                        'last_page' => $messages->lastPage(),
                        'per_page' => $messages->perPage(),
                        'total' => $messages->total(),
                        'from' => $messages->firstItem(),
                        'to' => $messages->lastItem(),
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Chatbot history error', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve chat history',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Get suggested quick-reply questions (localised).
     */
    public function suggestions(Request $request): JsonResponse
    {
        $locale = $request->input('locale', 'en');
        $isAr = $locale === 'ar';

        $suggestions = $isAr
            ? [
                ['id' => 'faq',      'label' => 'أسئلة شائعة',        'question' => 'ما هي الأسئلة الشائعة؟'],
                ['id' => 'orders',   'label' => 'تتبع الطلب',          'question' => 'كيف أتتبع طلبي؟'],
                ['id' => 'payment',  'label' => 'طرق الدفع',           'question' => 'ما طرق الدفع المتاحة؟'],
                ['id' => 'products', 'label' => 'المنتجات والمفضلة',   'question' => 'ما المنتجات المتاحة والعروض؟'],
                ['id' => 'offers',   'label' => 'كوبونات وعروض',       'question' => 'ما العروض وكوبونات الخصم الحالية؟'],
            ]
            : [
                ['id' => 'faq',      'label' => 'FAQs',              'question' => 'What are the frequently asked questions?'],
                ['id' => 'orders',   'label' => 'Track order',        'question' => 'How do I track my order?'],
                ['id' => 'payment',  'label' => 'Payment methods',    'question' => 'What payment methods do you accept?'],
                ['id' => 'products', 'label' => 'Products & offers',  'question' => 'What products and offers do you have?'],
                ['id' => 'offers',   'label' => 'Coupons & offers',   'question' => 'What promo codes or offers are available?'],
            ];

        return response()->json([
            'success' => true,
            'message' => 'Suggestions retrieved successfully',
            'data' => ['suggestions' => $suggestions],
        ]);
    }
}

```

## Source: SubcategoryController@meals
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Get all subcategories
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Subcategory::with('category')->active();

            // Filter by category if provided
            if ($request->has('category_id')) {
                $query->where('category_id', $request->input('category_id'));
            }

            $subcategories = $query->inRandomOrder()
                ->get()
                ->map(function ($subcategory) {
                    return [
                        'id' => $subcategory->id,
                        'name' => $subcategory->name,
                        'slug' => $subcategory->slug,
                        'description' => $subcategory->description,
                        'image_url' => $subcategory->image_url,
                        'order' => $subcategory->order,
                        'category' => [
                            'id' => $subcategory->category->id,
                            'name' => $subcategory->category->name,
                            'slug' => $subcategory->category->slug,
                        ],
                        'meals_count' => $subcategory->meals()->available()->count(),
                        'created_at' => $subcategory->created_at,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Subcategories retrieved successfully',
                'data' => $subcategories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve subcategories',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get single subcategory
     */
    public function show(string $id): JsonResponse
    {
        try {
            $subcategory = Subcategory::with(['category', 'meals' => function ($query) {
                $query->available()->limit(10);
            }])->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Subcategory retrieved successfully',
                'data' => [
                    'id' => $subcategory->id,
                    'name' => $subcategory->name,
                    'slug' => $subcategory->slug,
                    'description' => $subcategory->description,
                    'image_url' => $subcategory->image_url,
                    'order' => $subcategory->order,
                    'is_active' => $subcategory->is_active,
                    'category' => [
                        'id' => $subcategory->category->id,
                        'name' => $subcategory->category->name,
                        'slug' => $subcategory->category->slug,
                    ],
                    'meals' => $subcategory->meals->map(function ($meal) {
                        return [
                            'id' => $meal->id,
                            'title' => $meal->title,
                            'slug' => $meal->slug,
                            'image_url' => $meal->image_url,
                            ...$meal->getApiPriceAttributes(),
                            'rating' => (float) $meal->rating,
                            'is_featured' => $meal->is_featured,
                            'features' => $meal->features,
                        ];
                    }),
                    'meals_count' => $subcategory->meals()->available()->count(),
                    'created_at' => $subcategory->created_at,
                    'updated_at' => $subcategory->updated_at,
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Subcategory not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve subcategory',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get meals by subcategory (paginated)
     */
    public function meals(string $id, Request $request): JsonResponse
    {
        try {
            $subcategory = Subcategory::findOrFail($id);

            $query = $subcategory->meals()->with('category')->available();

            // Filter by featured if provided (featured=1/true → featured only, featured=0/false → non-featured only)
            if ($request->has('featured')) {
                $request->boolean('featured') ? $query->featured() : $query->where('is_featured', false);
            }

            // Filter by in stock (in_stock=1/true → in stock only, in_stock=0/false → out of stock only)
            if ($request->has('in_stock')) {
                $request->boolean('in_stock') ? $query->inStock() : $query->outOfStock();
            }

            // Sorting (sort_by: created_at|price|rating|title|sold_count|newest, sort_order: asc|desc)
            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = strtolower($request->input('sort_order', 'desc')) === 'asc' ? 'asc' : 'desc';
            if ($sortBy === 'newest') {
                $sortBy = 'created_at';
                $sortOrder = 'desc';
            }
            $allowedSortFields = ['created_at', 'price', 'rating', 'title', 'sold_count'];
            if (in_array($sortBy, $allowedSortFields)) {
                if ($sortBy === 'price') {
                    $query->orderByRaw('COALESCE(discount_price, price) ' . $sortOrder);
                } else {
                    $query->orderBy($sortBy, $sortOrder);
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $perPage = min(max((int) $request->input('per_page', 15), 1), 50);
            $paginator = $query
                ->paginate($perPage)
                ->withQueryString();

            $meals = $paginator->getCollection()->map(function ($meal) {
                return [
                    'id' => $meal->id,
                    'title' => $meal->title,
                    'slug' => $meal->slug,
                    'description' => $meal->description,
                    'image_url' => $meal->image_url,
                    'offer_title' => $meal->offer_title,
                    ...$meal->getApiPriceAttributes(),
                    'rating' => (float) $meal->rating,
                    'rating_count' => (int) $meal->rating_count,
                    'has_offer' => $meal->hasOffer(),
                    'is_featured' => $meal->is_featured,
                    'in_stock' => $meal->isInStock(),
                    'features' => $meal->features,
                ];
            });

            $total = $paginator->total();
            return response()->json(array_merge([
                'success' => true,
                'message' => $total === 0 ? 'No products match your filters.' : 'Meals retrieved successfully',
                'data' => [
                    'subcategory' => [
                        'id' => $subcategory->id,
                        'name' => $subcategory->name,
                        'slug' => $subcategory->slug,
                    ],
                    'meals' => $meals->values()->all(),
                    'pagination' => [
                        'current_page' => $paginator->currentPage(),
                        'last_page' => $paginator->lastPage(),
                        'per_page' => $paginator->perPage(),
                        'total' => $total,
                        'from' => $paginator->firstItem(),
                        'to' => $paginator->lastItem(),
                    ],
                ],
            ], $total === 0 ? ['empty_message' => 'No products match the applied filters. Try adjusting your filters.'] : []));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Subcategory not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve meals',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

```

## Source: GoogleAuthController@login
```php
<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Google\Client as GoogleClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class GoogleAuthController extends Controller
{
    private const INVALID_GOOGLE_TOKEN_MESSAGE = 'Invalid Google token.';
    private const ALLOWED_GOOGLE_ISSUERS = [
        'accounts.google.com',
        'https://accounts.google.com',
    ];

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'id_token' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $allowedClientIds = $this->allowedGoogleClientIds();
        if (empty($allowedClientIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Google sign-in is not configured.',
            ], 503);
        }

        try {
            // Do not pin verification to one client_id so web/mobile tokens can all pass signature checks.
            // We enforce allowed audiences manually in isValidGooglePayload().
            $client = new GoogleClient;
            $payload = $client->verifyIdToken($request->input('id_token'));
        } catch (Throwable $e) {
            Log::warning('Google ID token verification failed', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => self::INVALID_GOOGLE_TOKEN_MESSAGE,
            ], 401);
        }

        if (! is_array($payload) || ! $this->isValidGooglePayload($payload, $allowedClientIds)) {
            return response()->json([
                'success' => false,
                'message' => self::INVALID_GOOGLE_TOKEN_MESSAGE,
            ], 401);
        }

        try {
            $email = strtolower((string) $payload['email']);

            $user = User::where('email', $email)->first();

            if ($user) {
                if (! $user->is_active) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your account has been deactivated.',
                    ], 403);
                }

                $user->fill([
                    'google_id' => $payload['sub'] ?? $user->google_id,
                    'avatar' => $payload['picture'] ?? $user->avatar,
                ]);

                if (! $user->email_verified) {
                    $user->email_verified = true;
                    $user->email_verified_at = now();
                }

                $user->save();
            } else {
                $user = User::create([
                    'username' => $this->uniqueUsernameForGoogle($payload, $email),
                    'email' => $email,
                    'google_id' => $payload['sub'] ?? null,
                    'avatar' => $payload['picture'] ?? null,
                    'password' => Str::random(32),
                    'agree_terms' => true,
                    'email_verified' => true,
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]);
            }

            $deviceName = trim((string) $request->input('device_name', 'google_auth'));
            $token = $user->createToken($deviceName !== '' ? $deviceName : 'google_auth')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'phone' => $user->phone,
                    ],
                    'token' => $token,
                ],
            ]);
        } catch (Throwable $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'Wrong number of segments')
                || str_contains($msg, 'JWT')
                || str_contains($msg, 'jwt')) {
                return response()->json([
                    'success' => false,
                    'message' => self::INVALID_GOOGLE_TOKEN_MESSAGE,
                ], 401);
            }

            Log::error('Google login failed', [
                'message' => $msg,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Google sign-in failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Non-empty, unique username for new Google users (slug can be empty for non-Latin names).
     */
    private function uniqueUsernameForGoogle(array $payload, string $email): string
    {
        $fromName = Str::slug((string) ($payload['name'] ?? ''));
        $fromEmail = Str::slug(Str::before($email, '@'));
        $base = 'user';
        if ($fromName !== '') {
            $base = $fromName;
        } elseif ($fromEmail !== '') {
            $base = $fromEmail;
        }
        $base = Str::limit($base, User::USERNAME_MAX_LENGTH - 4, '');
        if ($base === '') {
            $base = 'user';
        }

        $candidate = Str::limit($base, User::USERNAME_MAX_LENGTH, '');
        if (! preg_match('/\p{L}/u', $candidate)) {
            $candidate = Str::limit('user_'.$candidate, User::USERNAME_MAX_LENGTH, '');
        }
        $n = 0;
        while (User::withTrashed()->where('username', $candidate)->exists()) {
            $n++;
            $suffix = (string) $n;
            $candidate = Str::limit($base, User::USERNAME_MAX_LENGTH - strlen($suffix), '').$suffix;
        }

        return Str::limit($candidate, User::USERNAME_MAX_LENGTH, '');
    }

    /**
     * Accepts old config key (client_id) and new key (client_ids array).
     *
     * @return array<int, string>
     */
    private function allowedGoogleClientIds(): array
    {
        $clientIds = config('services.google.client_ids', []);
        if (! is_array($clientIds)) {
            $clientIds = [];
        }

        $legacyClientId = config('services.google.client_id');
        if (is_string($legacyClientId) && trim($legacyClientId) !== '') {
            $clientIds[] = $legacyClientId;
        }

        return array_values(array_unique(array_filter(array_map(
            static fn ($id) => is_string($id) ? trim($id) : '',
            $clientIds
        ))));
    }

    /**
     * @param  array<string, mixed>  $payload
     * @param  array<int, string>  $allowedClientIds
     */
    private function isValidGooglePayload(array $payload, array $allowedClientIds): bool
    {
        $audience = (string) ($payload['aud'] ?? '');
        $issuer = (string) ($payload['iss'] ?? '');
        $email = (string) ($payload['email'] ?? '');
        $emailVerified = filter_var($payload['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $subject = (string) ($payload['sub'] ?? '');
        $expiry = (int) ($payload['exp'] ?? 0);

        return $audience !== ''
            && in_array($audience, $allowedClientIds, true)
            && in_array($issuer, self::ALLOWED_GOOGLE_ISSUERS, true)
            && $email !== ''
            && $emailVerified
            && $subject !== ''
            && $expiry > now()->timestamp;
    }
}

```

## Source: Client@__construct
```php
<?php
/*
 * Copyright 2010 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google;

use BadMethodCallException;
use DomainException;
use Google\AccessToken\Revoke;
use Google\AccessToken\Verify;
use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\Cache\MemoryCacheItemPool;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\Credentials\UserRefreshCredentials;
use Google\Auth\CredentialsLoader;
use Google\Auth\FetchAuthTokenCache;
use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\GetUniverseDomainInterface;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Auth\OAuth2;
use Google\AuthHandler\AuthHandlerFactory;
use Google\Http\REST;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Ring\Client\StreamHandler;
use InvalidArgumentException;
use LogicException;
use Monolog\Handler\StreamHandler as MonologStreamHandler;
use Monolog\Handler\SyslogHandler as MonologSyslogHandler;
use Monolog\Logger;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

/**
 * The Google API Client
 * https://github.com/google/google-api-php-client
 */
class Client
{
    // Release Please updates the VERSION constant. This workaround ensures the LIBVER constant
    // will be updated for each release as well.
    private const VERSION = '2.19.1';
    const LIBVER = self::VERSION;

    const USER_AGENT_SUFFIX = "google-api-php-client/";
    const OAUTH2_REVOKE_URI = 'https://oauth2.googleapis.com/revoke';
    const OAUTH2_TOKEN_URI = 'https://oauth2.googleapis.com/token';
    const OAUTH2_AUTH_URL = 'https://accounts.google.com/o/oauth2/v2/auth';
    const API_BASE_PATH = 'https://www.googleapis.com';

    /**
     * @var ?OAuth2 $auth
     */
    private $auth;

    /**
     * @var ClientInterface $http
     */
    private $http;

    /**
     * @var ?CacheItemPoolInterface $cache
     */
    private $cache;

    /**
     * @var array access token
     */
    private $token;

    /**
     * @var array $config
     */
    private $config;

    /**
     * @var ?LoggerInterface $logger
     */
    private $logger;

    /**
     * @var ?FetchAuthTokenInterface $credentials
     */
    private $credentials;

    /**
     * @var boolean $deferExecution
     */
    private $deferExecution = false;

    /** @var array $scopes */
    // Scopes requested by the client
    protected $requestedScopes = [];

    /**
     * Construct the Google Client.
     *
     * @param array $config {
     *     An array of required and optional arguments.
     *
     *     @type string $application_name
     *           The name of your application
     *     @type string $base_path
     *           The base URL for the service. This is only accounted for when calling
     *           {@see Client::authorize()} directly.
     *     @type string $client_id
     *           Your Google Cloud client ID found in https://developers.google.com/console
     *     @type string $client_secret
     *           Your Google Cloud client secret found in https://developers.google.com/console
     *     @type string|array|FetchAuthTokenInterface $credentials
     *           Can be a path to JSON credentials or an array representing those
     *           credentials (@see Google\Client::setAuthConfig), or an instance of
     *           {@see FetchAuthTokenInterface}.
     *     @type string|array $scopes
     *           {@see Google\Client::setScopes}
     *     @type string $quota_project
     *           Sets X-Goog-User-Project, which specifies a user project to bill
     *           for access charges associated with the request.
     *     @type string $redirect_uri
     *     @type string $state
     *     @type string $developer_key
     *           Simple API access key, also from the API console. Ensure you get
     *           a Server key, and not a Browser key.
     *           **NOTE:** The universe domain is assumed to be "googleapis.com" unless
     *           explicitly set. When setting an API ley directly via this option, there
     *           is no way to verify the universe domain. Be sure to set the
     *           "universe_domain" option if "googleapis.com" is not intended.
     *     @type bool $use_application_default_credentials
     *           For use with Google Cloud Platform
     *           fetch the ApplicationDefaultCredentials, if applicable
     *           {@see https://developers.google.com/identity/protocols/application-default-credentials}
     *     @type string $signing_key
     *     @type string $signing_algorithm
     *     @type string $subject
     *     @type string $hd
     *     @type string $prompt
     *     @type string $openid
     *     @type bool $include_granted_scopes
     *     @type string $login_hint
     *     @type string $request_visible_actions
     *     @type string $access_type
     *     @type string $approval_prompt
     *     @type array $retry
     *           Task Runner retry configuration
     *           {@see \Google\Task\Runner}
     *     @type array $retry_map
     *     @type CacheItemPoolInterface $cache
     *           Cache class implementing {@see CacheItemPoolInterface}. Defaults
     *           to {@see MemoryCacheItemPool}.
     *     @type array $cache_config
     *           Cache config for downstream auth caching.
     *     @type callable $token_callback
     *           Function to be called when an access token is fetched. Follows
     *           the signature `function (string $cacheKey, string $accessToken)`.
     *     @type \Firebase\JWT $jwt
     *           Service class used in {@see Client::verifyIdToken()}. Explicitly
     *           pass this in to avoid setting {@see \Firebase\JWT::$leeway}
     *     @type bool $api_format_v2
     *           Setting api_format_v2 will return more detailed error messages
     *           from certain APIs.
     *     @type string $universe_domain
     *           Setting the universe domain will change the default rootUrl of the service.
     *           If not set explicitly, the universe domain will be the value provided in the
     *.          "GOOGLE_CLOUD_UNIVERSE_DOMAIN" environment variable, or "googleapis.com".
     *  }
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge([
            'application_name' => '',
            'base_path' => self::API_BASE_PATH,
            'client_id' => '',
            'client_secret' => '',
            'credentials' => null,
            'scopes' => null,
            'quota_project' => null,
            'redirect_uri' => null,
            'state' => null,
            'developer_key' => '',
            'use_application_default_credentials' => false,
            'signing_key' => null,
            'signing_algorithm' => null,
            'subject' => null,
            'hd' => '',
            'prompt' => '',
            'openid.realm' => '',
            'include_granted_scopes' => null,
            'logger' => null,
            'login_hint' => '',
            'request_visible_actions' => '',
            'access_type' => 'online',
            'approval_prompt' => 'auto',
            'retry' => [],
            'retry_map' => null,
            'cache' => null,
            'cache_config' => [],
            'token_callback' => null,
            'jwt' => null,
            'api_format_v2' => false,
            'universe_domain' => getenv('GOOGLE_CLOUD_UNIVERSE_DOMAIN')
                ?: GetUniverseDomainInterface::DEFAULT_UNIVERSE_DOMAIN,
        ], $config);

        if (!is_null($this->config['credentials'])) {
            if ($this->config['credentials'] instanceof FetchAuthTokenInterface) {
                $this->credentials = $this->config['credentials'];
            } else {
                $this->setAuthConfig($this->config['credentials']);
            }
            unset($this->config['credentials']);
        }

        if (!is_null($this->config['scopes'])) {
            $this->setScopes($this->config['scopes']);
            unset($this->config['scopes']);
        }

        // Set a default token callback to update the in-memory access token
        if (is_null($this->config['token_callback'])) {
            $this->config['token_callback'] = function ($cacheKey, $newAccessToken) {
                $this->setAccessToken(
                    [
                    'access_token' => $newAccessToken,
                    'expires_in' => 3600, // Google default
                    'created' => time(),
                    ]
                );
            };
        }

        if (!is_null($this->config['cache'])) {
            $this->setCache($this->config['cache']);
            unset($this->config['cache']);
        }

        if (!is_null($this->config['logger'])) {
            $this->setLogger($this->config['logger']);
            unset($this->config['logger']);
        }
    }

    /**
     * Get a string containing the version of the library.
     *
     * @return string
     */
    public function getLibraryVersion()
    {
        return self::LIBVER;
    }

    /**
     * For backwards compatibility
     * alias for fetchAccessTokenWithAuthCode
     *
     * @param string $code string code from accounts.google.com
     * @return array access token
     * @deprecated
     */
    public function authenticate($code)
    {
        return $this->fetchAccessTokenWithAuthCode($code);
    }

    /**
     * Attempt to exchange a code for an valid authentication token.
     * Helper wrapped around the OAuth 2.0 implementation.
     *
     * @param string $code code from accounts.google.com
     * @param string $codeVerifier the code verifier used for PKCE (if applicable)
     * @return array access token
     */
    public function fetchAccessTokenWithAuthCode($code, $codeVerifier = null)
    {
        if (strlen($code) == 0) {
            throw new InvalidArgumentException("Invalid code");
        }

        $auth = $this->getOAuth2Service();
        $auth->setCode($code);
        $auth->setRedirectUri($this->getRedirectUri());
        if ($codeVerifier) {
            $auth->setCodeVerifier($codeVerifier);
        }

        $httpHandler = HttpHandlerFactory::build($this->getHttpClient());
        $creds = $auth->fetchAuthToken($httpHandler);
        if ($creds && isset($creds['access_token'])) {
            $creds['created'] = time();
            $this->setAccessToken($creds);
        }

        return $creds;
    }

    /**
     * For backwards compatibility
     * alias for fetchAccessTokenWithAssertion
     *
     * @return array access token
     * @deprecated
     */
    public function refreshTokenWithAssertion()
    {
        return $this->fetchAccessTokenWithAssertion();
    }

    /**
     * Fetches a fresh access token with a given assertion token.
     * @param ClientInterface $authHttp optional.
     * @return array access token
     */
    public function fetchAccessTokenWithAssertion(?ClientInterface $authHttp = null)
    {
        if (!$this->isUsingApplicationDefaultCredentials()) {
            throw new DomainException(
                'set the JSON service account credentials using'
                . ' Google\Client::setAuthConfig or set the path to your JSON file'
                . ' with the "GOOGLE_APPLICATION_CREDENTIALS" environment variable'
                . ' and call Google\Client::useApplicationDefaultCredentials to'
                . ' refresh a token with assertion.'
            );
        }

        $this->getLogger()->log(
            'info',
            'OAuth2 access token refresh with Signed JWT assertion grants.'
        );

        $credentials = $this->createApplicationDefaultCredentials();

        $httpHandler = HttpHandlerFactory::build($authHttp);
        $creds = $credentials->fetchAuthToken($httpHandler);
        if ($creds && isset($creds['access_token'])) {
            $creds['created'] = time();
            $this->setAccessToken($creds);
        }

        return $creds;
    }

    /**
     * For backwards compatibility
     * alias for fetchAccessTokenWithRefreshToken
     *
     * @param string $refreshToken
     * @return array access token
     */
    public function refreshToken($refreshToken)
    {
        return $this->fetchAccessTokenWithRefreshToken($refreshToken);
    }

    /**
     * Fetches a fresh OAuth 2.0 access token with the given refresh token.
     * @param string $refreshToken
     * @return array access token
     */
    public function fetchAccessTokenWithRefreshToken($refreshToken = null)
    {
        if (null === $refreshToken) {
            if (!isset($this->token['refresh_token'])) {
                throw new LogicException(
                    'refresh token must be passed in or set as part of setAccessToken'
                );
            }
            $refreshToken = $this->token['refresh_token'];
        }
        $this->getLogger()->info('OAuth2 access token refresh');
        $auth = $this->getOAuth2Service();
        $auth->setRefreshToken($refreshToken);

        $httpHandler = HttpHandlerFactory::build($this->getHttpClient());
        $creds = $auth->fetchAuthToken($httpHandler);
        if ($creds && isset($creds['access_token'])) {
            $creds['created'] = time();
            if (!isset($creds['refresh_token'])) {
                $creds['refresh_token'] = $refreshToken;
            }
            $this->setAccessToken($creds);
        }

        return $creds;
    }

    /**
     * Create a URL to obtain user authorization.
     * The authorization endpoint allows the user to first
     * authenticate, and then grant/deny the access request.
     * @param string|array $scope The scope is expressed as an array or list of space-delimited strings.
     * @param array $queryParams Querystring params to add to the authorization URL.
     * @return string
     */
    public function createAuthUrl($scope = null, array $queryParams = [])
    {
        if (empty($scope)) {
            $scope = $this->prepareScopes();
        }
        if (is_array($scope)) {
            $scope = implode(' ', $scope);
        }

        // only accept one of prompt or approval_prompt
        $approvalPrompt = $this->config['prompt']
            ? null
            : $this->config['approval_prompt'];

        // include_granted_scopes should be string "true", string "false", or null
        $includeGrantedScopes = $this->config['include_granted_scopes'] === null
            ? null
            : var_export($this->config['include_granted_scopes'], true);

        $params = array_filter([
            'access_type' => $this->config['access_type'],
            'approval_prompt' => $approvalPrompt,
            'hd' => $this->config['hd'],
            'include_granted_scopes' => $includeGrantedScopes,
            'login_hint' => $this->config['login_hint'],
            'openid.realm' => $this->config['openid.realm'],
            'prompt' => $this->config['prompt'],
            'redirect_uri' => $this->config['redirect_uri'],
            'response_type' => 'code',
            'scope' => $scope,
            'state' => $this->config['state'],
        ]) + $queryParams;

        // If the list of scopes contains plus.login, add request_visible_actions
        // to auth URL.
        $rva = $this->config['request_visible_actions'];
        if (strlen($rva) > 0 && false !== strpos($scope, 'plus.login')) {
            $params['request_visible_actions'] = $rva;
        }

        $auth = $this->getOAuth2Service();

        return (string) $auth->buildFullAuthorizationUri($params);
    }

    /**
     * Adds auth listeners to the HTTP client based on the credentials
     * set in the Google API Client object
     *
     * @param ClientInterface $http the http client object.
     * @return ClientInterface the http client object
     */
    public function authorize(?ClientInterface $http = null)
    {
        $http = $http ?: $this->getHttpClient();
        $authHandler = $this->getAuthHandler();

        // These conditionals represent the decision tree for authentication
        //   1.  Check if an instance of Google\Auth\FetchAuthTokenInterface has
        //       been supplied via the "credentials" option
        //   2.  Check for Application Default Credentials
        //   3a. Check for an Access Token
        //   3b. If access token exists but is expired, try to refresh it
        //   4.  Check for API Key
        if ($this->credentials) {
            $this->checkUniverseDomain($this->credentials);
            return $authHandler->attachCredentials(
                $http,
                $this->credentials,
                $this->config['token_callback']
            );
        }

        if ($this->isUsingApplicationDefaultCredentials()) {
            $credentials = $this->createApplicationDefaultCredentials();
            $this->checkUniverseDomain($credentials);
            return $authHandler->attachCredentialsCache(
                $http,
                $credentials,
                $this->config['token_callback']
            );
        }

        if ($token = $this->getAccessToken()) {
            $scopes = $this->prepareScopes();
            // add refresh subscriber to request a new token
            if (isset($token['refresh_token']) && $this->isAccessTokenExpired()) {
                $credentials = $this->createUserRefreshCredentials(
                    $scopes,
                    $token['refresh_token']
                );
                $this->checkUniverseDomain($credentials);
                return $authHandler->attachCredentials(
                    $http,
                    $credentials,
                    $this->config['token_callback']
                );
            }

            return $authHandler->attachToken($http, $token, (array) $scopes);
        }

        if ($key = $this->config['developer_key']) {
            return $authHandler->attachKey($http, $key);
        }

        return $http;
    }

    /**
     * Set the configuration to use application default credentials for
     * authentication
     *
     * @see https://developers.google.com/identity/protocols/application-default-credentials
     * @param boolean $useAppCreds
     */
    public function useApplicationDefaultCredentials($useAppCreds = true)
    {
        $this->config['use_application_default_credentials'] = $useAppCreds;
    }

    /**
     * To prevent useApplicationDefaultCredentials from inappropriately being
     * called in a conditional
     *
     * @see https://developers.google.com/identity/protocols/application-default-credentials
     */
    public function isUsingApplicationDefaultCredentials()
    {
        return $this->config['use_application_default_credentials'];
    }

    /**
     * Set the access token used for requests.
     *
     * Note that at the time requests are sent, tokens are cached. A token will be
     * cached for each combination of service and authentication scopes. If a
     * cache pool is not provided, creating a new instance of the client will
     * allow modification of access tokens. If a persistent cache pool is
     * provided, in order to change the access token, you must clear the cached
     * token by calling `$client->getCache()->clear()`. (Use caution in this case,
     * as calling `clear()` will remove all cache items, including any items not
     * related to Google API PHP Client.)
     *
     * **NOTE:** The universe domain is assumed to be "googleapis.com" unless
     * explicitly set. When setting an access token directly via this method, there
     * is no way to verify the universe domain. Be sure to set the "universe_domain"
     * option if "googleapis.com" is not intended.
     *
     * @param string|array $token
     * @throws InvalidArgumentException
     */
    public function setAccessToken($token)
    {
        if (is_string($token)) {
            if ($json = json_decode($token, true)) {
                $token = $json;
            } else {
                // assume $token is just the token string
                $token = [
                    'access_token' => $token,
                ];
            }
        }
        if ($token == null) {
            throw new InvalidArgumentException('invalid json token');
        }
        if (!isset($token['access_token'])) {
            throw new InvalidArgumentException("Invalid token format");
        }
        $this->token = $token;
    }

    public function getAccessToken()
    {
        return $this->token;
    }

    /**
     * @return string|null
     */
    public function getRefreshToken()
    {
        if (isset($this->token['refresh_token'])) {
            return $this->token['refresh_token'];
        }

        return null;
    }

    /**
     * Returns if the access_token is expired.
     * @return bool Returns True if the access_token is expired.
     */
    public function isAccessTokenExpired()
    {
        if (!$this->token) {
            return true;
        }

        $created = 0;
        if (isset($this->token['created'])) {
            $created = $this->token['created'];
        } elseif (isset($this->token['id_token'])) {
            // check the ID token for "iat"
            // signature verification is not required here, as we are just
            // using this for convenience to save a round trip request
            // to the Google API server
            $idToken = $this->token['id_token'];
            if (substr_count($idToken, '.') == 2) {
                $parts = explode('.', $idToken);
                $payload = json_decode(base64_decode($parts[1]), true);
                if ($payload && isset($payload['iat'])) {
                    $created = $payload['iat'];
                }
            }
        }
        if (!isset($this->token['expires_in'])) {
            // if the token does not have an "expires_in", then it's considered expired
            return true;
        }

        // If the token is set to expire in the next 30 seconds.
        return ($created + ($this->token['expires_in'] - 30)) < time();
    }

    /**
     * @deprecated See UPGRADING.md for more information
     */
    public function getAuth()
    {
        throw new BadMethodCallException(
            'This function no longer exists. See UPGRADING.md for more information'
        );
    }

    /**
     * @deprecated See UPGRADING.md for more information
     */
    public function setAuth($auth)
    {
        throw new BadMethodCallException(
            'This function no longer exists. See UPGRADING.md for more information'
        );
    }

    /**
     * Set the OAuth 2.0 Client ID.
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->config['client_id'] = $clientId;
    }

    public function getClientId()
    {
        return $this->config['client_id'];
    }

    /**
     * Set the OAuth 2.0 Client Secret.
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->config['client_secret'] = $clientSecret;
    }

    public function getClientSecret()
    {
        return $this->config['client_secret'];
    }

    /**
     * Set the OAuth 2.0 Redirect URI.
     * @param string $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->config['redirect_uri'] = $redirectUri;
    }

    public function getRedirectUri()
    {
        return $this->config['redirect_uri'];
    }

    /**
     * Set OAuth 2.0 "state" parameter to achieve per-request customization.
     * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-22#section-3.1.2.2
     * @param string $state
     */
    public function setState($state)
    {
        $this->config['state'] = $state;
    }

    /**
     * @param string $accessType Possible values for access_type include:
     *  {@code "offline"} to request offline access from the user.
     *  {@code "online"} to request online access from the user.
     */
    public function setAccessType($accessType)
    {
        $this->config['access_type'] = $accessType;
    }

    /**
     * @param string $approvalPrompt Possible values for approval_prompt include:
     *  {@code "force"} to force the approval UI to appear.
     *  {@code "auto"} to request auto-approval when possible. (This is the default value)
     */
    public function setApprovalPrompt($approvalPrompt)
    {
        $this->config['approval_prompt'] = $approvalPrompt;
    }

    /**
     * Set the login hint, email address or sub id.
     * @param string $loginHint
     */
    public function setLoginHint($loginHint)
    {
        $this->config['login_hint'] = $loginHint;
    }

    /**
     * Set the application name, this is included in the User-Agent HTTP header.
     * @param string $applicationName
     */
    public function setApplicationName($applicationName)
    {
        $this->config['application_name'] = $applicationName;
    }

    /**
     * If 'plus.login' is included in the list of requested scopes, you can use
     * this method to define types of app activities that your app will write.
     * You can find a list of available types here:
     * @link https://developers.google.com/+/api/moment-types
     *
     * @param array $requestVisibleActions Array of app activity types
     */
    public function setRequestVisibleActions($requestVisibleActions)
    {
        if (is_array($requestVisibleActions)) {
            $requestVisibleActions = implode(" ", $requestVisibleActions);
        }
        $this->config['request_visible_actions'] = $requestVisibleActions;
    }

    /**
     * Set the developer key to use, these are obtained through the API Console.
     * @see http://code.google.com/apis/console-help/#generatingdevkeys
     * @param string $developerKey
     */
    public function setDeveloperKey($developerKey)
    {
        $this->config['developer_key'] = $developerKey;
    }

    /**
     * Set the hd (hosted domain) parameter streamlines the login process for
     * Google Apps hosted accounts. By including the domain of the user, you
     * restrict sign-in to accounts at that domain.
     * @param string $hd the domain to use.
     */
    public function setHostedDomain($hd)
    {
        $this->config['hd'] = $hd;
    }

    /**
     * Set the prompt hint. Valid values are none, consent and select_account.
     * If no value is specified and the user has not previously authorized
     * access, then the user is shown a consent screen.
     * @param string $prompt
     *  {@code "none"} Do not display any authentication or consent screens. Must not be specified with other values.
     *  {@code "consent"} Prompt the user for consent.
     *  {@code "select_account"} Prompt the user to select an account.
     */
    public function setPrompt($prompt)
    {
        $this->config['prompt'] = $prompt;
    }

    /**
     * openid.realm is a parameter from the OpenID 2.0 protocol, not from OAuth
     * 2.0. It is used in OpenID 2.0 requests to signify the URL-space for which
     * an authentication request is valid.
     * @param string $realm the URL-space to use.
     */
    public function setOpenidRealm($realm)
    {
        $this->config['openid.realm'] = $realm;
    }

    /**
     * If this is provided with the value true, and the authorization request is
     * granted, the authorization will include any previous authorizations
     * granted to this user/application combination for other scopes.
     * @param bool $include the URL-space to use.
     */
    public function setIncludeGrantedScopes($include)
    {
        $this->config['include_granted_scopes'] = $include;
    }

    /**
     * sets function to be called when an access token is fetched
     * @param callable $tokenCallback - function ($cacheKey, $accessToken)
     */
    public function setTokenCallback(callable $tokenCallback)
    {
        $this->config['token_callback'] = $tokenCallback;
    }

    /**
     * Revoke an OAuth2 access token or refresh token. This method will revoke the current access
     * token, if a token isn't provided.
     *
     * @param string|array|null $token The token (access token or a refresh token) that should be revoked.
     * @return boolean Returns True if the revocation was successful, otherwise False.
     */
    public function revokeToken($token = null)
    {
        $tokenRevoker = new Revoke($this->getHttpClient());

        return $tokenRevoker->revokeToken($token ?: $this->getAccessToken());
    }

    /**
     * Verify an id_token. This method will verify the current id_token, if one
     * isn't provided.
     *
     * @throws LogicException If no token was provided and no token was set using `setAccessToken`.
     * @throws UnexpectedValueException If the token is not a valid JWT.
     * @param string|null $idToken The token (id_token) that should be verified.
     * @return array|false Returns the token payload as an array if the verification was
     * successful, false otherwise.
     */
    public function verifyIdToken($idToken = null)
    {
        $tokenVerifier = new Verify(
            $this->getHttpClient(),
            $this->getCache(),
            $this->config['jwt']
        );

        if (null === $idToken) {
            $token = $this->getAccessToken();
            if (!isset($token['id_token'])) {
                throw new LogicException(
                    'id_token must be passed in or set as part of setAccessToken'
                );
            }
            $idToken = $token['id_token'];
        }

        return $tokenVerifier->verifyIdToken(
            $idToken,
            $this->getClientId()
        );
    }

    /**
     * Set the scopes to be requested. Must be called before createAuthUrl().
     * Will remove any previously configured scopes.
     * @param string|array $scope_or_scopes, ie:
     *    array(
     *        'https://www.googleapis.com/auth/plus.login',
     *        'https://www.googleapis.com/auth/moderator'
     *    );
     */
    public function setScopes($scope_or_scopes)
    {
        $this->requestedScopes = [];
        $this->addScope($scope_or_scopes);
    }

    /**
     * This functions adds a scope to be requested as part of the OAuth2.0 flow.
     * Will append any scopes not previously requested to the scope parameter.
     * A single string will be treated as a scope to request. An array of strings
     * will each be appended.
     * @param string|string[] $scope_or_scopes e.g. "profile"
     */
    public function addScope($scope_or_scopes)
    {
        if (is_string($scope_or_scopes) && !in_array($scope_or_scopes, $this->requestedScopes)) {
            $this->requestedScopes[] = $scope_or_scopes;
        } elseif (is_array($scope_or_scopes)) {
            foreach ($scope_or_scopes as $scope) {
                $this->addScope($scope);
            }
        }
    }

    /**
     * Returns the list of scopes requested by the client
     * @return array the list of scopes
     *
     */
    public function getScopes()
    {
        return $this->requestedScopes;
    }

    /**
     * @return string|null
     * @visible For Testing
     */
    public function prepareScopes()
    {
        if (empty($this->requestedScopes)) {
            return null;
        }

        return implode(' ', $this->requestedScopes);
    }

    /**
     * Helper method to execute deferred HTTP requests.
     *
     * @template T
     * @param RequestInterface $request
     * @param class-string<T>|false|null $expectedClass
     * @throws \Google\Exception
     * @return mixed|T|ResponseInterface
     */
    public function execute(RequestInterface $request, $expectedClass = null)
    {
        $request = $request
            ->withHeader(
                'User-Agent',
                sprintf(
                    '%s %s%s',
                    $this->config['application_name'],
                    self::USER_AGENT_SUFFIX,
                    $this->getLibraryVersion()
                )
            )
            ->withHeader(
                'x-goog-api-client',
                sprintf(
                    'gl-php/%s gdcl/%s',
                    phpversion(),
                    $this->getLibraryVersion()
                )
            );

        if ($this->config['api_format_v2']) {
            $request = $request->withHeader(
                'X-GOOG-API-FORMAT-VERSION',
                '2'
            );
        }

        // call the authorize method
        // this is where most of the grunt work is done
        $http = $this->authorize();

        return REST::execute(
            $http,
            $request,
            $expectedClass,
            $this->config['retry'],
            $this->config['retry_map']
        );
    }

    /**
     * Declare whether batch calls should be used. This may increase throughput
     * by making multiple requests in one connection.
     *
     * @param boolean $useBatch True if the batch support should
     * be enabled. Defaults to False.
     */
    public function setUseBatch($useBatch)
    {
        // This is actually an alias for setDefer.
        $this->setDefer($useBatch);
    }

    /**
     * Are we running in Google AppEngine?
     * return bool
     */
    public function isAppEngine()
    {
        return (isset($_SERVER['SERVER_SOFTWARE']) &&
            strpos($_SERVER['SERVER_SOFTWARE'], 'Google App Engine') !== false);
    }

    public function setConfig($name, $value)
    {
        $this->config[$name] = $value;
    }

    public function getConfig($name, $default = null)
    {
        return isset($this->config[$name]) ? $this->config[$name] : $default;
    }

    /**
     * For backwards compatibility
     * alias for setAuthConfig
     *
     * @param string $file the configuration file
     * @throws \Google\Exception
     * @deprecated
     */
    public function setAuthConfigFile($file)
    {
        $this->setAuthConfig($file);
    }

    /**
     * Set the auth config from new or deprecated JSON config.
     * This structure should match the file downloaded from
     * the "Download JSON" button on in the Google Developer
     * Console.
     * @param string|array $config the configuration json
     * @throws \Google\Exception
     */
    public function setAuthConfig($config)
    {
        if (is_string($config)) {
            if (!file_exists($config)) {
                throw new InvalidArgumentException(sprintf('file "%s" does not exist', $config));
            }

            $json = file_get_contents($config);

            if (!$config = json_decode($json, true)) {
                throw new LogicException('invalid json for auth config');
            }
        }

        $key = isset($config['installed']) ? 'installed' : 'web';
        if (isset($config['type']) && $config['type'] == 'service_account') {
            // @TODO(v3): Remove this, as it isn't accurate. ADC applies only to determining
            // credentials based on the user's environment.
            $this->useApplicationDefaultCredentials();

            // set the information from the config
            $this->setClientId($config['client_id']);
            $this->config['client_email'] = $config['client_email'];
            $this->config['signing_key'] = $config['private_key'];
            $this->config['signing_algorithm'] = 'HS256';
        } elseif (isset($config[$key])) {
            // old-style
            $this->setClientId($config[$key]['client_id']);
            $this->setClientSecret($config[$key]['client_secret']);
            if (isset($config[$key]['redirect_uris'])) {
                $this->setRedirectUri($config[$key]['redirect_uris'][0]);
            }
        } else {
            // new-style
            $this->setClientId($config['client_id']);
            $this->setClientSecret($config['client_secret']);
            if (isset($config['redirect_uris'])) {
                $this->setRedirectUri($config['redirect_uris'][0]);
            }
        }
    }

    /**
     * Use when the service account has been delegated domain wide access.
     *
     * @param string $subject an email address account to impersonate
     */
    public function setSubject($subject)
    {
        $this->config['subject'] = $subject;
    }

    /**
     * Declare whether making API calls should make the call immediately, or
     * return a request which can be called with ->execute();
     *
     * @param boolean $defer True if calls should not be executed right away.
     */
    public function setDefer($defer)
    {
        $this->deferExecution = $defer;
    }

    /**
     * Whether or not to return raw requests
     * @return boolean
     */
    public function shouldDefer()
    {
        return $this->deferExecution;
    }

    /**
     * @return OAuth2 implementation
     */
    public function getOAuth2Service()
    {
        if (!isset($this->auth)) {
            $this->auth = $this->createOAuth2Service();
        }

        return $this->auth;
    }

    /**
     * create a default google auth object
     */
    protected function createOAuth2Service()
    {
        $auth = new OAuth2([
            'clientId'          => $this->getClientId(),
            'clientSecret'      => $this->getClientSecret(),
            'authorizationUri'   => self::OAUTH2_AUTH_URL,
            'tokenCredentialUri' => self::OAUTH2_TOKEN_URI,
            'redirectUri'       => $this->getRedirectUri(),
            'issuer'            => $this->config['client_id'],
            'signingKey'        => $this->config['signing_key'],
            'signingAlgorithm'  => $this->config['signing_algorithm'],
        ]);

        return $auth;
    }

    /**
     * Set the Cache object
     * @param CacheItemPoolInterface $cache
     */
    public function setCache(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return CacheItemPoolInterface
     */
    public function getCache()
    {
        if (!$this->cache) {
            $this->cache = $this->createDefaultCache();
        }

        return $this->cache;
    }

    /**
     * @param array $cacheConfig
     */
    public function setCacheConfig(array $cacheConfig)
    {
        $this->config['cache_config'] = $cacheConfig;
    }

    /**
     * Set the Logger object
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        if (!isset($this->logger)) {
            $this->logger = $this->createDefaultLogger();
        }

        return $this->logger;
    }

    protected function createDefaultLogger()
    {
        $logger = new Logger('google-api-php-client');
        if ($this->isAppEngine()) {
            $handler = new MonologSyslogHandler('app', LOG_USER, Logger::NOTICE);
        } else {
            $handler = new MonologStreamHandler('php://stderr', Logger::NOTICE);
        }
        $logger->pushHandler($handler);

        return $logger;
    }

    protected function createDefaultCache()
    {
        return new MemoryCacheItemPool();
    }

    /**
     * Set the Http Client object
     * @param ClientInterface $http
     */
    public function setHttpClient(ClientInterface $http)
    {
        $this->http = $http;
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient()
    {
        if (null === $this->http) {
            $this->http = $this->createDefaultHttpClient();
        }

        return $this->http;
    }

    /**
     * Set the API format version.
     *
     * `true` will use V2, which may return more useful error messages.
     *
     * @param bool $value
     */
    public function setApiFormatV2($value)
    {
        $this->config['api_format_v2'] = (bool) $value;
    }

    protected function createDefaultHttpClient()
    {
        $guzzleVersion = null;
        if (defined('\GuzzleHttp\ClientInterface::MAJOR_VERSION')) {
            $guzzleVersion = ClientInterface::MAJOR_VERSION;
        } elseif (defined('\GuzzleHttp\ClientInterface::VERSION')) {
            $guzzleVersion = (int)substr(ClientInterface::VERSION, 0, 1);
        }

        if (5 === $guzzleVersion) {
            $options = [
                'base_url' => $this->config['base_path'],
                'defaults' => ['exceptions' => false],
            ];
            if ($this->isAppEngine()) {
                if (class_exists(StreamHandler::class)) {
                    // set StreamHandler on AppEngine by default
                    $options['handler'] = new StreamHandler();
                    $options['defaults']['verify'] = '/etc/ca-certificates.crt';
                }
            }
        } elseif (6 === $guzzleVersion || 7 === $guzzleVersion) {
            // guzzle 6 or 7
            $options = [
                'base_uri' => $this->config['base_path'],
                'http_errors' => false,
            ];
        } else {
            throw new LogicException('Could not find supported version of Guzzle.');
        }

        return new GuzzleClient($options);
    }

    /**
     * @return FetchAuthTokenCache
     */
    private function createApplicationDefaultCredentials()
    {
        $scopes = $this->prepareScopes();
        $sub = $this->config['subject'];
        $signingKey = $this->config['signing_key'];

        // create credentials using values supplied in setAuthConfig
        if ($signingKey) {
            $serviceAccountCredentials = [
                'client_id' => $this->config['client_id'],
                'client_email' => $this->config['client_email'],
                'private_key' => $signingKey,
                'type' => 'service_account',
                'quota_project_id' => $this->config['quota_project'],
            ];
            $credentials = CredentialsLoader::makeCredentials(
                $scopes,
                $serviceAccountCredentials
            );
        } else {
            // When $sub is provided, we cannot pass cache classes to ::getCredentials
            // because FetchAuthTokenCache::setSub does not exist.
            // The result is when $sub is provided, calls to ::onGce are not cached.
            $credentials = ApplicationDefaultCredentials::getCredentials(
                $scopes,
                null,
                $sub ? null : $this->config['cache_config'],
                $sub ? null : $this->getCache(),
                $this->config['quota_project']
            );
        }

        // for service account domain-wide authority (impersonating a user)
        // @see https://developers.google.com/identity/protocols/OAuth2ServiceAccount
        if ($sub) {
            if (!$credentials instanceof ServiceAccountCredentials) {
                throw new DomainException('domain-wide authority requires service account credentials');
            }

            $credentials->setSub($sub);
        }

        // If we are not using FetchAuthTokenCache yet, create it now
        if (!$credentials instanceof FetchAuthTokenCache) {
            $credentials = new FetchAuthTokenCache(
                $credentials,
                $this->config['cache_config'],
                $this->getCache()
            );
        }
        return $credentials;
    }

    protected function getAuthHandler()
    {
        // Be very careful using the cache, as the underlying auth library's cache
        // implementation is naive, and the cache keys do not account for user
        // sessions.
        //
        // @see https://github.com/google/google-api-php-client/issues/821
        return AuthHandlerFactory::build(
            $this->getCache(),
            $this->config['cache_config']
        );
    }

    private function createUserRefreshCredentials($scope, $refreshToken)
    {
        $creds = array_filter([
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'refresh_token' => $refreshToken,
        ]);

        return new UserRefreshCredentials($scope, $creds);
    }

    private function checkUniverseDomain($credentials)
    {
        $credentialsUniverse = $credentials instanceof GetUniverseDomainInterface
            ? $credentials->getUniverseDomain()
            : GetUniverseDomainInterface::DEFAULT_UNIVERSE_DOMAIN;
        if ($credentialsUniverse !== $this->getUniverseDomain()) {
            throw new DomainException(sprintf(
                'The configured universe domain (%s) does not match the credential universe domain (%s)',
                $this->getUniverseDomain(),
                $credentialsUniverse
            ));
        }
    }

    public function getUniverseDomain()
    {
        return $this->config['universe_domain'];
    }
}

```

## Source: FaqController@index
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Http\Resources\FaqCollection;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    /**
     * Display a listing of the FAQs.
     */
    public function index(Request $request)
    {
        $query = Faq::query();

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter active only
        if ($request->boolean('active_only', true)) {
            $query->active();
        }

        // Search in question and answer
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('question', 'LIKE', "%{$search}%")
                    ->orWhere('answer', 'LIKE', "%{$search}%");
            });
        }

        // Order by
        $query->ordered();

        // Get categories list
        if ($request->boolean('with_categories', false)) {
            $categories = Faq::active()
                ->distinct('category')
                ->pluck('category')
                ->filter()
                ->values();
        }

        $perPage = $request->get('per_page', 15);
        $faqs = $query->paginate($perPage);

        $response = [
            'data' => new FaqCollection($faqs),
        ];

        if ($request->boolean('with_categories', false)) {
            $response['categories'] = $categories;
        }

        return response()->json($response);
    }

    /**
     * Store a newly created FAQ.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $faq = Faq::create($validator->validated());

        return response()->json([
            'message' => 'FAQ created successfully',
            'data' => new FaqResource($faq),
        ], 201);
    }

    /**
     * Display the specified FAQ.
     */
    public function show(Faq $faq)
    {
        return new FaqResource($faq);
    }

    /**
     * Update the specified FAQ.
     */
    public function update(Request $request, Faq $faq)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'sometimes|required|string|max:255',
            'answer' => 'sometimes|required|string',
            'category' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $faq->update($validator->validated());

        return response()->json([
            'message' => 'FAQ updated successfully',
            'data' => new FaqResource($faq),
        ]);
    }

    /**
     * Remove the specified FAQ.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json([
            'message' => 'FAQ deleted successfully',
        ]);
    }

    /**
     * Get all FAQ categories.
     */
    public function categories()
    {
        $categories = Faq::active()
            ->distinct('category')
            ->pluck('category')
            ->filter()
            ->values();

        return response()->json([
            'data' => $categories,
        ]);
    }

    /**
     * Get FAQs by category.
     */
    public function byCategory($category)
    {
        $faqs = Faq::active()
            ->category($category)
            ->ordered()
            ->get();

        return FaqResource::collection($faqs);
    }
}

```

## Source: NotificationController@clearAll
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class NotificationController extends Controller
{
    /**
     * Get all notifications for authenticated user
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        $perPage = max(1, min(100, (int) $request->get('per_page', 15)));

        $notifications = $this->buildNotificationsQuery($request)->paginate($perPage);
        $transformed = $notifications->getCollection()->map(fn ($n) => $this->transformNotification($n))->values();
        $notifications->setCollection($transformed);

        return response()->json([
            'success' => true,
            'data' => [
                'notifications' => $notifications->items(),
                'unread_count' => $user->unreadNotifications()->count(),
                'total_count' => $user->notifications()->count(),
                'pagination' => [
                    'current_page' => $notifications->currentPage(),
                    'last_page' => $notifications->lastPage(),
                    'per_page' => $notifications->perPage(),
                    'total' => $notifications->total(),
                ],
            ],
        ]);
    }

    /**
     * Same as index but attaches related models (meal, order) when referenced in notification data.
     */
    public function indexWithResources(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            if ($user === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                ], 401);
            }

            $perPage = max(1, min(100, (int) $request->get('per_page', 15)));

            $notifications = $this->buildNotificationsQuery($request)->paginate($perPage);
            $pageItems = $notifications->getCollection();

            $mealIds = [];
            $orderIds = [];
            foreach ($pageItems as $n) {
                $d = $this->notificationDataAsArray($n->data);
                if (! empty($d['meal_id']) && is_numeric($d['meal_id'])) {
                    $mealIds[] = (int) $d['meal_id'];
                }
                if (! empty($d['order_id']) && is_numeric($d['order_id'])) {
                    $orderIds[] = (int) $d['order_id'];
                }
            }
            $mealIds = array_values(array_unique($mealIds));
            $orderIds = array_values(array_unique($orderIds));

            $meals = $mealIds === []
                ? collect()
                : Meal::query()->with('category')->whereIn('id', $mealIds)->get()->keyBy('id');
            $orders = $orderIds === []
                ? collect()
                : Order::query()->whereIn('id', $orderIds)->get()->keyBy('id');

            $transformed = $pageItems->map(function (DatabaseNotification $notification) use ($meals, $orders) {
                $row = $this->transformNotification($notification);
                $d = $this->notificationDataAsArray($notification->data);
                $resources = [];

                if (! empty($d['meal_id']) && is_numeric($d['meal_id'])) {
                    $meal = $meals->get((int) $d['meal_id']);
                    if ($meal) {
                        $resources['meal'] = [
                            'id' => $meal->id,
                            'title' => $meal->title,
                            'slug' => $meal->slug,
                            'image_url' => $meal->image_url,
                            ...$meal->getApiPriceAttributes(),
                            'has_offer' => $meal->hasOffer(),
                            'category' => $meal->category ? [
                                'id' => $meal->category->id,
                                'name' => $meal->category->name,
                            ] : null,
                        ];
                    }
                }

                if (! empty($d['order_id']) && is_numeric($d['order_id'])) {
                    $order = $orders->get((int) $d['order_id']);
                    if ($order) {
                        $resources['order'] = [
                            'id' => $order->id,
                            'order_number' => $order->order_number,
                            'status' => $order->status,
                            'total' => (string) $order->total,
                            'placed_at' => $order->placed_at?->toIso8601String(),
                            'created_at' => $order->created_at?->toIso8601String(),
                        ];
                    }
                }

                $row['resources'] = $resources;

                return $row;
            })->values();

            $notifications->setCollection($transformed);

            return response()->json([
                'success' => true,
                'data' => [
                    'notifications' => $notifications->items(),
                    'unread_count' => $user->unreadNotifications()->count(),
                    'total_count' => $user->notifications()->count(),
                    'pagination' => [
                        'current_page' => $notifications->currentPage(),
                        'last_page' => $notifications->lastPage(),
                        'per_page' => $notifications->perPage(),
                        'total' => $notifications->total(),
                    ],
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('notifications.with-resources failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load notifications',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /** Apply list filters to the authenticated user's notifications query. */
    private function buildNotificationsQuery(Request $request)
    {
        $user = Auth::user();
        $query = $user->notifications();

        if ($request->has('read')) {
            $isRead = filter_var($request->read, FILTER_VALIDATE_BOOLEAN);
            $query = $isRead ? $query->read() : $query->unread();
        }

        if ($request->has('type')) {
            $query->where('data->type', $request->type);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('data->title', 'like', "%{$search}%")
                    ->orWhere('data->body', 'like', "%{$search}%");
            });
        }

        $allowedOrderBy = ['created_at', 'read_at'];
        $orderBy = in_array((string) $request->get('order_by', 'created_at'), $allowedOrderBy, true)
            ? (string) $request->get('order_by', 'created_at')
            : 'created_at';
        $orderDirection = strtolower((string) $request->get('order_dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $query->orderBy($orderBy, $orderDirection);

        return $query;
    }

    /**
     * @return array<string, mixed>
     */
    private function notificationDataAsArray(mixed $data): array
    {
        if (is_array($data)) {
            return $data;
        }

        if (is_string($data) && $data !== '') {
            $decoded = json_decode($data, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    /**
     * Get notification statistics
     */
    public function stats(): JsonResponse
    {
        $user = Auth::user();

        $allNotifications = $user->notifications();
        $unreadNotifications = $user->unreadNotifications();

        $total = $allNotifications->count();
        $unread = $unreadNotifications->count();

        // Count by type (in-memory; JSON path must not use dot form on the query builder)
        $typeCounts = $allNotifications->get()
            ->groupBy(function (DatabaseNotification $n) {
                $data = $this->notificationDataAsArray($n->data);

                return $data['type'] ?? 'unknown';
            })
            ->map(function ($notifications) {
                return [
                    'total' => $notifications->count(),
                    'unread' => $notifications->whereNull('read_at')->count(),
                ];
            });

        $recentTypes = $allNotifications->latest()
            ->take(5)
            ->get()
            ->map(function (DatabaseNotification $n) {
                $data = $this->notificationDataAsArray($n->data);

                return $data['type'] ?? null;
            })
            ->filter()
            ->unique()
            ->values();

        $last = $allNotifications->latest()->first();

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'unread' => $unread,
                'read' => max(0, $total - $unread),
                'by_type' => $typeCounts,
                'recent_types' => $recentTypes,
                'last_notification_at' => $last?->created_at?->toIso8601String(),
            ],
        ]);
    }

    /**
     * Get a single notification
     */
    public function show(string $id): JsonResponse
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);

        // Mark as read when viewing
        if (! $notification->read_at) {
            $notification->markAsRead();
        }

        return response()->json([
            'success' => true,
            'data' => $this->transformNotification($notification, true),
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(string $id): JsonResponse
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);

        if (! $notification->read_at) {
            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'data' => $this->transformNotification($notification),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notification is already read',
        ], 400);
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(string $id): JsonResponse
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);

        if ($notification->read_at) {
            $notification->markAsUnread();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as unread',
                'data' => $this->transformNotification($notification),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notification is already unread',
        ], 400);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): JsonResponse
    {
        $user = Auth::user();
        $unreadCount = $user->unreadNotifications()->count();

        if ($unreadCount > 0) {
            $user->unreadNotifications()->update(['read_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => "{$unreadCount} notifications marked as read",
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No unread notifications',
        ], 400);
    }

    /**
     * Delete a notification
     */
    public function destroy(string $id): JsonResponse
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully',
        ]);
    }

    /**
     * Delete multiple notifications
     */
    public function destroyMultiple(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();
        $deletedCount = $user->notifications()
            ->whereIn('id', $request->ids)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => "{$deletedCount} notifications deleted successfully",
        ]);
    }

    /**
     * Clear all notifications
     */
    public function clearAll(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'sometimes|string|in:read,unread,all',
            'confirmation' => 'required|boolean|accepted',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        if (! $request->confirmation) {
            return response()->json([
                'success' => false,
                'message' => 'Please confirm you want to clear all notifications',
            ], 400);
        }

        $user = Auth::user();
        $type = $request->get('type', 'all');

        switch ($type) {
            case 'read':
                $count = $user->readNotifications()->count();
                $user->readNotifications()->delete();
                $message = "{$count} read notifications cleared";
                break;

            case 'unread':
                $count = $user->unreadNotifications()->count();
                $user->unreadNotifications()->delete();
                $message = "{$count} unread notifications cleared";
                break;

            case 'all':
            default:
                $count = $user->notifications()->count();
                $user->notifications()->delete();
                $message = "All {$count} notifications cleared";
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Get notifications by type
     */
    public function byType(string $type): JsonResponse
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->where('data->type', $type)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $transformedNotifications = $notifications->map(function ($notification) {
            return $this->transformNotification($notification);
        });

        return response()->json([
            'success' => true,
            'data' => [
                'type' => $type,
                'notifications' => $transformedNotifications,
                'total' => $notifications->total(),
                'unread' => $notifications->whereNull('read_at')->count(),
            ],
        ]);
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount(): JsonResponse
    {
        $user = Auth::user();
        $count = $user->unreadNotifications()->count();

        return response()->json([
            'success' => true,
            'data' => [
                'count' => $count,
                'has_unread' => $count > 0,
            ],
        ]);
    }

    /**
     * Get recent notifications (last 24 hours)
     */
    public function recent(): JsonResponse
    {
        $user = Auth::user();

        $recentNotifications = $user->notifications()
            ->where('created_at', '>=', now()->subDay())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $transformedNotifications = $recentNotifications->map(function ($notification) {
            return $this->transformNotification($notification);
        });

        return response()->json([
            'success' => true,
            'data' => [
                'notifications' => $transformedNotifications,
                'total_recent' => $recentNotifications->count(),
                'unread_recent' => $recentNotifications->whereNull('read_at')->count(),
            ],
        ]);
    }

    /**
     * Transform notification for API response
     */
    private function transformNotification(DatabaseNotification $notification, bool $detailed = false): array
    {
        $data = $this->notificationDataAsArray($notification->data);
        $type = isset($data['type']) && is_string($data['type']) ? $data['type'] : 'unknown';
        $baseData = [
            'id' => $notification->id,
            'type' => $type,
            'title' => is_string($data['title'] ?? null) ? $data['title'] : 'Notification',
            'body' => is_string($data['body'] ?? null) ? $data['body'] : '',
            'action_url' => $data['action_url'] ?? null,
            'action_label' => is_string($data['action_label'] ?? null) ? $data['action_label'] : 'View',
            'is_read' => ! is_null($notification->read_at),
            'read_at' => $notification->read_at?->toISOString(),
            'created_at' => $notification->created_at?->toISOString() ?? '',
            'created_at_human' => $notification->created_at?->diffForHumans() ?? '',
            'icon' => $this->getIconForType($type),
            'priority' => is_string($data['priority'] ?? null) ? $data['priority'] : 'normal',
        ];

        if ($detailed) {
            $baseData['data'] = $data;
            $baseData['channels'] = $data['channels'] ?? ['database'];
            $baseData['metadata'] = $data['metadata'] ?? [];
            $baseData['expires_at'] = $data['expires_at'] ?? null;
        }

        return $baseData;
    }

    /**
     * Get appropriate icon for notification type
     */
    private function getIconForType(string $type): string
    {
        $icons = [
            'order_confirmation' => 'shopping-bag',
            'order_shipped' => 'truck',
            'delivery_updates' => 'package',
            'out_of_stock_alerts' => 'alert-triangle',
            'weekly_discounts' => 'percent',
            'exclusive_member_offers' => 'crown',
            'seasonal_campaigns' => 'gift',
            'cart_reminders' => 'shopping-cart',
            'payment_billing' => 'credit-card',
            'system' => 'bell',
            'account' => 'user',
            'security' => 'shield',
        ];

        return $icons[$type] ?? 'bell';
    }
}

```

## Source: OrderController@store
```php
<?php

namespace App\Http\Controllers\Api;

use Stripe\Stripe;
use App\Models\Cart;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderItem;
use App\Models\OrderNote;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Services\ShippingService;

class OrderController extends Controller
{

    public function show(Request $request, Order $order)
    {
        $order = $order->load(['items.meal', 'address']);

        return response()->json([
            'success' => true,
            'message' => 'Order retrieved successfully',
            'data' => $this->formatOrder($order),
        ]);
    }
    
    /**
     * Create a new order.
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $user = $request->user();
            $validated = $request->validated();

            // Get user's active cart
            $cart = $user->activeCart()->with('items.meal')->first();

            if (!$cart || $cart->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty. Please add items to your cart before placing an order.',
                ], 400);
            }

            // Validate and process items from cart
            $itemsResult = $this->validateAndProcessCartItems($cart->items);
            if (!$itemsResult['success']) {
                return response()->json($itemsResult['response'], 400);
            }

            $items = $itemsResult['items'];

            // Calculate totals and shipping (use cart totals; add shipping for delivery)
            $cart->calculateTotals();
            $shippingService = app(ShippingService::class);
            $shippingFee = $shippingService->calculateShippingFee((float) $cart->subtotal, $validated['delivery_type']);
            $totals = [
                'subtotal' => $cart->subtotal,
                'tax' => $cart->tax,
                'discount' => $cart->discount,
                'shipping_fee' => $shippingFee,
                'total' => (float) $cart->subtotal + (float) $cart->tax + $shippingFee,
            ];
            $total = $totals['total'];

            // Validate amount matches cart total
            // if (abs($total - $validated['amount']) > 0.01) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Amount mismatch. Please recalculate your order.',
            //         'calculated_total' => $total,
            //         'provided_amount' => $validated['amount'],
            //     ], 400);
            // }

            DB::beginTransaction();

            // $paymentResult = match ($validated['payment_method']) {
            //     'stripe_checkout' => ['success' => true],
            //     default => $this->processPayment($user, $validated, $total),
            // };

            // if (! $paymentResult['success']) {
            //     DB::rollBack();

            //     return response()->json($paymentResult['response'], 400);
            // }

            $stripePaymentIntentId = $paymentResult['stripe_payment_intent_id'] ?? null;

            // Create order
            $order = $this->createOrder($user, $validated, $totals['subtotal'], $totals, $stripePaymentIntentId);

            // Create order items and update stock
            $this->createOrderItems($order, $items);

            // Clear user's active cart
            $this->clearUserCart($user);

            
            if(isset($validated['special_note_id'])) {
                OrderNote::create([
                    'order_id' => $order->id,
                    'special_note_id' => $validated['special_note_id'],
                    'notes' => $validated['notes'] ?? null,
                ]);
            }
            if(isset($validated['notes'])   ) {
                OrderNote::create([
                    'order_id' => $order->id,
                    'special_note_id' => null,
                    'notes' => $validated['notes'],
                ]);
            }
            DB::commit();

            $order->load(['items.meal', 'address']);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => $this->formatOrder($order),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validate and process order items from cart.
     */
    private function validateAndProcessCartItems($cartItems): array
    {
        $items = [];
        $subtotal = 0;

        foreach ($cartItems as $cartItem) {
            $meal = $cartItem->meal;

            if (!$meal) {
                return [
                    'success' => false,
                    'response' => [
                        'success' => false,
                        'message' => 'One or more items in your cart are no longer available.',
                    ],
                ];
            }

            if (!$meal->is_available) {
                return [
                    'success' => false,
                    'response' => [
                        'success' => false,
                        'message' => "Meal '{$meal->title}' is currently unavailable",
                    ],
                ];
            }

            if ($meal->stock_quantity < $cartItem->quantity) {
                return [
                    'success' => false,
                    'response' => [
                        'success' => false,
                        'message' => "Only {$meal->stock_quantity} items available for '{$meal->title}'",
                    ],
                ];
            }

            $maxPerProduct = config('cart.max_quantity_per_product', 10);
            if ($cartItem->quantity > $maxPerProduct) {
                return [
                    'success' => false,
                    'response' => [
                        'success' => false,
                        'message' => "Maximum {$maxPerProduct} units per product allowed. Please reduce quantity for '{$meal->title}'.",
                    ],
                ];
            }

            // Use cart item pricing (already calculated)
            $items[] = [
                'meal' => $meal,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->unit_price,
                'discount_amount' => $cartItem->discount_amount,
                'subtotal' => $cartItem->subtotal,
            ];

            $subtotal += $cartItem->subtotal;
        }

        return [
            'success' => true,
            'items' => $items,
            'subtotal' => $subtotal,
        ];
    }

    /**
     * Calculate order totals.
     */
    private function calculateTotals(float $subtotal): array
    {
        $tax = $subtotal * 0.1; // 10% tax
        $discount = 0;
        $total = $subtotal + $tax - $discount;

        return [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'total' => $total,
        ];
    }

    /**
     * Process payment for card orders.
     */
    private function processPayment($user, array $validated, float $total): array
    {
        if ($validated['payment_method'] !== 'card') {
            return ['success' => true];
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        if (!$user->stripe_customer_id) {
            return [
                'success' => false,
                'response' => [
                    'success' => false,
                    'message' => 'Stripe customer not found. Please add a payment method first.',
                ],
            ];
        }

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($total * 100),
                'currency' => 'usd',
                'customer' => $user->stripe_customer_id,
                'payment_method' => $validated['payment_method_id'],
                'off_session' => true,
                'confirm' => true,
            ]);

            if ($paymentIntent->status !== 'succeeded') {
                return [
                    'success' => false,
                    'response' => [
                        'success' => false,
                        'message' => 'Payment failed: ' . $paymentIntent->status,
                    ],
                ];
            }

            return [
                'success' => true,
                'stripe_payment_intent_id' => $paymentIntent->id,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'response' => [
                    'success' => false,
                    'message' => 'Payment processing failed: ' . $e->getMessage(),
                ],
            ];
        }
    }

    /**
     * Create order record.
     */
    private function createOrder($user, array $validated, float $subtotal, array $totals, ?string $stripePaymentIntentId = null): Order
    {
        $isHostedStripe = $validated['payment_method'] === 'stripe_checkout';

        return Order::create([
            'user_id' => $user->id,
            'address_id' => $validated['delivery_type'] === 'delivery' ? $validated['address_id'] : null,
            'payment_method' => $validated['payment_method'],
            'payment_method_id' => null,
            'stripe_payment_intent_id' => $stripePaymentIntentId,
            'delivery_type' => $validated['delivery_type'],
            'status' => $isHostedStripe ? 'awaiting_payment' : 'placed',
            'subtotal' => $subtotal,
            'tax' => $totals['tax'],
            'discount' => $totals['discount'],
            'shipping_fee' => $totals['shipping_fee'],
            'total' => $totals['total'],
            'notes' => $validated['notes'] ?? null,
            'placed_at' => $isHostedStripe ? null : now(),
        ]);
    }

    /**
     * Create order items and update stock.
     */
    private function createOrderItems(Order $order, array $items): void
    {
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'meal_id' => $item['meal']->id,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'discount_amount' => $item['discount_amount'],
                'subtotal' => $item['subtotal'],
            ]);

            $item['meal']->decrement('stock_quantity', $item['quantity']);
        }
    }

    /**
     * Clear user's active cart.
     */
    private function clearUserCart($user): void
    {
        $cart = $user->activeCart()->first();
        if ($cart) {
            $cart->items()->delete();
            $cart->update(['status' => 'completed']);
        }
    }

    /**
     * Get all user orders.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $orders = Order::
                with(['items.meal.category', 'items.meal.subcategory', 'address'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($order) {
                    return $this->formatOrder($order);
                });

            return response()->json([
                'success' => true,
                'message' => 'Orders retrieved successfully',
                'data' => $orders,
                'total_count' => $orders->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve orders',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Track the last order with status positions.
     */
    public function track(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $order = Order::where('user_id', $user->id)
                ->whereNotIn('status', ['cancelled', 'delivered'])
                ->with(['items.meal.category', 'items.meal.subcategory', 'address'])
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active order found',
                ], 404);
            }

            if ($order->status === 'awaiting_payment') {
                return response()->json([
                    'success' => true,
                    'message' => 'Order is waiting for payment. Complete checkout to continue.',
                    'data' => [
                        'order' => $this->formatOrder($order),
                        'awaiting_payment' => true,
                        'tracking' => null,
                    ],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order tracking retrieved successfully',
                'data' => [
                    'order' => $this->formatOrder($order),
                    'tracking' => [
                        'position' => $order->status_position,
                        'status' => $order->status,
                        'status_description' => $order->status_description,
                        'positions' => [
                            [
                                'position' => 1,
                                'status' => 'placed',
                                'label' => 'Order Placed',
                                'description' => 'Your order has been placed',
                                'completed' => in_array($order->status, ['placed', 'processing', 'shipping', 'out_for_delivery', 'delivered']),
                                'timestamp' => $order->placed_at,
                            ],
                            [
                                'position' => 2,
                                'status' => 'processing',
                                'label' => 'Processing',
                                'description' => 'Your order is being processed',
                                'completed' => in_array($order->status, ['processing', 'shipping', 'out_for_delivery', 'delivered']),
                                'timestamp' => $order->processing_at,
                            ],
                            [
                                'position' => 3,
                                'status' => 'shipping',
                                'label' => 'Shipping',
                                'description' => 'Your order is being shipped',
                                'completed' => in_array($order->status, ['shipping', 'out_for_delivery', 'delivered']),
                                'timestamp' => $order->shipping_at,
                            ],
                            [
                                'position' => 4,
                                'status' => 'out_for_delivery',
                                'label' => 'Out for Delivery',
                                'description' => 'Your order is on the way',
                                'completed' => in_array($order->status, ['out_for_delivery', 'delivered']),
                                'timestamp' => $order->out_for_delivery_at,
                            ],
                            [
                                'position' => 5,
                                'status' => 'delivered',
                                'label' => 'Delivered',
                                'description' => 'Your order has been delivered',
                                'completed' => $order->status === 'delivered',
                                'timestamp' => $order->delivered_at,
                            ],
                        ],
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to track order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Format order data for response.
     */
    private function formatOrder(Order $order): array
    {
        return [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'payment_method' => $order->payment_method,
            'stripe_payment_intent_id' => $order->stripe_payment_intent_id,
            'delivery_type' => $order->delivery_type,
            'status' => $order->status,
            'status_position' => $order->status_position,
            'status_description' => $order->status_description,
            'items' => $order->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'meal' => [
                        'id' => $item->meal->id,
                        'title' => $item->meal->title,
                        'slug' => $item->meal->slug,
                        'image_url' => $item->meal->image_url,
                        ...$item->meal->getApiPriceAttributes(),
                        'category' => $item->meal->category ? [
                            'id' => $item->meal->category->id,
                            'name' => $item->meal->category->name,
                        ] : null,
                        'subcategory' => $item->meal->subcategory ? [
                            'id' => $item->meal->subcategory->id,
                            'name' => $item->meal->subcategory->name,
                        ] : null,
                    ],
                    'quantity' => $item->quantity,
                    'unit_price' => (float) $item->unit_price,
                    'discount_amount' => (float) $item->discount_amount,
                    'subtotal' => (float) $item->subtotal,
                ];
            }),
            'address' => $order->address ? [
                'id' => $order->address->id,
                'label' => $order->address->label,
                'full_name' => $order->address->full_name,
                'phone' => $order->address->phone,
                'country_code' => $order->address->country_code,
                'street_address' => $order->address->street_address,
                'building_number' => $order->address->building_number,
                'floor' => $order->address->floor,
                'apartment' => $order->address->apartment,
                'landmark' => $order->address->landmark,
                'city' => $order->address->city,
                'state' => $order->address->state,
                'postal_code' => $order->address->postal_code,
                'country' => $order->address->country,
                'full_address' => $order->address->full_address,
                'latitude' => $order->address->latitude,
                'longitude' => $order->address->longitude,
            ] : null,
            'subtotal' => $order->subtotal,
            'tax' => $order->tax,
            'discount' => $order->discount,
            'shipping_fee' => (float) ($order->shipping_fee ?? 0),
            'total' => $order->total,
            'notes' => $order->notes,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
            'placed_at' => $order->placed_at,
            'processing_at' => $order->processing_at,
            'shipping_at' => $order->shipping_at,
            'out_for_delivery_at' => $order->out_for_delivery_at,
            'delivered_at' => $order->delivered_at,
            'estimated_delivery_time' => $order->estimated_delivery_time,
            'special_note' => $order->special_note,
            'schedule_delivery' => $order->schedule_delivery,
            'delivery_speed' => $order->delivery_speed,
        ];
    }
}

```

## Source: ProfileController@updateImage
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use App\Rules\UsernameMustContainLetter;
use App\Support\EgyptianPhoneRules;
use App\Support\EmailValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    private const PROFILE_SINGLE_IMAGE_MESSAGE = 'Only one profile image is allowed';

    /**
     * Get full user profile: picture, name, gender, birthday, addresses,
     * order history, in-progress orders with tracking, order notifications,
     * settings (sessions), wishlist.
     */
    public function show(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $user->load(['addresses', 'favorites.meal.category', 'favorites.meal.subcategory']);

            $addresses = $user->addresses()
                ->orderBy('is_default', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn (Address $a) => $this->formatAddress($a));

            $allOrders = Order::where('user_id', $user->id)
                ->with(['items.meal.category', 'items.meal.subcategory', 'address'])
                ->orderBy('created_at', 'desc')
                ->get();

            $orderHistory = $allOrders->map(fn (Order $o) => $this->formatOrderSummary($o));

            $inProgressOrders = $allOrders->whereNotIn('status', ['cancelled', 'delivered']);
            $inProgressWithTracking = $inProgressOrders->map(fn (Order $o) => $this->formatOrderWithTracking($o))->values();

            $orderNotifications = $user->notifications()
                ->where(function ($q) {
                    $q->where('data->type', 'order_confirmation')
                        ->orWhere('data->type', 'order_shipped')
                        ->orWhere('data->type', 'delivery_updates');
                })
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->get()
                ->map(fn ($n) => $this->formatNotification($n));

            $sessions = $this->formatSessions($user);
            $wishlist = $user->favorites->map(fn ($f) => $this->formatWishlistItem($f))->values();

            return response()->json([
                'success' => true,
                'message' => 'Profile retrieved successfully',
                'data' => [
                    'me' => [
                        'id' => $user->id,
                        'profile_picture' => $user->profile_image_url,
                        'name' => $user->full_name,
                        'username' => $user->username,
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'gender' => $user->gender,
                        'birthday' => $user->birthday?->format('Y-m-d'),
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'country_code' => $user->country_code,
                        'email_verified' => $user->email_verified,
                        'phone_verified' => $user->phone_verified,
                        'preferred_languages' => $user->preferred_languages ?? [],
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                    ],
                    'addresses' => $addresses,
                    'order_history' => [
                        'orders' => $orderHistory,
                        'ordered_at' => $orderHistory->map(fn ($o) => $o['placed_at'] ?? $o['created_at'])->values(),
                    ],
                    'in_progress_orders' => $inProgressWithTracking,
                    'order_notifications' => $orderNotifications,
                    'settings' => [
                        'privacy_and_security' => [
                            'active_sessions' => $sessions,
                            'change_password' => ['available' => true],
                            'change_username' => ['available' => true],
                        ],
                    ],
                    'wishlist' => $wishlist,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve profile',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update profile image
     */
    public function updateImage(Request $request): JsonResponse
    {
        try {
            if (count($request->allFiles()) > 1) {
                return response()->json([
                    'success' => false,
                    'message' => self::PROFILE_SINGLE_IMAGE_MESSAGE,
                    'errors' => ['image' => [self::PROFILE_SINGLE_IMAGE_MESSAGE]],
                ], 422);
            }

            $uploaded = $request->file('image');
            if (is_array($uploaded)) {
                return response()->json([
                    'success' => false,
                    'message' => self::PROFILE_SINGLE_IMAGE_MESSAGE,
                    'errors' => ['image' => [self::PROFILE_SINGLE_IMAGE_MESSAGE]],
                ], 422);
            }

            $validator = Validator::make($request->all(), [
                'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = $request->user();

            // Delete old image if exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Store new image
            $image = $request->file('image');
            $path = $image->store('profile-images', 'public');

            // Update user
            $user->update(['profile_image' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Profile image updated successfully',
                'data' => [
                    'profile_image' => $user->profile_image,
                    'profile_image_url' => $user->profile_image_url,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update profile information
     */
    public function updateInfo(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if ($request->has('phone') && is_string($request->input('phone'))) {
                $request->merge(['phone' => preg_replace('/\s+/', '', $request->input('phone'))]);
            }

            $validator = Validator::make($request->all(), [
                'username' => ['sometimes', 'string', 'max:'.User::USERNAME_MAX_LENGTH, Rule::unique('users')->ignore($user->id), 'not_regex:/\s/u', 'alpha_dash', new UsernameMustContainLetter],
                'firstname' => ['sometimes', 'string', 'max:255'],
                'lastname' => ['sometimes', 'string', 'max:255'],
                'gender' => ['sometimes', 'nullable', 'string', 'max:20', Rule::in(['male', 'female', 'other', 'prefer_not_to_say'])],
                'birthday' => ['sometimes', 'nullable', 'date', 'before:today'],
                'email' => ['sometimes', ...EmailValidation::formatRules(), 'max:255', Rule::unique('users')->ignore($user->id)],
                'phone' => ['sometimes', 'string', EgyptianPhoneRules::internationalPrefixRule(), 'min:11', 'max:13', EgyptianPhoneRules::mobileRule(), Rule::unique('users')->ignore($user->id)],
                'country_code' => ['sometimes', 'string', 'max:5', 'regex:/^\+\d{1,4}$/'],
                'preferred_languages' => ['sometimes', 'array'],
                'preferred_languages.*' => ['string', 'max:10'],
            ], [
                'username.max' => 'Maximum '.User::USERNAME_MAX_LENGTH.' characters allowed.',
                'username.not_regex' => 'Username must not contain spaces.',
                'username.alpha_dash' => 'Username may only contain letters, numbers, dashes and underscores.',
                'email.not_regex' => EmailValidation::trailingHyphenDotBeforeAtMessage(),
                'email.regex' => EmailValidation::domainStructureMessage(),
                'email.max' => 'The email address may not exceed 255 characters.',
                'phone.not_regex' => EgyptianPhoneRules::foreignPrefixMessage(),
                'phone.regex' => EgyptianPhoneRules::invalidMessage(),
                'phone.min' => EgyptianPhoneRules::lengthMessage(),
                'phone.max' => EgyptianPhoneRules::lengthMessage(),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Update only provided fields
            $data = $request->only(['username', 'firstname', 'lastname', 'gender', 'birthday', 'email', 'phone', 'country_code', 'preferred_languages']);

            // Handle preferred_languages separately (can be empty array)
            if ($request->has('preferred_languages')) {
                $data['preferred_languages'] = $request->preferred_languages ?? [];
            }

            // Remove empty values (except preferred_languages which can be empty array)
            $data = array_filter($data, function ($value, $key) {
                if ($key === 'preferred_languages') {
                    return true; // Always include preferred_languages even if empty
                }

                return $value !== null && $value !== '';
            }, ARRAY_FILTER_USE_BOTH);

            if (empty($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data provided to update',
                ], 400);
            }

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'full_name' => $user->full_name,
                    'gender' => $user->gender,
                    'birthday' => $user->birthday?->format('Y-m-d'),
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'country_code' => $user->country_code,
                    'preferred_languages' => $user->preferred_languages ?? [],
                    'profile_image_url' => $user->profile_image_url,
                    'updated_at' => $user->updated_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete profile image
     */
    public function deleteImage(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (! $user->profile_image) {
                return response()->json([
                    'success' => false,
                    'message' => 'No profile image to delete',
                ], 404);
            }

            // Delete image from storage
            if (Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Update user
            $user->update(['profile_image' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Profile image deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete profile image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * List active sessions/devices (Sanctum tokens). User can logout from each.
     */
    public function sessions(Request $request): JsonResponse
    {
        $user = $request->user();
        $currentTokenId = $request->user()->currentAccessToken()?->id;

        $tokens = $user->tokens()->get()->map(function ($token) use ($currentTokenId) {
            return [
                'id' => $token->id,
                'name' => $token->name,
                'last_used_at' => $token->last_used_at?->toIso8601String(),
                'is_current' => (string) $token->id === (string) $currentTokenId,
                'created_at' => $token->created_at?->toIso8601String(),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Sessions retrieved successfully',
            'data' => $tokens,
        ]);
    }

    /**
     * Revoke a session/device (logout from that token).
     */
    public function destroySession(Request $request, string $tokenId): JsonResponse
    {
        $user = $request->user();
        $currentTokenId = $user->currentAccessToken()?->id;

        if ((string) $tokenId === (string) $currentTokenId) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot revoke your current session from this request. Use logout instead.',
            ], 400);
        }

        $token = $user->tokens()->find($tokenId);
        if (! $token) {
            return response()->json([
                'success' => false,
                'message' => 'Session not found',
            ], 404);
        }

        $token->delete();

        return response()->json([
            'success' => true,
            'message' => 'Session revoked successfully',
        ]);
    }

    private function formatAddress(Address $address): array
    {
        return [
            'id' => $address->id,
            'label' => $address->label,
            'full_name' => $address->full_name,
            'phone' => $address->phone,
            'country_code' => $address->country_code,
            'street_address' => $address->street_address,
            'building_number' => $address->building_number,
            'floor' => $address->floor,
            'apartment' => $address->apartment,
            'landmark' => $address->landmark,
            'city' => $address->city,
            'state' => $address->state,
            'postal_code' => $address->postal_code,
            'country' => $address->country,
            'full_address' => $address->full_address ?? null,
            'is_default' => $address->is_default,
            'created_at' => $address->created_at,
            'updated_at' => $address->updated_at,
        ];
    }

    private function formatOrderSummary(Order $order): array
    {
        return [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'status' => $order->status,
            'status_description' => $order->status_description,
            'total' => (float) $order->total,
            'placed_at' => $order->placed_at?->toIso8601String(),
            'created_at' => $order->created_at?->toIso8601String(),
            'item_count' => $order->items->count(),
        ];
    }

    /**
     * Order with tracking: stages "arriving", "out for delivery", "delivered".
     */
    private function formatOrderWithTracking(Order $order): array
    {
        $trackingStage = match ($order->status) {
            'shipping' => 'arriving',
            'out_for_delivery' => 'out_for_delivery',
            'delivered' => 'delivered',
            default => 'processing',
        };

        return [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'status' => $order->status,
            'status_description' => $order->status_description,
            'tracking' => [
                'stage' => $trackingStage,
                'stage_label' => match ($trackingStage) {
                    'arriving' => 'Arriving',
                    'out_for_delivery' => 'Out for delivery',
                    'delivered' => 'Delivered',
                    default => 'Processing',
                },
                'positions' => [
                    ['stage' => 'arriving', 'label' => 'Arriving', 'completed' => in_array($order->status, ['shipping', 'out_for_delivery', 'delivered']), 'timestamp' => $order->shipping_at?->toIso8601String()],
                    ['stage' => 'out_for_delivery', 'label' => 'Out for delivery', 'completed' => in_array($order->status, ['out_for_delivery', 'delivered']), 'timestamp' => $order->out_for_delivery_at?->toIso8601String()],
                    ['stage' => 'delivered', 'label' => 'Delivered', 'completed' => $order->status === 'delivered', 'timestamp' => $order->delivered_at?->toIso8601String()],
                ],
            ],
            'total' => (float) $order->total,
            'placed_at' => $order->placed_at?->toIso8601String(),
            'estimated_delivery_time' => $order->estimated_delivery_time?->toIso8601String(),
            'address' => $order->address ? $this->formatAddress($order->address) : null,
            'items' => $order->items->map(fn ($item) => [
                'id' => $item->id,
                'meal' => ['id' => $item->meal->id, 'title' => $item->meal->title, 'image_url' => $item->meal->image_url],
                'quantity' => $item->quantity,
                'subtotal' => (float) $item->subtotal,
            ])->values(),
        ];
    }

    private function formatNotification($notification): array
    {
        $data = $notification->data ?? [];

        return [
            'id' => $notification->id,
            'type' => $data['type'] ?? 'order',
            'title' => $data['title'] ?? 'Order update',
            'body' => $data['body'] ?? '',
            'is_read' => $notification->read_at !== null,
            'read_at' => $notification->read_at?->toIso8601String(),
            'created_at' => $notification->created_at?->toIso8601String(),
            'action_url' => $data['action_url'] ?? null,
        ];
    }

    private function formatSessions($user): array
    {
        $currentTokenId = $user->currentAccessToken()?->id;

        return $user->tokens()->get()->map(function ($token) use ($currentTokenId) {
            return [
                'id' => $token->id,
                'name' => $token->name,
                'last_used_at' => $token->last_used_at?->toIso8601String(),
                'is_current' => (string) $token->id === (string) $currentTokenId,
            ];
        })->all();
    }

    private function formatWishlistItem($favorite): array
    {
        $meal = $favorite->meal;

        return [
            'id' => $meal->id,
            'title' => $meal->title,
            'slug' => $meal->slug,
            'image_url' => $meal->image_url,
            ...$meal->getApiPriceAttributes(),
            'has_offer' => $meal->hasOffer(),
            'category' => $meal->category ? ['id' => $meal->category->id, 'name' => $meal->category->name] : null,
            'is_favorited' => true,
            'favorited_at' => $favorite->created_at?->toIso8601String(),
        ];
    }
}

```

## Source: StripePaymentCallbackController@success
```php
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Throwable;

class StripePaymentCallbackController extends Controller
{
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return $this->jsonOrHtml(false, 'Missing session_id parameter.', null, 400);
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = Session::retrieve($sessionId);
        } catch (Throwable $e) {
            report($e);

            return $this->jsonOrHtml(false, 'Unable to verify payment session.', null, 502);
        }

        if ($session->payment_status !== 'paid') {
            return $this->jsonOrHtml(false, 'Payment has not been completed.', null, 402);
        }

        $order = $this->resolveOrder($session);

        if (! $order) {
            return $this->jsonOrHtml(false, 'Order not found.', null, 404);
        }

        if ($order->status === 'awaiting_payment') {
            $pi = $session->payment_intent;
            $paymentIntentId = is_string($pi) ? $pi : ($pi->id ?? null);

            DB::transaction(function () use ($order, $paymentIntentId, $session) {
                $order->refresh();
                if ($order->status !== 'awaiting_payment') {
                    return;
                }

                $order->update([
                    'status' => 'placed',
                    'placed_at' => now(),
                    'stripe_payment_intent_id' => $paymentIntentId,
                    'stripe_checkout_session_id' => $session->id,
                ]);
            });

            $order->refresh();
        }

        return $this->jsonOrHtml(true, 'Payment successful. Your order has been placed.', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'status' => $order->status,
        ], 200);
    }

    public function cancel(Request $request)
    {
        $orderId = $request->query('order_id');

        return $this->jsonOrHtml(false, 'Payment was cancelled.', [
            'order_id' => $orderId,
        ], 200);
    }

    private function resolveOrder(Session $session): ?Order
    {
        $orderId = $session->metadata->order_id ?? null;
        if ($orderId) {
            return Order::query()->whereKey((int) $orderId)->first();
        }

        if ($session->client_reference_id) {
            return Order::query()->whereKey((int) $session->client_reference_id)->first();
        }

        return null;
    }

    private function jsonOrHtml(bool $success, string $message, ?array $data, int $status)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}

```

## Source: DashboardController@getCategoryDistribution
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Meal;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics and insights.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            return response()->json([
                'success' => true,
                'message' => 'Dashboard data retrieved successfully',
                'data' => [
                    'overview' => $this->getOverview($user),
                    'shopping_insights' => $this->getShoppingInsights($user),
                    'category_distribution' => $this->getCategoryDistribution($user),
                    'recent_orders' => $this->getRecentOrders($user),
                    'top_purchases' => $this->getTopPurchases($user),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve dashboard data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get overview statistics.
     */
    private function getOverview($user): array
    {
        // Active order tracking
        $activeOrder = Order::where('user_id', $user->id)
            ->whereNotIn('status', ['cancelled', 'delivered'])
            ->with(['items.me
// [truncated — token budget]
```
