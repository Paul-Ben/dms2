<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_details')->insert([
            [
                'user_id' => 1,
                'nin_number' => '123456789',
                'gender' => 'male',
                'phone_number' => '123456789',
                'designation' => 'System Admin',
                'avatar' => 'avatar.png',
                'signature' => 'signature.png',
                'department_id' => null,
                'tenant_id' => null,
            ],
            [
                'user_id' => 2,
                'nin_number' => '123456789',
                'gender' => 'female',
                'phone_number' => '123456789',
                'designation' => 'Head of Service',
                'avatar' => 'avatar.png',
                'signature' => 'signature.png',
                'department_id' => null,
                'tenant_id' => 3,
            ],
            [
                'user_id' => 3,
                'nin_number' => '123456789',
                'gender' => 'male',
                'phone_number' => '123456789',
                'designation' => 'Permanent Secretary',
                'avatar' => 'avatar.png',
                'signature' => 'signature.png',
                'department_id' => 2,
                'tenant_id' => 3,
            ],
            [
                'user_id' => 4,
                'nin_number' => '123456789',
                'gender' => 'male',
                'phone_number' => '123456789',
                'designation' => 'User',
                'avatar' => 'avatar.png',
                'signature' => 'signature.png',
                'department_id' => null,
                'tenant_id' => null,
            ],

        ]);
    }
}
