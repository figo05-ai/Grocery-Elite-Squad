<?php

namespace App\Services;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Collection;
use App\Filters\MealFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
 use App\Http\Resources\MealResource;

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
    public function brands(): Collection
{
    return Meal::distinct()
        ->pluck('brand');
}
   public function allMeals(Request $request): Collection
{
    $query = Meal::with([
        'category',
        'subcategory',
    ])->available();

    $filter = new MealFilter($request);

    $filter->apply($query);

    return $query->get();
}
}
