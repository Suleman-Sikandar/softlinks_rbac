<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\Model;

class ModuleCategory extends Model
{
    protected $table = 'tbl_module_categories';

    protected $fillable = [
        'category_name',
        'css_class',
        'display_order',
    ];
    public function modules()
    {
        return $this->hasMany(ModuleModel::class, 'module_category_id');
    }
}
