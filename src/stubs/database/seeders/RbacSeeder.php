<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\ACL\AdminRole;
use App\Models\ACL\ModuleCategory;
use App\Models\ACL\ModuleModel;
use App\Models\ACL\AdminUserModel;

class RbacSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Super Admin Role
        $role = AdminRole::firstOrCreate(
            ['role_name' => 'Super Admin'],
            ['display_order' => 1]
        );

        // 2. Create ACL Module Category
        $category = ModuleCategory::firstOrCreate(
            ['category_name' => 'ACL'],
            ['css_class' => 'fa fa-lock', 'display_order' => 1]
        );

        // 3. Seed main modules & child routes
        $modules = [
            ['module_name' => 'Admin Users', 'route' => 'acl/users', 'show_in_menu' => 1, 'display_order' => 1],
            ['module_name' => 'Add Admin User', 'route' => 'acl/users/add', 'show_in_menu' => 0, 'display_order' => 2],
            ['module_name' => 'Edit Admin User', 'route' => 'acl/users/edit/{id}', 'show_in_menu' => 0, 'display_order' => 3],
            ['module_name' => 'Update Admin User', 'route' => 'acl/users/update/{id}', 'show_in_menu' => 0, 'display_order' => 4],
            ['module_name' => 'Delete Admin User', 'route' => 'acl/users/delete/{id}', 'show_in_menu' => 0, 'display_order' => 5],

            ['module_name' => 'Roles', 'route' => 'acl/roles', 'show_in_menu' => 1, 'display_order' => 6],
            ['module_name' => 'Add Role', 'route' => 'acl/roles/add', 'show_in_menu' => 0, 'display_order' => 7],
            ['module_name' => 'Edit Role', 'route' => 'acl/roles/edit/{id}', 'show_in_menu' => 0, 'display_order' => 8],
            ['module_name' => 'Update Role', 'route' => 'acl/roles/update/{id}', 'show_in_menu' => 0, 'display_order' => 9],
            ['module_name' => 'Delete Role', 'route' => 'acl/roles/delete/{id}', 'show_in_menu' => 0, 'display_order' => 10],

            ['module_name' => 'Modules', 'route' => 'acl/modules', 'show_in_menu' => 1, 'display_order' => 11],
            ['module_name' => 'Add Module', 'route' => 'acl/modules/add', 'show_in_menu' => 0, 'display_order' => 12],
            ['module_name' => 'Edit Module', 'route' => 'acl/modules/edit/{id}', 'show_in_menu' => 0, 'display_order' => 13],
            ['module_name' => 'Update Module', 'route' => 'acl/modules/update/{id}', 'show_in_menu' => 0, 'display_order' => 14],
            ['module_name' => 'Delete Module', 'route' => 'acl/modules/delete/{id}', 'show_in_menu' => 0, 'display_order' => 15],

            ['module_name' => 'Module Categories', 'route' => 'acl/module-categories', 'show_in_menu' => 1, 'display_order' => 16],
            ['module_name' => 'Add Module Category', 'route' => 'acl/module-categories/add', 'show_in_menu' => 0, 'display_order' => 17],
            ['module_name' => 'Edit Module Category', 'route' => 'acl/module-categories/edit/{id}', 'show_in_menu' => 0, 'display_order' => 18],
            ['module_name' => 'Update Module Category', 'route' => 'acl/module-categories/update/{id}', 'show_in_menu' => 0, 'display_order' => 19],
            ['module_name' => 'Delete Module Category', 'route' => 'acl/module-categories/delete/{id}', 'show_in_menu' => 0, 'display_order' => 20],
        ];

        foreach ($modules as $data) {
            $module = ModuleModel::firstOrCreate(
                ['route' => $data['route']],
                [
                    'module_category_id' => $category->id,
                    'module_name' => $data['module_name'],
                    'show_in_menu' => $data['show_in_menu'],
                    'css_class' => 'fa fa-cubes',
                    'display_order' => $data['display_order']
                ]
            );

            // Assign full permissions to Super Admin
            $exists = DB::table('tbl_role_privileges')
                ->where('role_id', $role->id)
                ->where('module_id', $module->id)
                ->exists();

            if (!$exists) {
                DB::table('tbl_role_privileges')->insert([
                    'role_id' => $role->id,
                    'module_id' => $module->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        // 4. Create Admin User
        $admin = AdminUserModel::firstOrCreate(
            ['user_name' => 'admin'],
            [
                'password' => Hash::make('password'),
                'is_active' => 1
            ]
        );

        // 5. Assign Role to Admin User
        DB::table('tbl_admin_user_roles')->updateOrInsert(
            ['admin_id' => $admin->id, 'role_id' => $role->id],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $this->command->info('RBAC Data Seeded Successfully!');
        $this->command->info('Default Admin User: admin / password');
    }
}
