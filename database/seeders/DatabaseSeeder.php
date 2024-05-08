<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $file_kota = public_path('json/kota.json');
        $json_kota = file_get_contents($file_kota);
        $data_kota = json_decode($json_kota, true);

        DB::table('kotas')->insert($data_kota);
        $this->call(RolePermissionSeeder::class);
        $this->call(OrganizationTypeSeeder::class);
        $this->call(OrganizationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LembagaAkreditasiSeeder::class);
        $this->call(PeringkatAkreditasiSeeder::class);
        $this->call(JabatanSeeder::class);
        // $this->call(OrganizationStatusSeeder::class);
    }
}
