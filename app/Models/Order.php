<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'subtotal_cents',
        'shipping_cents',
        'total_cents',
        'payment_method',
        'shipping_name',
        'shipping_phone',
        'shipping_line1',
        'shipping_line2',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
        'placed_at',
    ];

    protected $casts = [
        'subtotal_cents' => 'int',
        'shipping_cents' => 'int',
        'total_cents' => 'int',
        'placed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalFormattedAttribute(): string
    {
        return '$' . number_format($this->total_cents / 100, 2);
    }
}
