@extends('layouts.Dashboard') 

@section('title') 
    Edit Category 
@endsection 

@section('breadcrumb') 
    @parent 
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li> 
    <li class="breadcrumb-item active">Edit</li> 
@endsection 

@section('content') 
<div class="container-fluid py-4"> 

    <div class="card shadow border-0"> 

        <div class="card-body px-4 py-4"> 
            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"> 
                @csrf 
                @method('PUT')

                {{-- Category Name --}} 
                <div class="mb-4"> 
                    <label for="name" class="form-label"> 
                        Category Name <span class="text-danger">*</span> 
                    </label> 
                    <input type="text"  
                           class="form-control form-control-lg @error('name') is-invalid @enderror"  
                           id="name"  
                           name="name"  
                           value="{{ old('name', $category->name) }}" 
                           placeholder="Enter category name" 
                           required> 
                    @error('name') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror 
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
                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}> 
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
                <div class="mb-4"> 
                    <label for="description" class="form-label"> 
                       Description 
                    </label> 
                    <textarea class="form-control @error('description') is-invalid @enderror"  
                              id="description"  
                              name="description"  
                              rows="5" 
                              placeholder="Enter category description">{{ old('description', $category->description) }}</textarea> 
                    @error('description') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror 
                </div> 

                {{-- Image --}} 
                <div class="mb-4"> 
                    <label for="image" class="form-label"> 
                        Category Image 
                    </label> 
                    <input type="file"  
                           class="form-control @error('image') is-invalid @enderror"  
                           id="image"  
                           name="image" 
                           accept="image/*"> 

                    @if($category->image)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $category->image) }}" width="120" class="img-thumbnail">
                        </div>
                    @endif

                    @error('image') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror 
                </div> 

                {{-- Status --}} 
                <div class="mb-4"> 
                    <label for="status" class="form-label"> 
                        Status 
                    </label> 
                    <select class="form-select @error('status') is-invalid @enderror"  
                            id="status"  
                            name="status"> 
                        <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option> 
                        <option value="archieved" {{ old('status', $category->status) == 'archieved' ? 'selected' : '' }}>Archived</option> 
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
                        <button type="submit" class="btn btn-primary px-4"> 
                            <i class="fas fa-save"></i> Update Category 
                        </button> 
                    </div> 
                </div> 

            </form> 
        </div> 
    </div> 

</div> 
@endsection 
