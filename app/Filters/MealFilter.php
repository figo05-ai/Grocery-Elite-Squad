<?php

namespace App\Filters;

class MealFilter extends QueryFilter
{
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
        $this->builder->where('title', 'like', '%'.$value.'%');
    }

    public function description($value): void
    {
        $this->builder->where('description', 'like', '%'.$value.'%');
    }
    public function brand($value): void
{
    $this->builder->where('brand', $value);
}

public function featured($value): void
{
    if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
        $this->builder->featured();
    } else {
        $this->builder->where('is_featured', false);
    }
}

public function in_stock($value): void
{
    if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
        $this->builder->inStock();
    } else {
        $this->builder->outOfStock();
    }
}

public function min_price($value): void
{
    $this->builder->whereRaw(
        'COALESCE(discount_price, price) >= ?',
        [$value]
    );
}

public function max_price($value): void
{
    $this->builder->whereRaw(
        'COALESCE(discount_price, price) <= ?',
        [$value]
    );
}

public function min_rating($value): void
{
    $this->builder->where('rating', '>=', $value);
}
    public function search($value): void
{
    $this->builder->where(function ($query) use ($value) {
        $query->where('title', 'like', "%{$value}%")
              ->orWhere('description', 'like', "%{$value}%");
    });
}
    public function sort_by($value): void
{
    $order = request()->input('sort_order', 'desc');

    if ($value === 'newest') {
        $this->builder->latest();
        return;
    }

    if ($value === 'price') {
        $this->builder->orderByRaw(
            'COALESCE(discount_price, price) '.$order
        );

        return;
    }

    if (in_array($value, [
        'created_at',
        'rating',
        'title',
        'sold_count',
    ])) {
        $this->builder->orderBy($value, $order);
    }
}
    
}
