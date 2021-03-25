<?php

namespace Database\Seeders;

use App\Models\Permission as ModelsPermission;
use App\Models\Role as ModelsRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        if (Permission::count() === 0) {
            // Seed the default permissions
            Permission::create(['name' => ModelsPermission::BROWSE_DASHBOARD]);
            $permissions = ModelsPermission::permissionList();

            foreach ($permissions as $perms) {
                Permission::firstOrCreate(['name' => $perms]);
            }
        }

        if (Role::count() === 0) {
            // Seed the default roles
            $roles = ModelsRole::roleList();
            foreach ($roles as $role) {
                $role = Role::create(['name' => $role]);
            }
        }
    }
}
