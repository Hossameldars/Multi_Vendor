<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable= ['order_id','current_location','status'];
    public function Order()
    {
      return $this->belongsTo(Order::class);
    }
}
