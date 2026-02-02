<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ACL\ModuleCategoryService;
use App\Http\Requests\ACL\ModuleCategoryStoreValidation;
use App\Http\Requests\ACL\ModuleCategoryUpdateValidation;

class ModuleCategoryController extends Controller
{
    protected $moduleCategoryService;

    public function __construct(ModuleCategoryService $moduleCategoryService)
    {
        $this->moduleCategoryService = $moduleCategoryService;
    }

    public function index()
    {
        return $this->moduleCategoryService->index();
    }

    public function add(ModuleCategoryStoreValidation $request)
    {
        return $this->moduleCategoryService->add($request);
    }

    public function destroy($id)
    {
        return $this->moduleCategoryService->destroy($id);
    }

    public function getModuleCategoriesData($id)
    {
        return $this->moduleCategoryService->getModuleCategoriesData($id);
    }

    public function update(ModuleCategoryUpdateValidation $request, $id)
    {
        return $this->moduleCategoryService->update($request, $id);
    }
}
