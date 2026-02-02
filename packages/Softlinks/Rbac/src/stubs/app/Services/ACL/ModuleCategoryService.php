<?php

namespace App\Services\ACL;

use App\Http\Requests\ACL\ModuleCategoryStoreValidation;
use App\Http\Requests\ACL\ModuleCategoryUpdateValidation;
use App\Models\ACL\ModuleCategory;

class ModuleCategoryService
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Manage Module Categories',
            'subTitle'  => 'Manage Module Categories',
        ];

        $moduleCategories = ModuleCategory::orderBy('display_order', 'ASC')->get();

        return view('admin.acl.module_categories.listing', compact('moduleCategories'))->with($data);
    }

    // Add Module Category
    public function add(ModuleCategoryStoreValidation $request)
    {
        try {
            $category                = new ModuleCategory();
            $category->category_name = $request->input('category_name');
            $category->css_class     = $request->input('css_class');
            $category->display_order = $request->input('display_order');
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Module category added successfully!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Get Module Category Data for Edit
    public function getModuleCategoriesData($id)
    {
        try {
            $category = ModuleCategory::findOrFail($id);

            $html = view('admin.acl.module_categories.edit', compact('category'))->render();

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

    // Update Module Category
    public function update(ModuleCategoryUpdateValidation $request, $id)
    {
        try {
            $category                = ModuleCategory::findOrFail($id);
            $category->category_name = $request->input('category_name');
            $category->css_class     = $request->input('css_class');
            $category->display_order = $request->input('display_order');
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Module category updated successfully!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Delete Module Category
    public function destroy($id)
    {
        try {
            $category = ModuleCategory::findOrFail($id);
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Module category deleted successfully!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
