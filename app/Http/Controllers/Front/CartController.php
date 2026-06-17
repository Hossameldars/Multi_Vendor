<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Repository\Cart\CartModelRepostory;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartModelRepostory $repository) {}

    public function index()
    {
        $carts    = $this->repository->get();
        $subtotal = $this->repository->total();

        return view('Front.cart', compact('carts', 'subtotal'));
    }                                                                       
           
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['nullable', 'integer', 'min:1'],
        ]);

        $product  = Product::findOrFail($request->product_id);
        $quantity = (int) ($request->quantity ?? 1);

        $this->repository->add($product, $quantity);

        return redirect()->route('cart.index')->with('success', 'تمت الإضافة للسلة');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $request->quantity;

        $this->repository->update($cart->id, $quantity);

        return response()->json([
            'success'   => true,
            'quantity'  => $quantity,
            'row_total' => number_format($cart->product->price * $quantity, 2),
            'subtotal'  => number_format($this->repository->total(), 2),
        ]);
    }

    public function destroy(Cart $cart)
    {
        $this->repository->delete($cart->product_id);

        return redirect()->route('cart.index')->with('success', 'تم الحذف من السلة');
    }
    public function empty()
    {
        $this->repository->empyt();

        return redirect()->route('cart.index')->with('success', 'تم تفريغ السلة');
    }

  
    public function total()
    {
        $total = $this->repository->total();

        return response()->json([
            'total' => number_format($total, 2),
        ]);
    }
}