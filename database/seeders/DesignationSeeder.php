<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('designations')->insert([
            [
                'name' => 'Commisioner',
            ],
            [
                'name' => 'Director',
            ],
            [
                'name' => 'Permanenet Secretary',
            ],
            [
                'name' => 'Deputy Director',
            ],
            [
                'name' => 'Senior Admin Officer',
            ],
            [
                'name' => 'Admin Officer',
            ],
            [
                'name' => 'System Admin',
            ],
            [
                'name' => 'Director General',
            ],
            [
                'name' => 'Managing Director',
            ],
            [
                'name' => 'Board Secretary',
            ],
            [
                'name' => 'Chairman',
            ],
            [
                'name' => 'Confidential Secretary',
            ],
            [
                'name' => 'Staff Officer',
            ],
            [
                'name' => 'Executive Officer',
            ],
            [
                'name' => 'Clerical Officer',
            ],
            [
                'name' => 'Statistician General',
            ],
            
        ]);
        // $designations = [
        //     'Director',
        //     'Deputy Director',
        //     'Assistant Director',
        //     'Secretary',
        //     'Deputy Secretary',
        //     'Assistant Secretary',
        //     'Permanent Secretary',
        //     'Under Secretary',
        //     'Deputy Under Secretary',
        //     'Assistant Under Secretary',
        //     'Director General',
        //     'Deputy Director General',
        //     'Assistant Director General',
        //     'Director of Finance',
        //     'Deputy Director of Finance',
        //     'Assistant Director of Finance',
        //     'Director of Administration',
        //     'Deputy Director of Administration',
        //     'Assistant Director of Administration',
        //     'Director of Human Resources',
        //     'Deputy Director of Human Resources',
        //     'Assistant Director of Human Resources',
        //     'Director of Procurement',
        //     'Deputy Director of Procurement',
        //     'Assistant Director of Procurement',
        //     'Director of Planning',
        //     'Deputy Director of Planning',
        //     'Assistant Director of Planning',
        //     'Director of Audit',
        //     'Deputy Director of Audit',
        //     'Assistant Director of Audit',
        //     'Director of Legal Services',
        //     'Deputy Director of Legal Services',
        //     'Assistant Director of Legal Services',
        //     'Director of Information Technology',
        //     'Deputy Director of Information Technology',
        //     'Assistant Director of Information Technology',
        //     'Director of Public Relations',
        //     'Deputy Director of Public Relations',
        //     'Assistant Director of Public Relations',
        //     'Director of Research',
        //     'Deputy Director of Research',
        //     'Assistant Director of Research',
        //     'Director of Monitoring and Evaluation',
        //     'Deputy Director of Monitoring and Evaluation',
        //     'Assistant Director of Monitoring and Evaluation',
        //     'Director of Policy',
        //     'Deputy Director of Policy',
        //     'Assistant Director of Policy',
        //     'Director of Programmes',
        //     'Deputy Director of Programmes',
        //     'Assistant Director of Programmes',
        //     'Director of Projects',
        //     'Deputy Director of Projects',
        //     'Assistant Director of Projects',
        //     'Director of Operations',
        //     'Deputy Director of Operations',
        //     'Assistant Director of Operations',
        //     'Director of Logistics',
        //     'Deputy Director of Logistics',
        //     'Assistant Director of Logistics',
        //     'Director of Security',
        //     'Deputy Director of Security',
        //     'Assistant Director of Security',
        //     'Director of Welfare',
        //     'Deputy Director of Welfare',
        //     'Assistant Director of Welfare',
        //     'Director of Health',
        //     'Deputy Director of Health',
        //     'Assistant Director of Health',
        // ];
    }
}
