@props([
  
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

<textarea 
       class="form-control @error($name) is-invalid @enderror" 
       id="{{ $name }}"
       name="{{ $name }}" 
        rows="5"
       placeholder="{{ $placeholder }}"
       {{ $attributes }}>
       {{ old($name, $value) }}
</textarea>

@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror