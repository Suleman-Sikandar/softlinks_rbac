<?php

namespace App\Services\ACL;

use App\Http\Requests\ACL\ModuleStoreValidation;
use App\Http\Requests\ACL\ModuleUpdateValidation;
use App\Models\ACL\ModuleModel;
use App\Models\ACL\ModuleCategory;

class ModuleService
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Manage Modules',
            'subTitle'  => 'Manage Modules',
            'categories' => ModuleCategory::all()
        ];

        $modules = ModuleModel::with('category')->orderBy('display_order', 'ASC')->get();

        return view('admin.acl.modules.listing', compact('modules'))->with($data);
    }

    // Add Module
    public function add(ModuleStoreValidation $request)
    {
        try {
            $module = new ModuleModel();
            $module->module_category_id = $request->input('module_category_id');
            $module->module_name = $request->input('module_name');
            $module->display_order = $request->input('display_order');
            $module->css_class = $request->input('css_class');
            $module->route = $request->input('route');
            $module->show_in_menu = $request->input('show_in_menu');
            $module->save();

            return response()->json([
                'success' => true,
                'message' => 'Module added successfully!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Get Module Data for Edit
    public function getModuleData($id)
    {
        try {
            $module = ModuleModel::findOrFail($id);
            $categories = ModuleCategory::all();

            $html = view('admin.acl.modules.edit', compact('module', 'categories'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Update Module
    public function update(ModuleUpdateValidation $request, $id)
    {
        try {
            $module = ModuleModel::findOrFail($id);
            $module->module_category_id = $request->input('module_category_id');
            $module->module_name = $request->input('module_name');
            $module->display_order = $request->input('display_order');
            $module->css_class = $request->input('css_class');
            $module->route = $request->input('route');
            $module->show_in_menu = $request->input('show_in_menu');
            $module->save();

            return response()->json([
                'success' => true,
                'message' => 'Module updated successfully!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Delete Module
    public function destroy($id)
    {
        try {
            $module = ModuleModel::findOrFail($id);
            $module->delete();

            return response()->json([
                'success' => true,
                'message' => 'Module deleted successfully!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
