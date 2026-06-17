@extends('layouts.Dashboard')

@section('title')
    Add New Product
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">Add New</li>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0">
        <div class="card-body px-4 py-4">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Product Name --}}
                <div class="mb-4">
                    <x-form.input
                        type="text"
                        name="name"
                        label="Product Name"
                        placeholder="Enter product name"
                    />
                </div>

                {{-- Store & Category --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="store_id" class="form-label">Store</label>
                        <select class="form-select @error('store_id') is-invalid @enderror"
                                id="store_id"
                                name="store_id">
                            <option value="">Select Store</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}"
                                        {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('store_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="catagory_id" class="form-label">Category</label>
                        <select class="form-select @error('catagory_id') is-invalid @enderror"
                                id="catagory_id"
                                name="catagory_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        {{ old('catagory_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('catagory_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <x-form.textarea
                        name="description"
                        label="Description"
                        placeholder="Enter product description"
                    />
                </div>

                {{-- Image --}}
                <div class="mb-4">
                    <x-form.input
                        type="file"
                        name="image"
                        label="Product Image"
                        onchange="previewImage(event)"
                    />
                    {{-- Image Preview --}}
                    <div class="mt-2">
                        <img id="image-preview"
                             src="#"
                             alt="Preview"
                             class="rounded border d-none"
                             style="max-height: 180px; object-fit: cover;">
                    </div>
                </div>

                {{-- Price & Compare Price --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <x-form.input
                            type="number"
                            name="price"
                            label="Price"
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                        />
                    </div>
                    <div class="col-md-6">
                        <x-form.input
                            type="number"
                            name="compare_price"
                            label="Compare Price (Original)"
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                        />
                        <small class="text-muted">Original price before discount</small>
                    </div>
                </div>

                {{-- Options (JSON) --}}
                <div class="mb-4">
                    <x-form.textarea
                        name="options"
                        label="Options (JSON)"
                        placeholder='e.g. {"colors": ["Red", "Blue"], "sizes": ["S", "M", "L"]}'
                    />
                    <small class="text-muted">Enter product variants in JSON format</small>
                </div>

                {{-- Featured & Status --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                id="status"
                                name="status">
                            <option value="active"    {{ old('status', 'active') == 'active'   ? 'selected' : '' }}>Active</option>
                            <option value="draft"     {{ old('status') == 'draft'              ? 'selected' : '' }}>Draft</option>
                            <option value="archived"  {{ old('status') == 'archived'           ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input @error('featured') is-invalid @enderror"
                                   type="checkbox"
                                   id="featured"
                                   name="featured"
                                   value="1"
                                   {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                Featured Product
                            </label>
                            @error('featured')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <a href="{{ route('products.index') }}" class="btn btn-light border">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <div>
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save"></i> Save Product
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const preview = document.getElementById('image-preview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        } else {
            preview.src = '#';
            preview.classList.add('d-none');
        }
    }
</script>
@endpush