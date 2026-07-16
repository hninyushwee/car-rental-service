<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('put') || $this->isMethod('patch')) {

            return [
                'brand_id'      => 'required|exists:brands,id',
                'category_id'   => 'required|exists:categories,id',
                'model'         => 'required|string|max:50',
                'year'          => 'nullable|integer|digits:4|min:1900|max:'.(date('Y') + 1),
                'color'         => 'nullable|string|max:30',
                'capacity'      => 'required|integer|min:1|max:100',
                'price_per_day' => 'required|numeric|min:0',
                'total_stock'   => 'required|integer|min:0',
                'available_stock' => 'required|integer|min:0|lte:total_stock',
                'description'   => 'nullable|string|max:1000',
                'images'        => 'nullable|array',
                'images.*'      => 'image|mimes:jpeg,png,jpg|max:2048',
            ];
        }

        return [
            'brand_id'      => 'required|exists:brands,id',
            'category_id'   => 'required|exists:categories,id',
            'model'         => 'required|string|max:50',
            'year'          => 'nullable|integer|digits:4|min:1900|max:'.(date('Y') + 1),
            'color'         => 'nullable|string|max:30',
            'capacity'      => 'required|integer|min:1|max:100',
            'price_per_day' => 'required|numeric|min:0',
            'total_stock'   => 'required|integer|min:0',
            'available_stock' => 'required|integer|min:0|lte:total_stock',
            'description'   => 'nullable|string|max:1000',
            'images'        => 'required|array',
            'images.*'      => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    /**
     */
    public function messages(): array
    {
        return [
            'brand_id.exists'         => 'The selected vehicle brand is invalid or does not exist.',
            'category_id.exists'      => 'The selected vehicle category is invalid.',
            'available_stock.lte'     => 'Available stock must not exceed total stock.',
            'images.required'         => 'Please upload at least one vehicle image.',
            'images.*.image'          => 'Please upload a valid vehicle photo.',
            'images.*.mimes'          => 'Vehicle photos must be JPG or PNG files.',
            'images.*.max'            => 'Each vehicle image may not be greater than 2MB.',
        ];
    }
}
