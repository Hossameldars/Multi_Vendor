<?php

namespace App\Http\Controllers\Front;

use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;


class PaymentController extends Controller
{  
  
    public $stripe;
  public function __construct()
    {

        $this->stripe = new StripeClient(
            config('services.stripe.secret_key')
        );
    }
    
public function createpay()
{
  $carts=Cart::get();
   $subtotal = Cart::total();

    return view('Front.Payment',compact('carts','subtotal'));
}
// public function pay()
// {
//     return view('Front.Payment');
// }
  public function payment(Request $request)
    { 
      $stripe = new StripeClient(
            config('services.stripe.secret_key')
        );
       $carts = Cart::get();

        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }
        $line_items = [];

        foreach ($carts as $cart) {
            if (!$cart->product) {
                continue;
            }

            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $cart->product->name,
                    ],
                    
                    'unit_amount' => (int) round($cart->product->price * 100),
                ],
                'quantity' => $cart->quantity,
            ];
        }

     if (empty($line_items)) {
            return redirect()->back()->with('error', 'No valid products in cart.');
        }

  
        $checkout_session = $this->stripe->checkout->sessions->create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.index'),
        ]);

        return redirect($checkout_session->url);
    }
       public function success(Request $request)
    {
        $session = $this->stripe->checkout->sessions->retrieve(
            $request->session_id
        );

        if ($session->payment_status == 'paid') {
                $order = Order::where('user_id', Auth::id())->latest()->first();
            Payment::create([
                'order_id' => $order->id, 
                'amount' => $session->amount_total / 100,
                'currency' => strtoupper($session->currency),
                'method' => 'stripe',
                'status' => 'completed',
                'transaction_id' => $session->payment_intent,
                'transaction_data' => json_encode($session),
            ]);
     Cart::empyt();
            return "Payment Successful";
        }
  
        return "Payment Failed";
    }
}

