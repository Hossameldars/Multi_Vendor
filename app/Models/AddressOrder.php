<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddressOrder extends Model
{
    protected $table = 'address_orders';

    protected $fillable = [
        'order_id',
        'type',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'street_address',
        'city',
        'postal_code',
        'state',
        'country',
    ];

    const TYPES = ['billing', 'shiping'];

    /*------- Relationships -------*/

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /*------- Helpers -------*/

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}