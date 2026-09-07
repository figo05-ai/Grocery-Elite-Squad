<?php

namespace App\Services;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Collection;

class MealService
{
    /**
     * Get latest meals.
     */
    public function sliderMeals(): Collection
    {
        return Meal::with('category')
            ->available()
            ->latest()
            ->get();
    }

    /**
     * Get newest products.
     */
    public function newProducts(): Collection
    {
        return Meal::with('category')
            ->available()
            ->latest()
            ->get();
    }

    /**
     * Get best selling meals.
     */
    public function bestSells(): Collection
    {
        return Meal::with('category')
            ->available()
            ->orderByDesc('sold_count')
            ->take(10)
            ->get();
    }

    /**
     * Get hot meals.
     */
    public function hotMeals(): Collection
    {
        return Meal::with('category')
            ->available()
            ->hot()
            ->latest()
            ->get();
    }

    /**
     * Get today's deals.
     */
    public function todayDeals(): Collection
    {
        return Meal::with('category')
            ->available()
            ->withActiveDiscount()
            ->latest()
            ->get();
    }

    /**
     * Get more to explore meals.
     */
    public function moreToExplore(): Collection
    {
        return Meal::with('category')
            ->available()
            ->latest()
            ->get();
    }

    /**
     * Get available brands.
     */
    public function brands()
    {
        return Meal::distinct()
            ->pluck('brand');
    }
}
