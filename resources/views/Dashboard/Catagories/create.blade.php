@extends('layouts.Dashboard')

@section('title')
    Add New Category
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Add New</li>
@endsection

@section('content')
<div class="container-fluid py-4">

    <div class="card shadow border-0">
        
      

        <div class="card-body px-4 py-4">
            <form  action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Category Name --}}
            <div class="mb-4">
    <x-form.input 
        type="text"
        name="name"
        label="Category Name"
        placeholder="Enter category name"
        
    />
</div>

                {{-- Parent Category --}}
                <div class="mb-4">
                    <label for="parent_id" class="form-label">
                        Parent Category
                    </label>
                    <select class="form-select @error('parent_id') is-invalid @enderror" 
                            id="parent_id" 
                            name="parent_id">
                        <option value="">Main Category</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" 
                                    {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Leave empty if this is a main category</small>
                </div>

                {{-- Description --}}
                {{-- <div class="mb-4">
                    <label for="description" class="form-label">
                        Description
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="5"
                              placeholder="Enter category description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}
                      <div class="mb-4">
                    <x-form.textarea 
                    name="description"
                       label="description"
                       placeholder="Enter description"
                    /></div>

                {{-- Image --}}
                {{-- <div class="mb-4">
                    <label for="image" class="form-label">
                        Category Image
                    </label>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image"
                           accept="image/*"
                           onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}
                <div class="mb-4">
    <x-form.input 
        type="file"
        name="image"
        label="Category Name"
     onchange="previewImage(event)"
      
    />
</div>

                {{-- Status --}}
                <div class="mb-4">
                    <label for="status" class="form-label">
                        Status
                    </label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" 
                            name="status">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="archieved" {{ old('status') == 'archieved' ? 'selected' : '' }}>Archived</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <a href="{{ route('categories.index') }}" class="btn btn-light border">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <div>
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save"></i> Save Category
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
