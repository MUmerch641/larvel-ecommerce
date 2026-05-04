<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price_cents',
        'sku',
        'is_active',
        'stock',
        'featured_image_path',
    ];

    protected $casts = [
        'is_active' => 'bool',
        'price_cents' => 'int',
        'stock' => 'int',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getPriceFormattedAttribute(): string
    {
        return '$' . number_format($this->price_cents / 100, 2);
    }
}
