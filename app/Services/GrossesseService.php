<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\RendezVous;

class GrossesseService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public static function planifierRendezVous($grossesse)
    {
        $rendezVousPlan = [
            ['libelle' => 'VAT 1', 'semaine' => 1],
            ['libelle' => 'VAT 2', 'semaine' => 5],
            ['libelle' => 'CPN 1', 'semaine' => 12],
            ['libelle' => 'CPN 2', 'semaine' => 16],
            ['libelle' => 'CPN 3', 'semaine' => 20],
            ['libelle' => 'CPN 4', 'semaine' => 24],
            ['libelle' => 'VAT 3', 'semaine' => 32],
            ['libelle' => 'CPN 5', 'semaine' => 28],
            ['libelle' => 'CPN 6', 'semaine' => 32],
            ['libelle' => 'CPN 7', 'semaine' => 34],
            ['libelle' => 'CPN 8', 'semaine' => 36],
            ['libelle' => 'CPoN 1', 'semaine' => 32],
            ['libelle' => 'CPoN 2', 'semaine' => 32],
            ['libelle' => 'CPoN 3', 'semaine' => 32],
            ['libelle' => 'VAT 4', 'semaine' => 64],
            ['libelle' => 'VAT 5', 'semaine' => 96],
        ];

        foreach ($rendezVousPlan as $plan) {
            $dateRendezVous = Carbon::parse($grossesse->date_debut)->addWeeks($plan['semaine']);
            RendezVous::create([
                'grossesse_id' => $grossesse->id,
                'date_rv' => $dateRendezVous,
                'libelle' => $plan['libelle'], // Remplacez par l'ID correct de la visite si nécessaire
            ]);
        }
    }
}
