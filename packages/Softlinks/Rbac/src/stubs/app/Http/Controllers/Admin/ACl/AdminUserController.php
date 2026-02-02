<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Services\ACL\AdminUserService;
use App\Http\Requests\ACL\AdminUserStoreValidation;
use App\Http\Requests\ACL\AdminUserUpdateValidation;

class AdminUserController extends Controller
{
    protected $adminUserService;

    public function __construct(AdminUserService $adminUserService)
    {
        $this->adminUserService = $adminUserService;
    }

    public function index()
    {
        return $this->adminUserService->index();
    }

    public function add(AdminUserStoreValidation $request)
    {
        return $this->adminUserService->add($request);
    }

    public function destroy($id)
    {
        return $this->adminUserService->destroy($id);
    }

    public function getRolesData($id)
    {
        return $this->adminUserService->getRolesData($id);
    }

    public function update(AdminUserUpdateValidation $request, $id)
    {
        return $this->adminUserService->update($request, $id);
    }
}
