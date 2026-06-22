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
            
            $vehicleId = $this->route('vehicle')?->id ?? $this->route('vehicle');

            return [
                'brand_id'      => 'required|exists:brands,id', 
                'category_id'   => 'required|exists:categories,id', 
                'model'         => 'required|string|max:50',
                'year'          => 'required|integer|digits:4|min:1900|max:'.(date('Y') + 1),
                'license_plate' => 'required|string|max:20|unique:vehicles,license_plate,'.$vehicleId,
                'color'         => 'required|string|max:30',
                'capacity'      => 'required|integer|min:1|max:100',
                'price_per_day' => 'required|numeric|min:0',
                'status'        => 'required|in:available,rented,maintenance',
                'description'   => 'nullable|string|max:1000',
                'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Update ချိန်တွင် ပုံမတင်လည်းရ
            ];
        }

        return [
            'brand_id'      => 'required|exists:brands,id', 
            'category_id'   => 'required|exists:categories,id', 
            'model'         => 'required|string|max:50',
            'year'          => 'required|integer|digits:4|min:1900|max:'.(date('Y') + 1),
            'license_plate' => 'required|string|max:20|unique:vehicles,license_plate', 
            'color'         => 'required|string|max:30',
            'capacity'      => 'required|integer|min:1|max:100',
            'price_per_day' => 'required|numeric|min:0',
            'status'        => 'required|in:available,rented,maintenance',
            'description'   => 'nullable|string|max:1000',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        ];
    }

    /**
     */
    public function messages(): array
    {
        return [
            'brand_id.exists'      => 'The selected vehicle brand is invalid or does not exist.',
            'category_id.exists'   => 'The selected vehicle category is invalid.',
            'license_plate.unique' => 'This license plate is already registered in our system.',
            'image.required'       => 'Please upload a vehicle image.',
            'image.max'            => 'The vehicle image may not be greater than 2MB.',
        ];
    }
}