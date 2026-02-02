<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ACL\ModuleService;
use App\Http\Requests\ACL\ModuleStoreValidation;
use App\Http\Requests\ACL\ModuleUpdateValidation;

class ModuleController extends Controller
{
    protected $moduleService;

    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    public function index()
    {
        return $this->moduleService->index();
    }

    public function add(ModuleStoreValidation $request)
    {
        return $this->moduleService->add($request);
    }

    public function destroy($id)
    {
        return $this->moduleService->destroy($id);
    }

    public function getModuleData($id)
    {
        return $this->moduleService->getModuleData($id);
    }

    public function update(ModuleUpdateValidation $request, $id)
    {
        return $this->moduleService->update($request, $id);
    }
}
