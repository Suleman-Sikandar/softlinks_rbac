<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ACL\AdminRoleService;
use App\Http\Requests\ACL\RoleStoreValidation;
use App\Http\Requests\ACL\RoleUpdateValidation;
class AdminRoleController extends Controller
{
    protected $adminRoleService;

    public function __construct(AdminRoleService $adminRoleService)
    {
        $this->adminRoleService = $adminRoleService;
    }

    public function index()
    {
        return $this->adminRoleService->index();
    }
    public function add(RoleStoreValidation $request)
    {
        return $this->adminRoleService->add($request);
    }
    public function destroy($id)
    {
        return $this->adminRoleService->destroy($id);
    }
    public function getRolesData($id)
    {
        return $this->adminRoleService->getRolesData($id);
    }
    public function update(RoleUpdateValidation $request, $id)
    {
        return $this->adminRoleService->update($request, $id);
    }
}