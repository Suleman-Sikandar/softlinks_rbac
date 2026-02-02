<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginValidation extends FormRequest
{
    /**
     * Allow everyone to make this request
     */
    public function authorize(): bool
    {
        return true; // ✅ MUST be true
    }

    /**
     * Validation rules for admin login
     */
    public function rules(): array
    {
        return [
            'user_name' => 'required|string|exists:tbl_admin,user_name',
            'password'  => 'required',
        ];
    }
}
