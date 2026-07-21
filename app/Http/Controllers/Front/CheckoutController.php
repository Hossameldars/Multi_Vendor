<?php

namespace App\Http\Controllers\Front;
use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\AddressOrder;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\User;
use App\Notifications\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
   public function create()
   {
        $carts    = Cart::get();
        $subtotal = Cart::total();
          //   dd($carts);
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة');
        }
  
     return view('Front.checkout', compact('carts', 'subtotal'));
   }  
    public function store(Request $request)
{
    $carts = Cart::get();

    if ($carts->isEmpty()) {
        return redirect()->route('cart.index')
            ->with('error', 'السلة فارغة');
    }

    DB::transaction(function () use ($request, $carts) {

        $order = Order::create([
            'user_id'        => Auth::id(),
            'status'         => 'pending',
            'payment_status' => 'pending',
        ]);

        foreach ($carts as $cart) {

            ProductOrder::create([
                'order_id'     => $order->id,
                'product_id'   => $cart->product_id,
                'product_name' => $cart->product->name,
                'price'        => $cart->product->price,
                'quantity'     => $cart->quantity,
                'options'      => $cart->options,
                'store_id'     => $cart->product->store_id,
            ]);
        }

        AddressOrder::create([
            'order_id'       => $order->id,
            'type'           => 'billing',
            'first_name'     => $request->billing_first_name,
            'last_name'      => $request->billing_last_name,
            'email'          => $request->billing_email,
            'phone_number'   => $request->billing_phone_number,
            'street_address' => $request->billing_street_address,
            'city'           => $request->billing_city,
            'postal_code'    => $request->billing_postal_code,
            'state'          => $request->billing_state,
            'country'        => $request->billing_country,
        ]);

        if ($request->has('same_address')) {

            AddressOrder::create([
                'order_id'       => $order->id,
                'type'           => 'shiping',
                'first_name'     => $request->billing_first_name,
                'last_name'      => $request->billing_last_name,
                'email'          => $request->billing_email,
                'phone_number'   => $request->billing_phone_number,
                'street_address' => $request->billing_street_address,
                'city'           => $request->billing_city,
                'postal_code'    => $request->billing_postal_code,
                'state'          => $request->billing_state,
                'country'        => $request->billing_country,
            ]);

        } else {

            AddressOrder::create([
                'order_id'       => $order->id,
                'type'           => 'shiping',
                'first_name'     => $request->shipping_first_name,
                'last_name'      => $request->shipping_last_name,
                'email'          => $request->shipping_email,
                'phone_number'   => $request->shipping_phone_number,
                'street_address' => $request->shipping_street_address,
                'city'           => $request->shipping_city,
                'postal_code'    => $request->shipping_postal_code,
                'state'          => $request->shipping_state,
                'country'        => $request->shipping_country,
            ]);
        }

        //Cart::empyt();
        $storeid= $order->user->store_id;
        $users=User::where('store_id',$storeid)->get();
      //  Notification::send($users, new OrderShipped($order));
    });

    return redirect()
        ->route('createpay')
        ->with('success', 'تم إنشاء الطلب بنجاح');
} 
   
}
