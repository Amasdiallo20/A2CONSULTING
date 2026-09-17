<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image',
        'author',
        'price',
        'sale_price',
        'stock_quantity',
        'sku',
        'category_id',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'sale_price' => 'integer',
        'stock_quantity' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the shop product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function hasPromo(): bool
    {
        if ($this->sale_price === null || $this->sale_price === '') {
            return false;
        }

        $sale = (int) ($this->sale_price ?? 0);

        return $sale > 0 && $sale < (int) $this->price;
    }

    public function sellingPrice(): int
    {
        return $this->hasPromo() ? (int) $this->sale_price : (int) $this->price;
    }
}
