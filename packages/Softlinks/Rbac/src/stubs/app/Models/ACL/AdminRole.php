<?php
namespace App\Models\ACL;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'tbl_roles';

    protected $fillable = [
        'role_name',
        'display_order',
    ];

    public function modules()
    {
        return $this->belongsToMany(ModuleModel::class, 'tbl_role_privileges', 'role_id', 'module_id');
    }

    public function users()
    {
        return $this->belongsToMany(AdminUserModel::class, 'tbl_admin_user_roles', 'admin_id', 'role_id');
    }

}
