<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'pickup_date'      => 'required|date',
            'return_date'      => 'required|date|after_or_equal:pickup_date',
            'pickup_location'  => 'nullable|string|max:255',
            'return_location'  => 'nullable|string|max:255',
            'total_amount'     => 'required|numeric|min:0',
            'deposit_amount'   => 'nullable|numeric|min:0',
            'status'           => 'required|in:pending,confirmed,active,completed,cancelled',
            'items'            => 'nullable|array',
            'items.*.vehicle_id' => 'nullable|exists:vehicles,id',
            'items.*.driver_id'  => 'nullable|exists:drivers,id',
        ];

        if ($this->isMethod('post')) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        return $rules;
    }
}
