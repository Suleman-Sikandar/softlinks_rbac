<?php

namespace App\Http\Requests\ACL;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModuleCategoryUpdateValidation extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'category_name' => [
                'required','string','max:255',Rule::unique('tbl_module_categories', 'category_name')->ignore($id),
            ],
            'css_class' => [
                'nullable','string','max:255',
            ],
            'display_order' => [
                'nullable','integer','min:1',Rule::unique('tbl_module_categories', 'display_order')->ignore($id),
            ],
        ];
    }
}
