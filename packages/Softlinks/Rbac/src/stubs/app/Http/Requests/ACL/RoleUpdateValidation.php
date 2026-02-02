<?php
namespace App\Http\Requests\ACL;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateValidation extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'role_name'     => ['required','string','max:255',Rule::unique('tbl_roles', 'role_name')->ignore($id),
            ],
            'display_order' => ['nullable','integer','min:1',Rule::unique('tbl_roles', 'display_order')->ignore($id),
            ],
        ];
    }
}
