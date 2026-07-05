<?php

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

if (!function_exists('get_cart_id')) {
    function get_cart_id()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = (string) Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 60 * 24 * 30);
        }
        return $cookie_id;
    }
}

if (!function_exists('total_price')) {
    function total_price()
    {
        $cookie_id = get_cart_id();

        return Cart::where('cookie_id', $cookie_id)
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')
            ->value('total') ?? 0;
    }
}

if (!function_exists('cart')) {
    function cart($var)
    {
        $cookie_id = get_cart_id();

        if ($var == 'count') {
            return Cart::where('cookie_id', $cookie_id)->count();
        }

        if ($var == 'all') {
            return Cart::where('cookie_id', $cookie_id)->get();
        }
    }
}