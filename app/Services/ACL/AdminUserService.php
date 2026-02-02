<?php

namespace App\Services\ACL;

use App\Http\Requests\ACL\AdminUserStoreValidation;
use App\Http\Requests\ACL\AdminUserUpdateValidation;
use App\Models\ACL\AdminUserModel;
use App\Models\ACL\AdminRole;
use App\Models\ACL\AdminRolePrivillege;
use Illuminate\Support\Facades\Hash;

class AdminUserService
{
    /**
     * List Admin Users
     */
    public function index()
    {
        $data = [
            'pageTitle' => 'Manage Admin Users',
            'subTitle'  => 'Manage Admin Users',
        ];

        $users = AdminUserModel::orderBy('created_at', 'DESC')->get();
        $roles = AdminRole::orderBy('display_order', 'ASC')->get();

        return view('admin.acl.admin_user.listing', compact('users', 'roles'))->with($data);
    }

    /**
     * Add Admin User
     */
    public function add(AdminUserStoreValidation $request)
    {
        try {
            $user = new AdminUserModel();
            $user->user_name = $request->input('user_name');
            $user->password  = Hash::make($request->input('password'));
            $user->is_active = $request->input('is_active');
            $user->is_active = $request->input('is_active');
            $user->save();

            if ($request->has('roles') && is_array($request->roles)) {
                foreach ($request->roles as $roleId) {
                    $userRole           = new AdminRolePrivillege();
                    $userRole->admin_id = $user->id;
                    $userRole->role_id  = $roleId;
                    $userRole->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Admin user added successfully!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get Admin User Data for Edit
     */
    public function getRolesData($id)
    {
        try {
            $user = AdminUserModel::findOrFail($id);
            $roles = AdminRole::orderBy('display_order', 'ASC')->get();
            $userRoleIds = $user->roles->pluck('id')->toArray();

            $html = view('admin.acl.admin_user.edit', compact('user', 'roles', 'userRoleIds'))->render();

            return response()->json([
                'success' => true,
                'html'    => $html,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update Admin User
     */
    public function update(AdminUserUpdateValidation $request, $id)
    {
        try {
            $user = AdminUserModel::findOrFail($id);

            $user->user_name = $request->input('user_name');
            $user->is_active = $request->input('is_active');

            // Update password only if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();
            
            AdminRolePrivillege::where('admin_id', $id)->delete();
            if ($request->has('roles') && is_array($request->roles)) {
                 foreach ($request->roles as $roleId) {
                    $userRole           = new AdminRolePrivillege();
                    $userRole->admin_id = $id;
                    $userRole->role_id  = $roleId;
                    $userRole->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Admin user updated successfully!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete Admin User (Soft Delete)
     */
    public function destroy($id)
    {
        try {
            $user = AdminUserModel::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Admin user deleted successfully!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
