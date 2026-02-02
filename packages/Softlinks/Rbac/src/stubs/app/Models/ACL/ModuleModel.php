<?php
namespace App\Models\ACL;

use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
    protected $table = 'tbl_modules';

    protected $fillable = [
        'module_category_id',
        'module_name',
        'display_order',
        'css_class',
        'slug',
        'show_in_menu',
    ];
    public function category()
    {
        return $this->belongsTo(ModuleCategory::class, 'module_category_id');
    }

    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'tbl_role_privileges', 'module_id', 'role_id');
    }

}
