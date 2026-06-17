<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

  public function rules(): array
{
    return [
        'fisrt_name'     => ['required', 'string', 'max:255'], 
        'last_name'      => ['required', 'string', 'max:255'],
        'gender'         => ['nullable', 'in:male,female'],
        'birthday'       => ['nullable', 'date'],
        'street_address' => ['nullable', 'string', 'max:255'],
        'city'           => ['nullable', 'string', 'max:255'],
        'state'          => ['nullable', 'string', 'max:255'],
        'postal_code'    => ['nullable', 'string', 'max:20'],
        'country'        => ['nullable', 'string', 'max:2'],
        'locale'         => ['nullable', 'in:en,ar'],
        'image'          => ['nullable', 'image'], 
    ];
}
}