@extends('layouts.Dashboard')

@section('title') Edit Role @endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Edit - {{ $role->name }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-pen-to-square me-2"></i> Edit Role: {{ $role->name }}
                </h5>
            </div>

            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Role Name --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Role Name</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $role->name) }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g. Admin, Editor...">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Permissions --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-key me-1"></i> Permissions
                        </label>
                        @error('permission')
                            <div class="text-danger small mb-2">{{ $message }}</div>
                        @enderror
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="permission[]"
                                               value="{{ $permission->id }}"
                                               id="perm_{{ $permission->id }}"
                                               {{ isset($rolePermissions[$permission->id]) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            <span class="badge bg-secondary">{{ $permission->name }}</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i> Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection