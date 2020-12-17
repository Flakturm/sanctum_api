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
        Permission::create(['name' => ModelsPermission::MANAGE_PERMISSIONS]);
        Permission::create(['name' => ModelsPermission::ACCESS_DASHBOARD]);

        Role::create(['name' => ModelsRole::ROLE_ROOT]);
        $role = Role::create(['name' => ModelsRole::ROLE_ADMIN]);
        $role->givePermissionTo(ModelsPermission::ACCESS_DASHBOARD);

        Role::create(['name' => ModelsRole::ROLE_MEMBER]);
    }
}
