<?php

namespace App\Http\Requests\ACL;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserUpdateValidation extends FormRequest
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
     */
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'user_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tbl_admin', 'user_name')->ignore($id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],

            'roles' => [
                'nullable',
                'array',
            ],
            'roles.*' => [
                'exists:tbl_roles,id',
            ],
        ];
    }
}
