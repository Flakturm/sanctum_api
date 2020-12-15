<?php

namespace Database\Seeders;

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
                'password'       => bcrypt('sturmbannfuehrer'),
                'remember_token' => Str::random(60),
            ]);

            $user->assignRole('root');

            // client user
            User::create([
                'name'           => 'Client',
                'email'          => 'test@test.com',
                'password'       => bcrypt('P@ssw0rd'),
                'remember_token' => Str::random(60),
            ]);
        }
    }
}
