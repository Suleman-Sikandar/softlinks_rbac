<?php

use App\Http\Controllers\Admin\ACL\AdminRoleController;
use App\Http\Controllers\Admin\ACL\AdminUserController;
use App\Http\Controllers\Admin\ACL\ModuleCategoryController;
use App\Http\Controllers\Admin\ACL\ModuleController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AdminLoginController::class, 'index'])->name('login');
Route::post('login', [AdminLoginController::class, 'doLogin']);
Route::get('logout', [AdminLoginController::class, 'logout'])->name('logout');
/**
 * Admin Routes
 */
Route::middleware(['auth', 'XSS'])->group(function () {
    /**
     * Dashboard Routes
     */
    Route::get('/admin', [DashboardController::class, 'index']);


/**
 * Admin User Routes
 */
    Route::get('acl/users', [AdminUserController::class, 'index']);
    Route::post('acl/users/add', [AdminUserController::class, 'add']);
    Route::get('acl/users/edit/{id}', [AdminUserController::class, 'getRolesData']);
    Route::post('acl/users/update/{id}', [AdminUserController::class, 'update']);
    Route::delete('acl/users/delete/{id}', [AdminUserController::class, 'destroy']);
/**
 * ACL Roles Routes
 **/
    Route::get('acl/roles', [AdminRoleController::class, 'index']);
    Route::post('acl/roles/add', [AdminRoleController::class, 'add']);
    Route::get('acl/roles/edit/{id}', [AdminRoleController::class, 'getRolesData']);
    Route::post('acl/roles/update/{id}', [AdminRoleController::class, 'update']);
    Route::delete('acl/roles/delete/{id}', [AdminRoleController::class, 'destroy']);
/**
 * ACL Modules Routes
 **/
    Route::get('acl/modules', [ModuleController::class, 'index']);
    Route::post('acl/modules/add', [ModuleController::class, 'add']);
    Route::get('acl/modules/edit/{id}', [ModuleController::class, 'getModuleData']);
    Route::post('acl/modules/update/{id}', [ModuleController::class, 'update']);
    Route::delete('acl/modules/delete/{id}', [ModuleController::class, 'destroy']);
/**
 * ACL Module Categories Routes
 **/
    Route::get('acl/module-categories', [ModuleCategoryController::class, 'index']);
    Route::post('acl/module-categories/add', [ModuleCategoryController::class, 'add']);
    Route::get('acl/module-categories/edit/{id}', [ModuleCategoryController::class, 'getModuleCategoriesData']);
    Route::post('acl/module-categories/update/{id}', [ModuleCategoryController::class, 'update']);
    Route::delete('acl/module-categories/delete/{id}', [ModuleCategoryController::class, 'destroy']);
});
