<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $brandId = $this->route('brand')?->id ?? $this->route('brand');

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'name' => 'required|string|min:2|unique:brands,name,'.$brandId,
                'year' => 'nullable|string|max:4',
            ];
        }

        return [
            'name' => 'required|string|min:2|unique:brands,name',
            'year' => 'nullable|string|max:4',
        ];
    }
}
