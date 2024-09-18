<?php

namespace Database\Seeders;

use App\Models\StructureSante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StructureSanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StructureSante::create(['nom' => 'Centre de Santé Philippe Maguilen Senghor', 'district_sanitaire_id' => 1,'lieu' => 'Keur Madiabel']);
        StructureSante::create(['nom' => 'Centre de Santé de Kaolack', 'district_sanitaire_id' => 2,'lieu' => 'Keur Madiabel']);
        StructureSante::create(['nom' => 'Poste de Santé de Keur Madiabel', 'district_sanitaire_id' => 2,'lieu' => 'Keur Madiabel']);
        StructureSante::create(['nom' => 'Centre de Santé de Saint-Louis', 'district_sanitaire_id' => 3,'lieu' => 'Keur Madiabel']);
        StructureSante::create(['nom' => 'Centre de Santé de Thies', 'district_sanitaire_id' => 4,'lieu' => 'Keur Madiabel']);
    }
}
