<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
// use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('Front.home', compact('products'));
    }
    public function showproduct($slug)
    {
     $product= Product::where('slug',$slug)->first();
  
     $related = Product::where('catagory_id', $product->catagory_id )
                      ->where('id', '!=', $product->id)
                      ->limit(4)
                      ->get();
                      // dd($related);
      return view('Front.productdetails',compact('product','related'));
    }
}
