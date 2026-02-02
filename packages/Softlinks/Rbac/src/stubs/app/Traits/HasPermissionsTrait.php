<?php
namespace App\Traits;

use App\Models\ACL\AdminRolePrivillege;
use App\Models\ACL\ModuleRolePrivillege;
use Auth;
use Route;
trait HasPermissionsTrait
{
    public function getModulesPremissions()
    {
        // echo Route::getFacadeRoot()->current()->uri();
        $return           = false;
        $currentUri       = Route::getFacadeRoot()->current()->uri();
        $adminUserId      = Auth::guard('admin')->user()->id;
        $resultAdminRoles = AdminRolePrivillege::where('admin_id', $adminUserId)->get();
        if ($resultAdminRoles) {
            foreach ($resultAdminRoles as $rowAdminRole) {
                $result = ModuleRolePrivillege::hasPermission($rowAdminRole->role_id, $currentUri);
                $return = $result;
            }
        }
        return $return;
    }

    public static function getModulesPremissionsBySlug($slug)
    {
        $return           = false;
        $currentUri       = $slug;
        $adminUserId      = Auth::guard('admin')->user()->id;
        $resultAdminRoles = AdminRolePrivillege::where('admin_id', $adminUserId)->get();
        if ($resultAdminRoles) {
            foreach ($resultAdminRoles as $rowAdminRole) {
                $result = ModuleRolePrivillege::hasPermission($rowAdminRole->role_id, $currentUri);
                $return = $result;
            }
        }
        return $return;
    }
}
