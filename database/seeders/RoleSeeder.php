<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Créer les rôles
         Role::create(['name' => 'admin']);
         Role::create(['name' => 'sage-femme']);
         Role::create(['name' => 'patiente']);
         Role::create(['name' => 'badiene-gox']);
    }
}
