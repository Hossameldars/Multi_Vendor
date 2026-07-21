<?php
namespace App\Repository\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepostory implements CartRepostory
{
    public function get()
    {
        //  $cookie_id = get_cart_id();
         return Cart::where('cookie_id', $this->getcookie())->get();
    }

    public function add(Product $product, $quantity = 1) 
    {
    $cart=  Cart::where('product_id', $product->id)
        ->where('cookie_id',$this->getcookie())->first();;
          if (!$cart){
              return Cart::create([
            'cookie_id'  => $this->getcookie(),
            'user_id'    => Auth::id(),
            'product_id' => $product->id,
            'quantity'   => $quantity,
        ]);
          }
        return $cart->increment('quantity',$quantity);
      
    }

    public function update($id, $quantity)
    {
      return   Cart::where('id', $id)
        ->where('cookie_id',$this->getcookie())
        ->update(['quantity' => $quantity]);
    }

    public function delete( $product_id)
    {
      return  Cart::where('product_id', $product_id)
        ->where('cookie_id',$this->getcookie())
        ->delete();
    }

    public function empyt() {
        Cart::where('cookie_id', '=', $this->getcookie())->delete();
    }

    public function total() {
      
         return Cart::where('cookie_id','=',$this->getcookie())
         ->join('products','products.id','=','carts.product_id')
         ->selectRaw('SUM(products.price * carts.quantity) as total ')
         ->value('total');
    }
    public function getcookie()
    {
         $cookie_id= Cookie::get('cart_id');
         if(!$cookie_id)
          {
             $cookie_id=Str::uuid();
             Cookie::queue('cart_id',$cookie_id, 60 * 24 * 30);
          }
          return $cookie_id;
    }



}