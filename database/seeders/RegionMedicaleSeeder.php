<?php

namespace Database\Seeders;

use App\Models\RegionMedical;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionMedicaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RegionMedical::create(['nom' => 'Dakar']);
        RegionMedical::create(['nom' => 'Kaolack']);
        RegionMedical::create(['nom' => 'Saint-Louis']);
        RegionMedical::create(['nom' => 'Thies']);
        RegionMedical::create(['nom' => 'Ziguinchor']);
    }
}
