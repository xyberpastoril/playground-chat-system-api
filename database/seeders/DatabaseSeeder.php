<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PSGC\RegionSeeder;
use Database\Seeders\PSGC\ProvinceSeeder;
use Database\Seeders\PSGC\MunCitySeeder;
use Database\Seeders\PSGC\BarangaySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RegionSeeder::class,
            ProvinceSeeder::class,
            MunCitySeeder::class,
            BarangaySeeder::class,
        ]);

        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'email' => 'test@helpinghand.ph',
        ]);
    }
}
