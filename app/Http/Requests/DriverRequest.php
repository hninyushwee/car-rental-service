<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $driverId = $this->route('driver')?->id ?? $this->route('driver');

        return [
            'name'                => 'required|string|max:255',
            'phone'               => ['required', 'string', Rule::unique('drivers', 'phone')->ignore($driverId)],
            'license_number'      => ['required', 'string', Rule::unique('drivers', 'license_number')->ignore($driverId)],
            'license_expiry_date' => 'required|date|after:today',
            'price_per_day'       => 'required|numeric|min:0',
            'address'             => 'nullable|string',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vehicle_id'          => 'nullable|exists:vehicles,id',
            'status'              => 'nullable|in:available,on_trip,off_duty',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter the driver name.',
            'phone.required' => 'Please enter a phone number.',
            'phone.unique' => 'This phone number is already used by another driver.',
            'license_number.required' => 'Please enter the license number.',
            'license_number.unique' => 'This license number is already registered.',
            'license_expiry_date.required' => 'Please choose the license expiry date.',
            'license_expiry_date.after' => 'License expiry date must be after today.',
            'price_per_day.required' => 'Please enter the daily driver rate.',
            'image.image' => 'Please upload a valid driver photo.',
            'image.mimes' => 'Driver photo must be a JPG or PNG file.',
            'image.max' => 'Driver photo may not be greater than 2MB.',
        ];
    }
}
