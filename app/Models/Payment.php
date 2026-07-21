<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'currency',
        'status',
        'method',
        'transaction_id',
        'transaction_data',
    ];

    protected $casts = [
        'amount' => 'float',
        'transaction_data' => 'array',
    ];

    /**
     * العلاقة مع جدول orders
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}