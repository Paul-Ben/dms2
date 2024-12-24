<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@bdic.com',
            'password' => bcrypt('123456'),
            'phone' => '1234567890',
            'avatar' => 'avatars/superadmin.png',
            'status' => 'active',
            'default_role' => 'superadmin',
        ]);
        $superadmin->assignRole('superadmin');

        // Create an Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
        ]);
        $admin->assignRole('Admin');


        // Create an Staff User
        $admin = User::create([
            'name' => 'Staff User',
            'email' => 'saff@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Staff',
        ]);
        $admin->assignRole('Staff');

        // Create a Regular User
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('123456'),
            'default_role' => 'User',
        ]);
        $user->assignRole('User');
    }
}
