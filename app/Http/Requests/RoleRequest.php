<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('role')?->id ?? $this->route('role');

        return [
            'name' => 'required|string|max:50|unique:roles,name,'.$id,
        ];
    }
}
