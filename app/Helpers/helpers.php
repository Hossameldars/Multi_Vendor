<?php 

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
if (!function_exists('total_price')) {
   function total_price() {
            $cookie_id= Cookie::get('cart_id');
         if(!$cookie_id)
          {
             $cookie_id=Str::uuid();
             Cookie::queue('cart_id',$cookie_id, 60 * 24 * 30);
          }
        
         return Cart::where('cookie_id','=',$cookie_id)
         ->join('products','products.id','=','carts.product_id')
         ->selectRaw('SUM(products.price * carts.quantity) as total ')
         ->value('total');
    }
}
if (!function_exists('cart')) {
   function cart($var) {
    if($var=='count'){
        return Cart::count();
    }
    if($var=='all'){
        return Cart::all();
    }
        
    }
}
