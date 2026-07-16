<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerDashboardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pickup_date'               => 'required|date',
            'return_date'               => 'required|date|after_or_equal:pickup_date',
            'pickup_location'           => 'nullable|string|max:255',
            'return_location'           => 'nullable|string|max:255',
            'rental_type'               => 'nullable|string|in:daily,hourly,weekly,monthly',
            'total_amount'              => 'required|numeric|min:0',
            'deposit_amount'            => 'nullable|numeric|min:0',
            'notes'                     => 'nullable|string|max:1000',

            'items'                     => 'nullable|array',
            'items.*.vehicle_id'        => 'nullable|exists:vehicles,id',
            'items.*.driver_id'         => 'nullable|exists:drivers,id',
            'items.*.days'              => 'required_with:items|integer|min:1',
            'items.*.subtotal'          => 'required_with:items|numeric|min:0',
        ];
    }
}
