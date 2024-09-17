<?php

namespace Database\Seeders;

use App\Models\Visite;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VisiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Visite::create(['libelle' => 'CPN1']);
        Visite::create(['libelle' => 'CPN2']);
        Visite::create(['libelle' => 'CPN3']);
        Visite::create(['libelle' => 'CPN4']);
        Visite::create(['libelle' => 'CPN5']);
        Visite::create(['libelle' => 'CPN6']);
        Visite::create(['libelle' => 'CPN7']);
        Visite::create(['libelle' => 'CPN8']);
        Visite::create(['libelle' => 'VAT1']);
        Visite::create(['libelle' => 'VAT2']);
        Visite::create(['libelle' => 'VAT3']);
        Visite::create(['libelle' => 'VAT4']);
        Visite::create(['libelle' => 'VAT5']);
        Visite::create(['libelle' => 'visite post-natale 1']);
        Visite::create(['libelle' => 'visite post-natale 2']);
        Visite::create(['libelle' => 'visite post-natale 3']);
    }
}
