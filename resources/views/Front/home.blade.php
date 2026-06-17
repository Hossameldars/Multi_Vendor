@extends('layouts.Front.app')

@section('title', 'ShopGrids - Home')

@section('content')

  {{-- Hero --}}
  <section class="hero-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-12 custom-padding-right">
          <div class="slider-head">
            <div class="hero-slider">
              <div class="single-slider" style="background-image: url({{ asset('assets/images/hero/slider-bg1.jpg') }});">
                <div class="content">
                  <h2><span>No restocking fee ($35 savings)</span> M75 Sport Watch</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                  <h3><span>Now Only</span> $320.99</h3>
                  <div class="button"><a href="product-grids.html" class="btn">Shop Now</a></div>
                </div>
              </div>
              <div class="single-slider" style="background-image: url({{ asset('assets/images/hero/slider-bg2.jpg') }});">
                <div class="content">
                  <h2><span>Big Sale Offer</span> Get the Best Deal on CCTV Camera</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                  <h3><span>Combo Only:</span> $590.00</h3>
                  <div class="button"><a href="product-grids.html" class="btn">Shop Now</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-12">
          <div class="row">
            <div class="col-lg-12 col-md-6 col-12 md-custom-padding">
              <div class="hero-small-banner"
                style="background-image: url('{{ asset('assets/images/hero/slider-bnr.jpg') }}');">
                <div class="content">
                  <h2><span>New line required</span> iPhone 12 Pro Max</h2>   
                  <h3>$259.99</h3>
                </div>
              </div>
            </div>
            <div class="col-lg-12 col-md-6 col-12">
              <div class="hero-small-banner style2">
                <div class="content">
                  <h2>Weekly Sale!</h2>
                  <p>Saving up to 50% off all online store items this week.</p>
                  <div class="button"><a class="btn" href="product-grids.html">Shop Now</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Start Trending Product Area -->
  <section class="trending-product section" style="margin-top: 12px;">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="section-title">
            <h2>Trending Product</h2>
            <p>There are many variations of passages of Lorem Ipsum available.</p>
          </div>
        </div>
      </div>
      <div class="row">
    
        @foreach ($products as $product)


          <div class="col-lg-3 col-md-6 col-12">
            <div class="single-product">
              <div class="product-image">

                <img
                  src="{{ $product->images ? asset('storage/' . $product->images->path) : asset('storage/Product/Noimage.webp')  }}"
                  alt="#">

                @if($product->discount_percentage > 0)
                  <span class="sale-tag">
                    {{ $product->discount_percentage }}% OFF
                  </span>
                @endif

                <div class="button">
                  <a href="product-details.html" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
                </div>
              </div>
              <div class="product-info">
                <span class="category">{{ $product->Category->name }} </span>
                <h4 class="title">
                  <a href="{{ route('showproduct', $product->slug) }}">
                    {{ $product->slug }}
                  </a>
                </h4>ِ
                <ul class="review">

                  <li><span>{{$product->description}} </span></li>
                </ul>
                <div class="price">
                  <span>{{ $product->price }}</span>
                  <span class="discount-price">{{ $product->compare_price }}</span>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Start Banner Area -->
  <section class="banner section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
          <div class="single-banner" style="background-image:url('{{ asset('assets/images/banner/banner-1-bg.jpg') }}')">
            <div class="content">
              <h2>Smart Watch 2.0</h2>
              <p>Space Gray Aluminum Case with Black/Volt Real Sport Band</p>
              <div class="button"><a href="product-grids.html" class="btn">View Details</a></div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
          <div class="single-banner custom-responsive-margin"
            style="background-image:url('{{ asset('assets/images/banner/banner-2-bg.jpg') }}')">
            <div class="content">
              <h2>Smart Headphone</h2>
              <p>Lorem ipsum dolor sit amet, eiusmod tempor incididunt ut labore.</p>
              <div class="button"><a href="product-grids.html" class="btn">Shop Now</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Start Shipping Info -->
  <section class="shipping-info">
    <div class="container">
      <ul>
        <li>
          <div class="media-icon"><i class="lni lni-delivery"></i></div>
          <div class="media-body">
            <h5>Free Shipping</h5><span>On order over $99</span>
          </div>
        </li>
        <li>
          <div class="media-icon"><i class="lni lni-support"></i></div>
          <div class="media-body">
            <h5>24/7 Support.</h5><span>Live Chat Or Call.</span>
          </div>
        </li>
        <li>
          <div class="media-icon"><i class="lni lni-credit-cards"></i></div>
          <div class="media-body">
            <h5>Online Payment.</h5><span>Secure Payment Services.</span>
          </div>
        </li>
        <li>
          <div class="media-icon"><i class="lni lni-reload"></i></div>
          <div class="media-body">
            <h5>Easy Return.</h5><span>Hassle Free Shopping.</span>
          </div>
        </li>
      </ul>
    </div>
  </section>


@endsection