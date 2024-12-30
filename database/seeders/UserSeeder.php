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
            'name' => 'John Agi',
            'email' => 'superadmin@bdic.com',
            'password' => bcrypt('123456'),
            'status' => 'active',
            'default_role' => 'superadmin',
        ]);
        $superadmin->assignRole('superadmin');

        // Create an Admin User
        $admin = User::create([
            'name' => 'Ephraim Tarfa',
            'email' => 'admin@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
        ]);
        $admin->assignRole('Admin');


        // Create an Staff User
        $admin = User::create([
            'name' => 'Godfrey Ejeh',
            'email' => 'saff@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Staff',
        ]);
        $admin->assignRole('Staff');

        // Create a Regular User
        $user = User::create([
            'name' => 'Shima Adi',
            'email' => 'user@example.com',
            'password' => bcrypt('123456'),
            'default_role' => 'User',
        ]);
        $user->assignRole('User');
    }
}
