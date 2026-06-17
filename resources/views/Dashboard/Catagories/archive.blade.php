@extends('layouts.Dashboard')

@section('title') Archived Categories @endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Archived</li>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2><i class="fas fa-archive me-2 text-secondary"></i>Archived Categories</h2>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Categories
                </a>
            </div>
        </div>
    </div>

    {{-- Search --}}
    

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($Catagories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th style="width: 20%">Image</th>
                                        <th style="width: 20%">Name</th>
                                        <th style="width: 15%">Status</th>
                                        <th style="width: 15%">Parent Category</th>
                                        <th style="width: 15%">Deleted At</th>
                                        <th style="width: 10%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Catagories as $Catagorie)
                                        <tr class="table-warning">
                                            <td>{{ $Catagorie->id }}</td>
                                            <td>
                                                @if($Catagorie->images)
                                                    <img src="{{ asset('storage/' . $Catagorie->images->path) }}"
                                                        alt="category Image"
                                                        class="img-fluid rounded-circle"
                                                        style="width: 50px; height: 50px; opacity: 0.6;">
                                                @endif
                                            </td>
                                            <td><strong class="text-muted">{{ $Catagorie->name }}</strong></td>
                                            <td>
                                                @if($Catagorie->status == 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Archived</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($Catagorie->parent)
                                                    <span class="badge bg-secondary">{{ $Catagorie->parent->name }}</span>
                                                @else
                                                    <span class="text-muted">Main Category</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $Catagorie->deleted_at->format('Y-m-d H:i') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group action-buttons" role="group">

                                                    {{-- Restore --}}
                                                    <form action="{{ route('categories.restore', $Catagorie->id) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-restore" title="Restore">
                                                            <i class="fas fa-undo me-1"></i> Restore
                                                        </button>
                                                    </form>

                                                    {{-- Force Delete --}}
                                                    <form action="{{ route('categories.forceDelete', $Catagorie->id) }}"
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('Permanently delete this category?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-delete" title="Delete Forever">
                                                            <i class="fas fa-trash me-1"></i> Delete
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $Catagories->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-archive fa-2x mb-2"></i>
                            <p class="mb-0">No archived categories found.</p>
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
.action-buttons .btn {
    border-radius: 8px;
    padding: 5px 12px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-restore {
    background-color: #198754 !important;
    color: #fff !important;
    border: none !important;
}
.btn-restore:hover {
    background-color: #157347 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}
.btn-delete {
    background-color: #dc3545 !important;
    color: #fff !important;
    border: none !important;
}
.btn-delete:hover {
    background-color: #bb2d3b !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}
</style>
@endpush