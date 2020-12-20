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

        // create permissions
        Permission::create(['name' => ModelsPermission::BROWSE_DASHBOARD]);
        Permission::create(['name' => ModelsPermission::ACCESS_USER_PERMISSIONS]);
        Permission::create(['name' => ModelsPermission::ACCESS_USER_ADMIN]);
        Permission::create(['name' => ModelsPermission::ACCESS_USER_MEMBERS]);
        Permission::create(['name' => ModelsPermission::ACCESS_USER_VENDORS]);

        // create roles
        Role::create(['name' => ModelsRole::ROLE_ROOT]);
        Role::create(['name' => ModelsRole::ROLE_ADMIN]);
        Role::create(['name' => ModelsRole::ROLE_MEMBER]);
        Role::create(['name' => ModelsRole::ROLE_VENDOR]);
    }
}
