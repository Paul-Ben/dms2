<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            TenantSeeder::class,
            TenantDepartmentSeeder::class,
            UserSeeder::class,
            DesignationSeeder::class,
            UserDetailsSeeder::class,

        ]);
    }
}
