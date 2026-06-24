<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
        return [
            'name'                => 'required|string|max:255',
            'phone'               => 'required|string|unique:drivers,phone',
            'license_number'      => 'required|string|unique:drivers,license_number',
            'license_expiry_date' => 'required|date|after:today',
            'price_per_day'       => 'required|numeric|min:0',
            'address'             => 'nullable|string',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vehicle_id'          => 'nullable|exists:vehicles,id',
        ];
    }
}
