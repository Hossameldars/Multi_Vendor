@extends('layouts.Dashboard')

@section('title') Roles @endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-12 d-flex justify-content-end">
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add New Role
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i> All Roles</h5>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($roles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Role Name</th>
                            <th>Permissions Count</th>
                            <th>Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-primary fs-6">
                                        <i class="fas fa-shield-alt me-1"></i>
                                        {{ $role->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $role->abilities->count() }} Permissions
                                    </span>
                                </td>
                                
                                <td class="text-center">
                                    <a href="{{ route('roles.edit', $role->id) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-pen-to-square me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('roles.destroy', $role->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-2x mb-2"></i>
                <p class="mb-0">No roles found.</p>
            </div>
        @endif

    </div>
</div>
@endsection