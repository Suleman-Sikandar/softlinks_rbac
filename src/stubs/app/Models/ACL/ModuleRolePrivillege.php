<?php
namespace App\Models\ACL;

use Illuminate\Database\Eloquent\Model;

class ModuleRolePrivillege extends Model
{
    protected $table = 'tbl_role_privileges';

    public static function hasPermission($role_ID, $currentUri)
    {
        $row = ModuleRolePrivillege::join('tbl_roles', 'tbl_role_privileges.role_id', '=', 'tbl_roles.id')
            ->join('tbl_modules', 'tbl_role_privileges.module_id', '=', 'tbl_modules.id')
            ->where('role_id', $role_ID)
            ->where('route', $currentUri)
            ->get()
            ->first();
        return $row;
    }

    public static function getSidebarModules(array $roleIds, int $categoryId)
    {
        return self::join('tbl_modules', 'tbl_role_privileges.module_id', '=', 'tbl_modules.id')
            ->whereIn('tbl_role_privileges.role_id', $roleIds)
            ->where('tbl_modules.module_category_id', $categoryId)
            ->where('tbl_modules.show_in_menu', 1)
            ->orderBy('tbl_modules.display_order')
            ->select('tbl_modules.*')
            ->distinct()
            ->get();
    }
}
