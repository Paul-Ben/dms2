<?php

namespace Database\Seeders;

use App\Models\TenantDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = TenantDepartment::create([
            'name' => 'General Users',
            'email' => 'gus33@bngh.ng',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 1
        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Protocol Office',
            'email' => 'gh1@bngh.ng',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 2
        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Bureau of Administrative',
            'email' => 'ba@bnsg.com',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 3
        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Bureau of Service Welfare',
            'email' => 'bsw@bnsg.com',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 3
        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Bureau of Manpower Development and Training',
            'email' => 'bmdt@bnsg.com',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 3

        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Office of the Head of Service',
            'email' => 'bmdt@bnsg.com',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 3

        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Office of the MD Benue Hospitals Management Board',
            'email' => 'hmb@bnsg.com',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 31

        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Office of the MD Benue Primary Healthcare Board',
            'email' => 'hmb@bnsg.com',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 34

        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Office of the Commissioner MOE',
            'email' => 'hmb@bnsg.com',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 14

        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Office of the MD BDIC',
            'email' => 'md@bdic.ng',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 36

        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Office of the Statistician General',
            'email' => 'sg@bdic.ng',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 33

        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Office of the MD BEQA',
            'email' => 'beqa@bdic.ng',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 37

        ]);
        $tenant = TenantDepartment::create([
            'name' => 'Office of the Commissioner MWHUD',
            'email' => 'mwhud@bdic.ng',
            'phone' => '09087767543',
            'status' => 'active',
            'tenant_id' => 9

        ]);
    }
}
