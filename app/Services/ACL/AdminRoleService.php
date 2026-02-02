<?php
namespace App\Services\ACL;

use App\Http\Requests\ACL\RoleStoreValidation;
use App\Http\Requests\ACL\RoleUpdateValidation;
use App\Models\ACL\AdminRole;
use App\Models\ACL\ModuleCategory;
use App\Models\ACL\ModuleRolePrivillege;

class AdminRoleService
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Manage Roles',
            'subTitle'  => 'Manage Roles',
        ];
        $roles = AdminRole::orderBy('display_order', 'ASC')->get();
        return view('admin.acl.roles.listing', compact('roles'))->with($data);
    }

    //Add Role
    public function add(RoleStoreValidation $request)
    {
        try {
            $role                = new AdminRole();
            $role->role_name     = $request->input('role_name');
            $role->display_order = $request->input('display_order');
            $role->save();

            return response()->json([
                'success' => true,
                'message' => 'Role added successfully!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }
    //Get Role Data for Edit
    public function getRolesData($id)
    {
        $role = AdminRole::findOrFail($id);
        $data = [
            'pageTitle' => 'Manage Role',
            'subTitle'  => 'Edit Role',
        ];
        $roleModuleIds    = $role->modules->pluck('id')->toArray();
        $moduleCategories = ModuleCategory::whereHas('modules')->get();
        return view('admin.acl.roles.edit', compact('role', 'moduleCategories', 'roleModuleIds'))->with($data);
    }

    public function update(RoleUpdateValidation $request, $id)
    {

        try {
            $role            = AdminRole::findOrFail($id);
            $role->role_name = $request->input('role_name');
            $role->save();
            ModuleRolePrivillege::where('role_id', $id)->delete();
            if ($request->has('modules') && is_array($request->modules)) {
                foreach ($request->modules as $moduleId) {
                    $rolePrivilege            = new ModuleRolePrivillege();
                    $rolePrivilege->role_id   = $id;
                    $rolePrivilege->module_id = $moduleId;
                    $rolePrivilege->save();
                }
            }
            return redirect()->back()->with([
                'success' => true,
                'message' => 'Role updated successfully',
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    //Delete Role
    public function destroy($id)
    {
        try {
            $role = AdminRole::findOrFail($id);
            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }
}
