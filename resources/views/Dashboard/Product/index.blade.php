@extends('layouts.Dashboard')

@section('title')
    Products
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center">
  
    <div>
        {{-- <a href="{{ route('products.archive') }}" class="btn btn-secondary me-2">
            <i class="fas fa-archive"></i> Archived
        </a> --}}
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Product
        </a>
    </div>
</div>
        </div>
    </div>
    {{-- search  --}}
    <div class="row mb-3">
    <div class="col-md-4">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="input-group">
            
                         <x-form.input 
                         type="text"
                        name="name"
                      value="{{ request('name') }}"
                           placeholder="Search by name..." />
                       <br>
                       
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"> search</i>
                </button>
            </div>
        </form>
    </div>
</div>
    {{-- end search --}}

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th style="width: 25%">Image</th>
                                        <th style="width: 25%">Name</th>
                                        <th style="width: 25%">Catagory</th>
                                        <th style="width: 25%">store</th>
                                        <th style="width: 15%">Status</th>
                                        {{-- <th style="width: 20%">Parent Category</th> --}}
                                        <th style="width: 20%">Created At</th>
                                        <th style="width: 15%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                                      
                                                 <td>
                                            @if ($product->images)
                                       <img src="{{asset('storage/'.$product->images->path) }}" 
                                                 alt="product Image" 
                                              class="img-fluid rounded-circle" 
                                                   style="width: 50px; height: 50px;">
                                                          @endif
                                                 </td>
                                            <td>
                                                <strong>{{ $product->name }}</strong>
                                            </td>
                                        
                                            <td>
                                                @if($product->Category)
                                                    <span class="badge bg-secondary">
                                                        {{ $product->Category->name }}
                                                    </span>
                                            @endif
                                            </td>
                                              <td>
                                                @if($product->Store)
                                                    <span class="badge bg-secondary">
                                                        {{ $product->Store->name }}
                                                    </span>
                                                    @endif
                                              
                                            </td>
                                                <td>
                                                @if($product->status == 'active')
                                                 <span class="badge bg-success">Active</span>
                                                     @else
                                                        <span class="badge bg-danger">Archived</span>
                                                  @endif
                                                       </td>
                                            <td>{{ $product->created_at->format('Y-m-d H:i') }}</td>
                                            <td class="text-center">
                                            <div class="btn-group action-buttons" role="group">

    <a href="{{ route('products.edit', $product->id) }}" 
       class="btn btn-sm btn-edit" 
       title="Edit">
        <i class="fas fa-pen-to-square me-1"></i>
        Edit
    </a>

    <form action="{{ route('products.destroy', $product->id) }}" 
          method="POST" 
          class="d-inline"
          onsubmit="return confirm('Are you sure you want to delete this product?')">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="btn btn-sm btn-delete" 
                title="Delete">
            <i class="fas fa-trash me-1"></i>
            Delete
        </button>
    </form>

</div>

                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                          
    {{ $products->withQueryString()->links() }}

                        </div>

                      
                    @else
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p class="mb-0">No products found. 
                               
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }
    .btn-group .btn {
        margin: 0 2px;
    }
    html, body {
    height: 100%;
}
.wrapper {
    min-height: 100vh;
}
/* تحسين شكل أزرار الأكشن */
.action-buttons .btn {
    border-radius: 8px;
    padding: 5px 12px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.3s ease;
}

/* زر التعديل */
.btn-edit {
    background-color: #ffc107;
    color: #000;
    border: none;
}

.btn-edit:hover {
    background-color: #e0a800;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

/* زر الحذف */
.btn-delete {
    background-color: #dc3545;
    color: #fff;
    border: none;
}

.btn-delete:hover {
    background-color: #bb2d3b;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}
.btn-edit {
    background-color: #ffc107 !important;
    color: #000 !important;
    border: none !important;
}

.btn-delete {
    background-color: #dc3545 !important;
    color: #fff !important;
    border: none !important;
}
</style>
@endpush