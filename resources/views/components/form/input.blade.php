@props([
    'type' => 'text',
    'name',
    'value' => '',
    'label' => null,
    'placeholder' => null,
])

@if($label)
    <label for="{{ $name }}" class="form-label">
        {{ $label }} 
        @if(isset($required) && $required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif

<input type="{{ $type }}" 
       class="form-control @error($name) is-invalid @enderror" 
       id="{{ $name }}"
       name="{{ $name }}" 
       value="{{ old($name, $value) }}"
       placeholder="{{ $placeholder }}"
       {{ $attributes }}>

@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror