<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Vaccination;

class EnfantService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function planifierVaccinations($enfant)
    {
        // Définir les vaccins et les âges auxquels ils doivent être administrés
        $vaccinationPlan = [
            ['nom' => 'Hépatite B zéro', 'semaine' => 0],
            ['nom' => 'VPO zéro', 'semaine' => 0],
            ['nom' => 'BCG', 'semaine' => 0],
            ['nom' => 'Pentavalent 1ière dose', 'semaine' => 6],
            ['nom' => 'VPO 1ière dose', 'semaine' => 6],
            ['nom' => 'PCV13 1ière dose', 'semaine' => 6],
            ['nom' => 'Rota 1ière dose', 'semaine' => 6],
            ['nom' => 'Pentavalent 2ième dose', 'semaine' => 10],
            ['nom' => 'VPO 2ième dose', 'semaine' => 10],
            ['nom' => 'PCV13 2ième dose', 'semaine' => 10],
            ['nom' => 'Rota 2ième dose', 'semaine' => 10],
            ['nom' => 'Pentavalent 3ième dose', 'semaine' => 14],
            ['nom' => 'VPO 3ième dose', 'semaine' => 14],
            ['nom' => 'PCV13 3ième dose', 'semaine' => 14],
            ['nom' => 'VPI', 'semaine' => 14],
            ['nom' => 'Vitamine A', 'semaine' => 24], // 6 months
            ['nom' => 'RR 1ière dose', 'semaine' => 36], // 9 months
            ['nom' => 'VAA', 'semaine' => 36], // 9 months
            ['nom' => 'Vit A-déparisitage', 'semaine' => 48], // 12 months
            ['nom' => 'RR 2ième dose', 'semaine' => 60], // 15 months
            ['nom' => 'Vit A-déparisitage', 'semaine' => 72], // 18 months
            ['nom' => 'Vit A-déparisitage', 'semaine' => 96], // 24 months
            ['nom' => 'Pentavalent 1er rappel', 'semaine' => 72], // 18 months
            ['nom' => 'PCV13 1er rappel', 'semaine' => 72], // 18 months
            ['nom' => 'VPI 1er rappel', 'semaine' => 72], // 18 months
            ['nom' => 'Vaccin anit méningocoque A+C', 'semaine' => 96], // 24 months
            ['nom' => 'Typhim VI', 'semaine' => 96], // 24 months
            ['nom' => 'Pentavalent 2ième rappel', 'semaine' => 312], // 6 years
            ['nom' => 'Typhim VI', 'semaine' => 312], // 6 years
            ['nom' => 'Vaccin anit méningocoque A+C', 'semaine' => 312], // 6 years
        ];

        // Créer les vaccinations prévues pour l'enfant
        foreach ($vaccinationPlan as $plan) {
            $dateVaccination = Carbon::parse($enfant->date_naissance)->addWeeks($plan['semaine']);
            Vaccination::create([
                'enfant_id' => $enfant->id,
                'nom' => $plan['nom'],
                'dose' => 1, // Tu peux ajuster la dose si nécessaire
                'date' => $dateVaccination,
            ]);
        }
    }
}
