<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization_statuses = [
            [
                'org_status' => 'Aktif',
                'id_organization' => 'QrnhEoXFt402Bx5n'
            ]
        ];

        DB::table('organization_statuses')->insert($organization_statuses);
    }
}
