<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOrder extends Model
{
    protected $table = 'product_orders';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
        'options',
        'store_id'
    ];

    protected $casts = [
        'options'  => 'array',   
        'price'    => 'float',
        'quantity' => 'integer',
    ];

    /*------- Relationships -------*/

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /*------- Helpers -------*/

    public function getSubtotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }
}