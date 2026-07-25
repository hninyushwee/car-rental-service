<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => 'required|json',
            'payment_method' => 'required|in:kpay,wavepay,bank_transfer,card',
            'transaction_ref' => 'required|string|max:255|unique:payments,transaction_ref',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'transaction_ref.unique' => 'This transaction reference has already been used. Please check your payment details and try again.',
        ];
    }
}
