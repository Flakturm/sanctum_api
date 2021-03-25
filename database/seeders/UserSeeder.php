<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() === 0) {
            // root user
            $user = User::create([
                'name'           => 'Root',
                'email'          => 'admin@admin.test',
                'active'         => true,
                'password'       => bcrypt('sturmbannfuehrer'),
                'remember_token' => Str::random(60),
            ]);

            $user->assignRole(Role::ROLE_ROOT);
        }
    }
}
