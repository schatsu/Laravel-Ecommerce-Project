<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ProductFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function sort($value)
    {
        return match ($value) {
            'a-z' => $this->orderBy('name', 'asc'),
            'z-a' => $this->orderBy('name', 'desc'),
            'price-low-high' => $this->orderBy('selling_price', 'asc'),
            'price-high-low' => $this->orderBy('selling_price', 'desc'),
            'best-selling' => $this->orderBy('is_best_seller', 'desc')->orderBy('created_at', 'desc'),
            'featured' => $this->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc'),
            default => $this->orderBy('created_at', 'desc'),
        };
    }

    public function priceMin($value)
    {
        if ($value !== null && $value !== '') {
            return $this->where('selling_price', '>=', (float) $value);
        }
    }

    public function priceMax($value)
    {
        if ($value !== null && $value !== '') {
            return $this->where('selling_price', '<=', (float) $value);
        }
    }

    public function onSale($value)
    {
        if ($value) {
            return $this->where('discount_price', '>', 0);
        }
    }

    public function isNew($value)
    {
        if ($value) {
            return $this->where('is_new', true);
        }
    }

    public function isFeatured($value)
    {
        if ($value) {
            return $this->where('is_featured', true);
        }
    }

    public function isBestSeller($value)
    {
        if ($value) {
            return $this->where('is_best_seller', true);
        }
    }
}
