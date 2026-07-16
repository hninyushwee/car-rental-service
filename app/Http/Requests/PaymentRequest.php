<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'    => 'required|exists:users,id',
            'amount'     => 'required|numeric|min:0',
            'method'     => 'required|in:cash,card,bank_transfer,wallet',
            'status'     => 'required|in:pending,paid,failed,refunded',
            'reference'  => 'nullable|string|max:255',
        ];
    }
}
