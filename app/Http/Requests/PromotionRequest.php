<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('promotion')?->id ?? $this->route('promotion');

        return [
            'code'        => 'required|string|max:50|unique:promotions,code,'.$id,
            'type'        => 'required|in:percentage,fixed',
            'value'       => 'required|numeric|min:0',
            'min_amount'  => 'nullable|numeric|min:0',
            'max_uses'    => 'nullable|numeric|min:0',
            'starts_at'   => 'nullable|date',
            'expires_at'  => 'nullable|date|after_or_equal:starts_at',
            'is_active'   => 'boolean',
        ];
    }
}
