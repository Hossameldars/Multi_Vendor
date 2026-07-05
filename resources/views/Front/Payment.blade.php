@extends('layouts.Front.app')

@section('title', 'ShopGrids - Checkout')

@push('css')
<link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumbs">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-md-6 col-12">
        <div class="breadcrumbs-content">
          <h1 class="page-title">Checkout</h1>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-12">
        <ul class="breadcrumb-nav">
          <li><a href="{{ url('/') }}">Home</a></li>
          <li>Checkout</li>
        </ul>
      </div>
    </div>
  </div>
</div>

{{-- Checkout Section --}}
<section class="shopping-cart section">
  <div class="container">

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($carts->isEmpty())
      <div class="row">
        <div class="col-12 text-center" style="padding:60px 0;">
          <i class="lni lni-cart" style="font-size:60px; color:#ccc;"></i>
          <h3 style="margin-top:20px;">Your cart is empty</h3>
          <p>Add some products before checking out.</p>
          <a href="{{ url('/') }}" class="btn" style="margin-top:16px;">Shop Now</a>
        </div>
      </div>

    @else
      <div class="row">

        {{-- جدول المنتجات (عرض فقط) --}}
        <div class="col-lg-8 col-12">
          <div class="table-responsive">
            <table class="table shopping-summery">
              <thead>
                <tr class="main-heading">
                  <th>Image</th>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach($carts as $cart)
                  @if($cart->product)
                  <tr>
                      <td class="image">
                          <img
                            src="{{ $cart->product->images && $cart->product->images->count() > 0
                                    ? asset('storage/' . $cart->product->images->first()->path)
                                    : asset('storage/Product/Noimage.webp') }}"
                            alt="{{ $cart->product->name }}"
                            style="width:70px;height:70px;object-fit:cover;border-radius:6px;">
                      </td>

                      <td class="name">
                          {{ $cart->product->name }}
                          <span style="display:block;font-size:12px;color:#888;">
                              {{ $cart->product->category->name ?? '' }}
                          </span>
                      </td>

                      <td class="price">
                          ${{ number_format($cart->product->price, 2) }}
                      </td>

                      <td class="quantity">
                          {{ $cart->quantity }}
                      </td>

                      <td class="total-price">
                          ${{ number_format($cart->product->price * $cart->quantity, 2) }}
                      </td>
                  </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        {{-- ملخص الطلب + زرار Payment --}}
        <div class="col-lg-4 col-12">
          <div class="cart-total"
               style="background:#f9f9f9;padding:24px;border-radius:8px;border:1px solid #eee;">

            <h5 style="border-bottom:2px solid #e74c3c;padding-bottom:10px;display:inline-block;">
              Order Summary
            </h5>

            <ul style="list-style:none;padding:0;margin-top:16px;">

              <li style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee;">
                <span>Subtotal</span>
                {{-- <span>${{ number_format($subtotal, 2) }}</span> --}}
              </li>

              @if(isset($discount) && $discount > 0)
              <li style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee;">
                <span>Discount</span>
                <span style="color:#e74c3c;">− ${{ number_format($discount, 2) }}</span>
              </li>
              @endif

              <li style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee;">
                <span>Shipping</span>
                <span style="color:green;">Free</span>
              </li>

              <li style="display:flex;justify-content:space-between;padding:12px 0;font-weight:600;font-size:16px;">
                <span>Total</span>
                <span>${{ number_format($subtotal, 2) }}</span>
              </li>

            </ul>

            {{-- زرار Payment فقط --}}
            <form action="{{ route('pay') }}" method="POST">
                @csrf
                <button type="submit" class="btn"
                        style="width:100%;text-align:center;background:#e74c3c;color:#fff;border:none;padding:12px;border-radius:6px;cursor:pointer;">
                    Payment
                </button>
            </form>

          </div>
        </div>

      </div>
    @endif

  </div>
</section>

@endsection