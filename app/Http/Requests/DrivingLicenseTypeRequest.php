<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DrivingLicenseTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('driving_license_type')?->id ?? $this->route('driving_license_type');

        $rules = [
            'type' => 'required|string|max:255|unique:driving_license_types,type,' . $id,
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Please enter the license type name.',
            'type.unique' => 'This license type already exists.',
            'price.required' => 'Please enter the price.',
            'price.numeric' => 'Price must be a number.',
            'image.image' => 'Please upload a valid image.',
            'image.mimes' => 'Image must be a JPG or PNG file.',
            'image.max' => 'Image may not be greater than 2MB.',
        ];
    }
}
