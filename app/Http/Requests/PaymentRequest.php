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
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'status' => 'sometimes|in:pending,paid,failed,refunded',
                'payment_date' => 'nullable|date',
            ];
        }

        return [
            'user_id'    => 'required|exists:users,id',
            'payable_type' => 'required|string|max:255',
            'payable_id' => 'required|integer|min:1',
            'amount'     => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,bank_transfer,wallet,kpay,wavepay',
            'status'     => 'required|in:pending,paid,failed,refunded',
            'transaction_ref'  => 'nullable|string|max:255',
            'payment_date' => 'nullable|date',
        ];
    }
}
