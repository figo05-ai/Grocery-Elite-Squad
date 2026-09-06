<?php

namespace App\Providers\AppServiceProvider;

use App\Infrastructure\Payment\StripePaymentGateway\StripePaymentGateway;
use App\Models\Cart\Cart\Cart;
use App\Models\Catalog\Category\Category;
use App\Models\Catalog\Meal\Meal;
use App\Models\Catalog\Subcategory\Subcategory;
use App\Models\Order\Order\Order;
use App\Models\User\Address\Address;
use App\Models\User\Favorite\Favorite;
use App\Observers\MealObserver;
use App\Policies\AddressPolicy\AddressPolicy;
use App\Policies\CartPolicy\CartPolicy;
use App\Policies\CategoryPolicy\CategoryPolicy;
use App\Policies\FavoritePolicy\FavoritePolicy;
use App\Policies\MealPolicy\MealPolicy;
use App\Policies\OrderPolicy\OrderPolicy;
use App\Policies\SubcategoryPolicy\SubcategoryPolicy;
use App\Services\Order\Payment\PaymentGatewayInterface\PaymentGatewayInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentGatewayInterface::class, StripePaymentGateway::class);
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Meal::class, MealPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Cart::class, CartPolicy::class);
        Gate::policy(Address::class, AddressPolicy::class);
        Gate::policy(Favorite::class, FavoritePolicy::class);
        Gate::policy(Subcategory::class, SubcategoryPolicy::class);

        Meal::observe(MealObserver\MealObserver::class);
    }
}
