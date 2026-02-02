<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ACL\AdminUserModel;
use App\Models\ACL\AdminRole;
use App\Models\ACL\ModuleModel;
class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'pageTitle' => 'RBAC Package',
            'subTitle' => 'Manage Roles and Permissions with ease using our RBAC Package.',
            'users' => AdminUserModel::count(),
            'roles' => AdminRole::count(),
            'permissions' => ModuleModel::count(),
        ];
        return view('admin.adminDashboard', $data);
    }
}
