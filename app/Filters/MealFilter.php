<?php

namespace App\Filters;

class MealFilter extends QueryFilter
{
    /**
     * Only these request parameters are dispatched to filter methods.
     * Keeps the pre-existing title/description/is_available methods in the class
     * without allowing them to affect index() results.
     */
    protected array $allowed = [
        'search', 'category_id', 'subcategory_id',
        'featured', 'in_stock',
        'min_price', 'max_price', 'min_rating', 'brand',
    ];

    protected function filterableParameters(): array
    {
        return collect($this->request->keys())
            ->filter(fn (string $key) => in_array($key, $this->allowed, true) && method_exists($this, $key))
            ->mapWithKeys(fn (string $key) => [$key => $this->request->input($key)])
            ->all();
    }

    // ── Existing filters ────────────────────────────────────────────────────


    public function category_id($value): void
    {
        $this->builder->where('category_id', $value);
    }

    public function is_available($value): void
    {
        $this->builder->where('is_available', $value);
    }

    public function subcategory_id($value): void
    {
        $this->builder->where('subcategory_id', $value);
    }

    public function title($value): void
    {
        $this->builder->where('title', 'like', '%' . $value . '%');
    }

    public function description($value): void
    {
        $this->builder->where('description', 'like', '%' . $value . '%');
    }

    // ── New filters (moved from MealController::index()) ────────────────────

    /**
     * Full-text search across title and description.
     * Guards empty values to match the original $request->filled('search') check.
     */
    public function search(string $value): void
    {
        if (empty(trim($value))) {
            return;
        }

        $this->builder->where(function ($q) use ($value) {
            $q->where('title', 'like', "%{$value}%")
              ->orWhere('description', 'like', "%{$value}%");
        });
    }

    public function brand(string $value): void
    {
        $this->builder->where('brand', $value);
    }

    public function min_price($value): void
    {
        $this->builder->whereRaw('COALESCE(discount_price, price) >= ?', [$value]);
    }

    public function max_price($value): void
    {
        $this->builder->whereRaw('COALESCE(discount_price, price) <= ?', [$value]);
    }

    public function min_rating($value): void
    {
        $this->builder->where('rating', '>=', $value);
    }

    /**
     * Boolean filter. Uses filter_var to match $request->boolean() behaviour when
     * the pipeline passes raw string values ('0', '1', 'true', 'false').
     */
    public function featured($value): void
    {
        filter_var($value, FILTER_VALIDATE_BOOLEAN)
            ? $this->builder->featured()
            : $this->builder->where('is_featured', false);
    }

    public function in_stock($value): void
    {
        filter_var($value, FILTER_VALIDATE_BOOLEAN)
            ? $this->builder->inStock()
            : $this->builder->outOfStock();
    }
}
