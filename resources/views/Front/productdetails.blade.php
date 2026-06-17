@extends('layouts.Front.app')

@section('title', $product->name . ' - ShopGrids')

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ $product->name }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="#">Shop</a></li>
                        <li>{{ $product->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Product Details --}}
    <section class="product-details section">
      <form action="{{ route('cart.store') }}" method="post" >
        <div class="container">
            <div class="row">
      @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
                {{-- Product Image --}}
                <div class="col-lg-6 col-12">
                    <div class="product-images">
                        <div class="main-image">
                            <img id="main-product-image"
                                 src="{{ $product->images ? asset('storage/'.$product->images->path) : asset('storage/Product/Noimage.webp') }}"
                                 alt="{{ $product->name }}"
                                 class="img-fluid rounded"
                                 style="width: 100%; object-fit: cover; max-height: 450px;">
                        </div>
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="col-lg-6 col-12">
                    <div class="product-info" style="padding: 20px 0;">

                        {{-- Category --}}
                        <span class="category"
                              style="color: #888; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                            {{ $product->Category->name ?? '' }}
                        </span>

                        {{-- Name --}}
                        <h2 style="font-size: 28px; font-weight: 700; margin: 10px 0;">
                            {{ $product->name }}
                        </h2>

                        {{-- Status Badge --}}
                        <div class="mb-3">
                            @if($product->status == 'active')
                                <span class="badge bg-success">In Stock</span>
                            @elseif($product->status == 'draft')
                                <span class="badge bg-warning">Draft</span>
                            @else
                                <span class="badge bg-secondary">Archived</span>
                            @endif

                            @if($product->featured)
                                <span class="badge bg-primary ms-1">Featured</span>
                            @endif
                        </div>

                        {{-- Price --}}
                        <div class="price" style="margin: 15px 0;">
                            <span style="font-size: 28px; font-weight: 700; color: #081828;">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            @if($product->compare_price)
                                <span style="font-size: 18px; color: #888; text-decoration: line-through; margin-left: 10px;">
                                    ${{ number_format($product->compare_price, 2) }}
                                </span>
                                <span class="sale-tag ms-2"
                                      style="background: #f02d2d; color: #fff; padding: 3px 8px; border-radius: 4px; font-size: 13px;">
                                    -{{ $product->discount_percentage }}% OFF
                                </span>
                            @endif
                        </div>

                        <hr>

                        {{-- Description --}}
                        @if($product->description)
                            <div class="description mb-4">
                                <h5 style="font-weight: 600;">Description</h5>
                                <p style="color: #555; line-height: 1.8;">{{ $product->description }}</p>
                            </div>
                        @endif

                        {{-- Options --}}
                        @if($product->options)
                            @php $options = json_decode($product->options, true); @endphp
                            @if($options)
                                <div class="options mb-4">
                                    @foreach($options as $key => $values)
                                        <div class="mb-3">
                                            <h6 style="font-weight: 600; text-transform: capitalize;">{{ $key }}</h6>
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                @foreach($values as $value)
                                                    <button type="button"
                                                            class="btn btn-outline-secondary btn-sm option-btn"
                                                            onclick="selectOption(this)">
                                                        {{ $value }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif

                        {{-- Tags --}}
                        {{-- @if($product->Tags->count())
                            <div class="tags mb-4">
                                <h6 style="font-weight: 600;">Tags</h6>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach($product->Tags as $tag)
                                        <span class="badge bg-light text-dark border">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif --}}

                        <hr>

                        {{-- Quantity & Add to Cart --}}
                        <div class="add-to-cart d-flex align-items-center gap-3 mt-4">
                            <div class="quantity d-flex align-items-center border rounded"
                                 style="overflow: hidden;">
                                <button type="button"
                                        class="btn btn-light px-3"
                                        onclick="changeQty(-1)">-</button>
                                <input type="number"
                                       id="qty"
                                       name="quantity"
                                       value="1"
                                       min="1"
                                       class="form-control border-0 text-center"
                                       style="width: 60px;">
                                <button type="button"
                                        class="btn btn-light px-3"
                                        onclick="changeQty(1)">+</button>
                            </div>
                            <button class="btn btn-primary px-4 py-2" style="flex: 1;">
                                <i class="lni lni-cart me-2"></i> Add to Cart
                            </button>
                            <button class="btn btn-outline-danger px-3 py-2">
                                <i class="lni lni-heart"></i>
                            </button>
                        </div>

                        {{-- Store --}}
                        @if($product->Store)
                            <div class="mt-4">
                                <small class="text-muted">
                                    <i class="lni lni-home me-1"></i>
                                    Sold by: <strong>{{ $product->Store->name }}</strong>
                                </small>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>

    {{-- Related Products --}}
    @if($related->count())
    <section class="trending-product section" style="background: #f9f9f9; padding: 60px 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Related Products</h2>
                        <p>You might also like these products.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($related as $item)
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-product">
                        <div class="product-image">
                            <img src="{{ $item->images ? asset('storage/'.$item->images->path) : asset('storage/Product/Noimage.webp') }}"
                                 alt="{{ $item->name }}">
                            @if($item->discount_percentage > 0)
                                <span class="sale-tag">-{{ $item->discount_percentage }}%</span>
                            @endif
                            <div class="button">
                                <a href="{{ route('products.show', $item->slug) }}" class="btn">
                                    <i class="lni lni-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="category">{{ $item->Category->name ?? '' }}</span>
                            <h4 class="title">
                                <a href="{{ route('products.show', $item->slug) }}">{{ $item->name }}</a>
                            </h4>
                            <div class="price">
                                <span>${{ number_format($item->price, 2) }}</span>
                                @if($item->compare_price)
                                    <span class="discount-price">${{ number_format($item->compare_price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection

@push('scripts')
<script>
    function changeQty(val) {
        const input = document.getElementById('qty');
        const newVal = parseInt(input.value) + val;
        if (newVal >= 1) input.value = newVal;
    }

    function selectOption(btn) {
        const group = btn.closest('.d-flex');
        group.querySelectorAll('.option-btn').forEach(b => {
            b.classList.remove('btn-dark');
            b.classList.add('btn-outline-secondary');
        });
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-dark');
    }
</script>
@endpush