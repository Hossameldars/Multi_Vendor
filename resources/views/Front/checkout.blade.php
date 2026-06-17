{{-- resources/views/Front/checkout.blade.php --}}

@extends('layouts.Front.app')

@section('title', 'Checkout')

@section('content')

<div class="checkout-wrapper section">
  <div class="container">
    <form action="{{ route('checkout.store') }}" method="POST">
      @csrf

      <div class="row">

        {{-- ===== Billing Address ===== --}}
        <div class="col-lg-8 col-12">

          <div class="checkout-steps-form-style-1">
            <ul id="accordion">

              {{-- Billing --}}
              <li>
                <h6 class="title" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                  Billing Address <span><i class="lni lni-chevron-down"></i></span>
                </h6>
                <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                  <div class="checkout-steps-form-content">
                    <div class="row g-3">

                      <div class="col-md-6">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" name="billing_first_name"
                               value="{{ old('billing_first_name', Auth::user()?->name) }}"
                               class="form-control @error('billing_first_name') is-invalid @enderror">
                        @error('billing_first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-6">
                        <label>Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="billing_last_name"
                               value="{{ old('billing_last_name') }}"
                               class="form-control @error('billing_last_name') is-invalid @enderror">
                        @error('billing_last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="billing_email"
                               value="{{ old('billing_email', Auth::user()?->email) }}"
                               class="form-control @error('billing_email') is-invalid @enderror">
                        @error('billing_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-6">
                        <label>Phone <span class="text-danger">*</span></label>
                        <input type="text" name="billing_phone_number"
                               value="{{ old('billing_phone_number') }}"
                               class="form-control @error('billing_phone_number') is-invalid @enderror">
                        @error('billing_phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-12">
                        <label>Street Address <span class="text-danger">*</span></label>
                        <input type="text" name="billing_street_address"
                               value="{{ old('billing_street_address') }}"
                               class="form-control @error('billing_street_address') is-invalid @enderror">
                        @error('billing_street_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-4">
                        <label>City <span class="text-danger">*</span></label>
                        <input type="text" name="billing_city"
                               value="{{ old('billing_city') }}"
                               class="form-control @error('billing_city') is-invalid @enderror">
                        @error('billing_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-4">
                        <label>State</label>
                        <input type="text" name="billing_state"
                               value="{{ old('billing_state') }}"
                               class="form-control">
                      </div>

                      <div class="col-md-4">
                        <label>Postal Code</label>
                        <input type="text" name="billing_postal_code"
                               value="{{ old('billing_postal_code') }}"
                               class="form-control">
                      </div>

                      <div class="col-md-6">
                        <label>Country <span class="text-danger">*</span></label>
                        <input type="text" name="billing_country" maxlength="2"
                               placeholder="EG"
                               value="{{ old('billing_country', 'EG') }}"
                               class="form-control @error('billing_country') is-invalid @enderror">
                        @error('billing_country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      {{-- Checkbox نفس عنوان الشحن --}}
                      <div class="col-12">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox"
                                 name="same_address" id="sameAddress" value="1"
                                 {{ old('same_address') ? 'checked' : '' }}
                                 onchange="toggleShipping(this)">
                          <label class="form-check-label" for="sameAddress">
                            Shipping address same as billing
                          </label>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </li>

              {{-- Shipping --}}
              <li id="shippingSection">
                <h6 class="title" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                  Shipping Address <span><i class="lni lni-chevron-down"></i></span>
                </h6>
                <div id="collapseTwo" class="collapse show" data-bs-parent="#accordion">
                  <div class="checkout-steps-form-content">
                    <div class="row g-3">

                      <div class="col-md-6">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_first_name"
                               value="{{ old('shipping_first_name') }}"
                               class="form-control @error('shipping_first_name') is-invalid @enderror">
                        @error('shipping_first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-6">
                        <label>Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_last_name"
                               value="{{ old('shipping_last_name') }}"
                               class="form-control @error('shipping_last_name') is-invalid @enderror">
                        @error('shipping_last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="shipping_email"
                               value="{{ old('shipping_email') }}"
                               class="form-control">
                      </div>

                      <div class="col-md-6">
                        <label>Phone <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_phone_number"
                               value="{{ old('shipping_phone_number') }}"
                               class="form-control @error('shipping_phone_number') is-invalid @enderror">
                        @error('shipping_phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-12">
                        <label>Street Address <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_street_address"
                               value="{{ old('shipping_street_address') }}"
                               class="form-control @error('shipping_street_address') is-invalid @enderror">
                        @error('shipping_street_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-4">
                        <label>City <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_city"
                               value="{{ old('shipping_city') }}"
                               class="form-control @error('shipping_city') is-invalid @enderror">
                        @error('shipping_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-4">
                        <label>State</label>
                        <input type="text" name="shipping_state"
                               value="{{ old('shipping_state') }}"
                               class="form-control">
                      </div>

                      <div class="col-md-4">
                        <label>Postal Code</label>
                        <input type="text" name="shipping_postal_code"
                               value="{{ old('shipping_postal_code') }}"
                               class="form-control">
                      </div>

                      <div class="col-md-6">
                        <label>Country <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_country" maxlength="2"
                               placeholder="EG"
                               value="{{ old('shipping_country', 'EG') }}"
                               class="form-control @error('shipping_country') is-invalid @enderror">
                        @error('shipping_country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                    </div>
                  </div>
                </div>
              </li>

            </ul>
          </div>

        </div>

        {{-- ===== Order Summary ===== --}}
        <div class="col-lg-4 col-12">
          <div class="checkout-sidebar">

            <div class="checkout-sidebar-price-table mt-30">
              <h5 class="title">Order Summary</h5>

              @foreach ($carts as $cart)
                <div class="sub-total-price d-flex justify-content-between">
                  <span class="total-title">
                    {{ $cart->product->name }}
                    <small class="text-muted">x{{ $cart->quantity }}</small>
                  </span>
                  <span class="total-amount">
                    ${{ number_format($cart->product->price * $cart->quantity, 2) }}
                  </span>
                </div>
              @endforeach

              <div class="sub-total-price d-flex justify-content-between border-top pt-2 mt-2">
                <span class="total-title fw-bold">Subtotal</span>
                <span class="total-amount fw-bold">${{ number_format($subtotal, 2) }}</span>
              </div>

              <div class="total-price d-flex justify-content-between mt-2">
                <span class="total-title fw-bold fs-5">Total</span>
                <span class="total-amount fw-bold fs-5 text-primary">
                  ${{ number_format($subtotal, 2) }}
                </span>
              </div>

              <div class="payment-method mt-4">
                <h5 class="title">Payment Method</h5>
                <div class="form-check">
                  <input class="form-check-input" type="radio"
                         name="payment_method" id="cod" value="cod" checked>
                  <label class="form-check-label" for="cod">
                    Cash on Delivery
                  </label>
                </div>
              </div>

              <div class="button mt-3">
                <button type="submit" class="btn w-100">
                  Place Order
                </button>
              </div>

            </div>

          </div>
        </div>

      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  function toggleShipping(checkbox) {
    const section = document.getElementById('shippingSection');
    section.style.display = checkbox.checked ? 'none' : 'block';
  }

  // لو الصفحة اتحملت والـ checkbox متحدد
  document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('sameAddress');
    if (checkbox.checked) toggleShipping(checkbox);
  });
</script>
@endpush

@endsection