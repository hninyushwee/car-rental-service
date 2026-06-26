<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if($this->isMethod('put') || $this->isMethod('patch')){

            $categoryId = $this->route('category')?->id ?? $this->route('category');
            return [
                'name' => 'required|string|min:2|unique:categories,name,'.$categoryId,
            ];
        }
        return [
            'name' => 'required|string|min:2|unique:categories,name',
        ];
    }
}
