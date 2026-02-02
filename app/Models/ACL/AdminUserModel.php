<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class AdminUserModel extends Authenticatable
{
    protected $table= 'tbl_admin';
    protected $fillable=[
        'user_name',
        'password',
        'is_active',
    ];

        public function roles()
        {
            return $this->belongsToMany(AdminRole::class, 'tbl_admin_user_roles', 'admin_id', 'role_id');
        }
}
