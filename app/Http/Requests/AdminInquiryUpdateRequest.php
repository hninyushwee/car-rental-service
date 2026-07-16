<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminInquiryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'sometimes|in:open,resolved,closed',
            'admin_response' => 'nullable|string|max:5000',
        ];
    }
}
