<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order
 extends Model
{
    protected $fillable = [
        'user_id',
        'number',
        'status',
        'payment_status',
    ];

    protected $casts = [
        'status' => 'string',
        'payment_status' => 'string',
    ];

    const STATUSES = ['pending', 'procssing', 'delvering', 'completed', 'cancelled', 'refunded'];
    const PAYMENT_STATUSES = ['pending', 'paid', 'failed'];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(['name'=>'Gast customer']);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function productOrders(): HasMany
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(AddressOrder::class);
    }
    protected static function booted()
    {
      static::creating(function(Order $order)
      {
       $order->number=  Order::Getnextordernumber();
      });
    }
    public static function Getnextordernumber()
    {
   $year=Carbon::now()->year;
            $number=Order::whereYear('created_at',$year)->max('number');
            if($number){
                  return  $number+1;
            }
            return $year.'0001';
    }
    public function Products()
    {
        return $this->belongsToMany(Product::class,'product_orders','order_id','product_id','id','id');
    }

    public function billingAddress(): HasMany
    {
        return $this->hasMany(AddressOrder::class)->where('type', 'billing');
    }

    public function shippingAddress(): HasMany
    {
        return $this->hasMany(AddressOrder::class)->where('type', 'shiping');
    }
}