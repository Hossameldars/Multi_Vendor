@extends('layouts.Dashboard')

@section('title')
    Edit Profile
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
<div class="container-fluid py-4">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')

                {{-- ================= Personal Info ================= --}}
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-user-circle text-primary me-2"></i>
                        Personal Information
                    </h5>

                    {{-- ================= Profile Image ================= --}}
<div class="text-center mb-4">

    <div class="position-relative d-inline-block">

        <img id="preview-image"
             src="{{ $user->image ? asset('storage/'.$user->image->path) : asset('storage/profile/personlogo.jpg') }}"
             class="rounded-circle shadow"
             width="120"
             height="120"
             style="object-fit: cover; border: 3px solid #eee;">

        {{-- Overlay يغطي الجزء السفلي من الصورة --}}
        <label for="image"
               class="position-absolute bottom-0 start-0 w-100 text-center text-white"
               style="
                   background: rgba(0, 0, 0, 0.5);
                   border-radius: 0 0 50% 50%;
                   padding: 6px 0;
                   cursor: pointer;
                   height: 40%;
                   display: flex;
                   align-items: center;
                   justify-content: center;
                   font-size: 13px;
               ">
            <i class="fas fa-camera me-1"></i> تعديل
        </label>

        <input type="file"
               name="image"
               id="image"
               class="d-none"
               accept="image/*">
    </div>

    <div class="mt-2">
        <small class="text-muted">اضغط على الصورة لتغييرها</small>
    </div>

    @error('image')
        <div class="text-danger mt-2">{{ $message }}</div>
    @enderror

</div>
                    <div class="row g-3">
                      
                        <div class="col-md-6">
                            <label class="form-label">First Name *</label>
                            <input type="text"
                                   class="form-control @error('first_name') is-invalid @enderror"
                                   name="fisrt_name"
                                        
                                   value="{{ old('first_name', $user->profile->fisrt_name ?? '') }}"
                                   placeholder="Enter first name">
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Last Name *</label>
                            <input type="text"
                                   class="form-control @error('last_name') is-invalid @enderror"
                                   name="last_name"
                                   value="{{ old('last_name', $user->profile->last_name ?? '') }}"
                                   placeholder="Enter last name">
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Birthday</label>
                            <input type="date"
                                   class="form-control @error('birthday') is-invalid @enderror"
                                   name="birthday"
                                   value="{{ old('birthday', optional($user->profile)->birthday?->format('Y-m-d')) }}">
                            @error('birthday')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label d-block">Gender</label>

                            <div class="d-flex gap-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="gender"
                                           value="male"
                                           {{ old('gender', $user->profile->gender ?? '') == 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label">Male</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="gender"
                                           value="female"
                                           {{ old('gender', $user->profile->gender ?? '') == 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- ================= Address ================= --}}
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                        Address
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">Street Address</label>
                        <input type="text"
                               class="form-control @error('street_address') is-invalid @enderror"
                               name="street_address"
                               value="{{ old('street_address', $user->profile->street_address ?? '') }}">
                        @error('street_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text"
                                   class="form-control"
                                   name="city"
                                   value="{{ old('city', $user->profile->city ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">State</label>
                            <input type="text"
                                   class="form-control"
                                   name="state"
                                   value="{{ old('state', $user->profile->state ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Postal Code</label>
                            <input type="text"
                                   class="form-control"
                                   name="postal_code"
                                   value="{{ old('postal_code', $user->profile->postal_code ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Country *</label>
                            <select class="form-select @error('country') is-invalid @enderror"
                                    name="country">
                                <option value="">Select Country</option>
                                @foreach($countries as $code => $name)
                                    <option value="{{ $code }}"
                                        {{ old('country', $user->profile->country ?? '') == $code ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
{{-- 
                <hr> --}}

                {{-- ================= Preferences ================= --}}
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-sliders-h text-success me-2"></i>
                        Preferences
                    </h5>

                    <label class="form-label">Language</label>
                    <select class="form-select"
                            name="locale">
                        <option value="en" {{ old('locale', $user->profile->locale ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="ar" {{ old('locale', $user->profile->locale ?? 'en') == 'ar' ? 'selected' : '' }}>Arabic</option>
                    </select>
                </div>

                {{-- ================= Buttons ================= --}}
                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection