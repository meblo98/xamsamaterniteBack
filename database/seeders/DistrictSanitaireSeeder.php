<?php

namespace Database\Seeders;

use App\Models\DistrictSanitaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSanitaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DistrictSanitaire::create(['nom' => 'District de Dakar Nord', 'region_medical_id' => 1]);
        DistrictSanitaire::create(['nom' => 'District de Kaolack', 'region_medical_id' => 2]);
        DistrictSanitaire::create(['nom' => 'District de Saint-Louis', 'region_medical_id' => 3]);
        DistrictSanitaire::create(['nom' => 'District de Thies Est', 'region_medical_id' => 4]);
        DistrictSanitaire::create(['nom' => 'District de Ziguinchor', 'region_medical_id' => 5]);

    }
}
