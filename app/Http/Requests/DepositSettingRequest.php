<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('depositSetting')?->id ?? $this->route('depositSetting');

        return [
            'service_key'  => 'required|string|max:100|unique:deposit_settings,service_key,'.$id,
            'deposit_type' => 'required|in:fixed,percentage',
            'amount'       => 'required|numeric|min:0',
            'is_active'    => 'boolean',
        ];
    }
}
