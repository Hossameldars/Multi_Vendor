@extends('layouts.Front.app')

@section('title', 'ShopGrids - Shopping Cart')

@push('css')
<link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
  .qty-input {
    width: 65px;
    text-align: center;
    border: 1px solid #ddd;
    padding: 5px 4px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 14px;
    transition: border-color 0.2s;
  }
  .qty-input:focus        { outline: none; border-color: #e74c3c; }
  .qty-input.saving       { border-color: #f39c12; background: #fffbf0; }
  .qty-input.saved        { border-color: #27ae60; background: #f0fff4; }

  .loading-row td         { opacity: 0.5; pointer-events: none; }
  .cart-row               { transition: opacity 0.3s; }

  #cart-toast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    padding: 12px 20px;
    border-radius: 6px;
    color: #fff;
    font-size: 14px;
    display: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }
  #cart-toast.success { background: #27ae60; }
  #cart-toast.error   { background: #e74c3c; }
</style>
@endpush

@section('content')

{{-- Toast --}}
<div id="cart-toast"></div>

{{-- Breadcrumb --}}
<div class="breadcrumbs">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-md-6 col-12">
        <div class="breadcrumbs-content">
          <h1 class="page-title">Shopping Cart</h1>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-12">
        <ul class="breadcrumb-nav">
          <li><a href="{{ url('/') }}">Home</a></li>
          <li>Shopping Cart</li>
        </ul>
      </div>
    </div>
  </div>
</div>

{{-- Cart Section --}}
<section class="shopping-cart section">
  <div class="container">

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($carts->isEmpty())
      <div class="row" id="empty-cart-msg">
        <div class="col-12 text-center" style="padding:60px 0;">
          <i class="lni lni-cart" style="font-size:60px; color:#ccc;"></i>
          <h3 style="margin-top:20px;">Your cart is empty</h3>
          <p>Browse our products and add items to your cart.</p>
          <a href="{{ url('/') }}" class="btn" style="margin-top:16px;">Shop Now</a>
        </div>
      </div>

    @else
      <div class="row" id="cart-wrapper">

        {{-- جدول المنتجات --}}
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
                  <th>Remove</th>
                </tr>
              </thead>
              <tbody id="cart-tbody">
@foreach($carts as $cart)
    @if($cart->product)
    <tr class="cart-row" id="cart-row-{{ $cart->id }}">

        {{-- صورة --}}
        <td class="image">
            <img
              src="{{ $cart->product->images && $cart->product->images->count() > 0
                      ? asset('storage/' . $cart->product->images->first()->path)
                      : asset('storage/Product/Noimage.webp') }}"
              alt="{{ $cart->product->name }}"
              style="width:70px;height:70px;object-fit:cover;border-radius:6px;">
        </td>

        {{-- اسم المنتج --}}
        <td class="name">
            <a href="{{ route('showproduct', $cart->product->slug) }}">
                {{ $cart->product->name }}
            </a>
            <span style="display:block;font-size:12px;color:#888;">
                {{ $cart->product->category->name ?? '' }}
            </span>
        </td>

        {{-- السعر --}}
        <td class="price">
            <span>${{ number_format($cart->product->price, 2) }}</span>
            @if($cart->product->compare_price)
              <del style="font-size:12px;color:#aaa;">
                  ${{ number_format($cart->product->compare_price, 2) }}
              </del>
            @endif
        </td>

        <td class="quantity">
            <input
              type="number"
              class="qty-input"
              id="qty-{{ $cart->id }}"
              value="{{ $cart->quantity }}"
              min="1"
              data-id="{{ $cart->id }}"
              data-old="{{ $cart->quantity }}"
              data-price="{{ $cart->product->price }}"
            >
        </td>

        {{-- إجمالي الصف --}}
        <td class="total-price" id="row-total-{{ $cart->id }}">
            ${{ number_format($cart->product->price * $cart->quantity, 2) }}
        </td>

        {{-- حذف --}}
        <td class="action">
            <form class="form-delete"
                  action="{{ route('cart.destroy', $cart->id) }}"
                  method="POST"
                  data-id="{{ $cart->id }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="remove"
                        style="background:none;border:none;cursor:pointer;"
                        title="Remove">
                    <i class="lni lni-close"></i>
                </button>
            </form>
        </td>

    </tr>
    @endif
@endforeach
              </tbody>
            </table>
          </div>

          <div style="margin-top:16px;">
            <a href="{{ url('/') }}" class="btn">← Continue Shopping</a>
          </div>
        </div>

        {{-- ملخص الطلب --}}
        <div class="col-lg-4 col-12">
          <div class="cart-total"
               style="background:#f9f9f9;padding:24px;border-radius:8px;border:1px solid #eee;">

            <h5 style="border-bottom:2px solid #e74c3c;padding-bottom:10px;display:inline-block;">
              Order Summary
            </h5>

            <ul style="list-style:none;padding:0;margin-top:16px;">

              <li style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee;">
                <span>Subtotal</span>
                <span id="subtotal-price">${{ number_format($subtotal, 2) }}</span>
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
                <span id="total-price">${{ number_format($subtotal, 2) }}</span>
              </li>

            </ul>

            <a href="{{route('checkout.create')}}" class="btn"
               style="width:100%;text-align:center;background:#e74c3c;color:#fff;">
              Proceed to Checkout
            </a>

          </div>
        </div>

      </div>
    @endif

  </div>
</section>

@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  const timers = {};

  function showToast(msg, type = 'success') {
    const toast = document.getElementById('cart-toast');
    toast.textContent = msg;
    toast.className = type;
    toast.style.display = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 3000);
  }

  function updateSummary(subtotal) {
    document.getElementById('subtotal-price').textContent = '$' + subtotal;
    document.getElementById('total-price').textContent = '$' + subtotal;
  }

  document.querySelectorAll('.qty-input').forEach(function (input) {
    input.addEventListener('input', function () {

      const cartId = this.dataset.id;
      const qty = parseInt(this.value);
      const row = document.getElementById('cart-row-' + cartId);

      if (isNaN(qty) || qty < 1) return;

      input.classList.remove('saved');
      input.classList.add('saving');

      clearTimeout(timers[cartId]);

      timers[cartId] = setTimeout(() => {

        if (qty === parseInt(input.dataset.old)) {
          input.classList.remove('saving');
          return;
        }

        row.classList.add('loading-row');

        fetch(`/cart/${cartId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
          },
          body: JSON.stringify({ quantity: qty }),
        })
        .then(res => res.json())
        .then(data => {

          input.dataset.old = data.quantity;
          input.value = data.quantity;

          input.classList.remove('saving');
          input.classList.add('saved');
          setTimeout(() => input.classList.remove('saved'), 2000);

          document.getElementById('row-total-' + cartId).textContent = '$' + data.row_total;
          updateSummary(data.subtotal);

          showToast('Quantity updated ✓');

        })
        .catch(() => {
          input.value = input.dataset.old;
          input.classList.remove('saving');
          showToast('Error', 'error');
        })
        .finally(() => {
          row.classList.remove('loading-row');
        });

      }, 800);

    });
  });

});
</script>

<!-- سكربت منفصل -->
<script>
window.addEventListener('error', function(e) {
  if (e.filename && e.filename.includes('tiny-slider')) {
    e.preventDefault();
  }
}, true);
</script>
@endpush
