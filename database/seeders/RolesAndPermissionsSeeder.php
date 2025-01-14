<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = Role::create(['name' => 'superadmin']);
        $admin = Role::create(['name' => 'Admin']);
        $staff = Role::create(['name'=> 'Staff']);
        $user = Role::create(['name' => 'User']);
        $user = Role::create(['name' => 'Secretary']);
    }
}
