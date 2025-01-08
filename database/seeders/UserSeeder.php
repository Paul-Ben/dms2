<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
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
            'email_verified_at' => Carbon::now()
        ]);
        $superadmin->assignRole('superadmin');
        

        // Create an Admin User
        $admin = User::create([
            'name' => 'Ephraim Tarfa',
            'email' => 'admin@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');


        // Create an Staff User
        $admin = User::create([
            'name' => 'Godfrey Ejeh',
            'email' => 'saff@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Staff',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Staff');

        // Create a Regular User
        $user = User::create([
            'name' => 'Shima Adi',
            'email' => 'user@example.com',
            'password' => bcrypt('123456'),
            'default_role' => 'User',
            'email_verified_at' => Carbon::now()
        ]);
        $user->assignRole('User');

        // Create an Admin User
        $admin = User::create([
            'name' => 'Ephraim Tarfa',
            'email' => 'admin2@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

         // Create an Admin User
         $admin = User::create([
            'name' => 'Ephraim Tar',
            'email' => 'admin3@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

        // Create an Admin User
        $admin = User::create([
            'name' => 'Ephraim Tange',
            'email' => 'admin4@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

         // Create an Admin User
         $admin = User::create([
            'name' => 'Solomon Tange',
            'email' => 'admin5@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

         // Create an Admin User
         $admin = User::create([
            'name' => 'Shishi Tange',
            'email' => 'admin6@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

           // Create an Admin User
           $admin = User::create([
            'name' => 'Shishi Tarnge',
            'email' => 'admin7@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

        // Create an Admin User
        $admin = User::create([
            'name' => 'Shishi Shima',
            'email' => 'admin8@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

        // Create an Admin User
        $admin = User::create([
            'name' => 'Sunday Shima',
            'email' => 'admin9@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

         // Create an Admin User
         $admin = User::create([
            'name' => 'Sunday Shima',
            'email' => 'admin10@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

         // Create an Admin User
         $admin = User::create([
            'name' => 'Sunday Shima',
            'email' => 'admin11@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

         // Create an Admin User
         $admin = User::create([
            'name' => 'Sunday Shima',
            'email' => 'admin12@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

         // Create an Admin User
         $admin = User::create([
            'name' => 'Sunday Shima',
            'email' => 'admin13@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

         // Create an Admin User
         $admin = User::create([
            'name' => 'Sunday Shima',
            'email' => 'admin14@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

        // Create an Admin User
        $admin = User::create([
            'name' => 'Sunday Shima',
            'email' => 'admin15@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');

        // Create an Admin User
        $admin = User::create([
            'name' => 'Sunday Shima',
            'email' => 'admin16@bdic.com',
            'password' => bcrypt('123456'),
            'default_role' => 'Admin',
            'status' => 'active',
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('Admin');
    }
}
