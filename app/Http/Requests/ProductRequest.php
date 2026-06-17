<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product');

        return [
            'name'          => 'required|string|max:255|unique:products,name,' . $productId,
            'category_id'   => 'required|integer|exists:categories,id',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0|gt:price',
            'options'       => 'nullable|array',
            'featured'      => 'boolean',
            'status'        => 'in:active,inactive',
            'tag_ids'       => 'nullable|array',
            'tag_ids.*'     => 'integer|exists:tags,id',
        ];
    }
}