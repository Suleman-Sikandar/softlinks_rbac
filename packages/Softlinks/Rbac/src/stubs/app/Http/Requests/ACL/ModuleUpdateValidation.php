<?php

namespace App\Http\Requests\ACL;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModuleUpdateValidation extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'module_category_id' => [
                'required',
                'integer',
                'exists:tbl_module_categories,id',
            ],
            'module_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tbl_modules', 'module_name')->ignore($id),
            ],
            'display_order' => [
                'nullable',
                'integer',
                'min:1',
                Rule::unique('tbl_modules', 'display_order')->ignore($id),
            ],
            'css_class' => [
                'nullable',
                'string',
                'max:255',
            ],
            'route' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tbl_modules', 'route')->ignore($id),
            ],
            'show_in_menu' => [
                'required',
                'boolean',
            ],
        ];
    }
}
