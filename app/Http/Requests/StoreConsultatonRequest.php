<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultatonRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autorise cette validation pour tous les utilisateurs
    }

    public function rules()
    {
        return [
            'date' => 'nullable|date',
            'terme' => 'nullable|string',
            'SA' => 'nullable|string',
            'plaintes' => 'nullable|string',
            'mois' => 'nullable|integer',
            'poids' => 'nullable|numeric',
            'taille' => 'nullable|numeric',
            'PB' => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'urine' => 'nullable|string',
            'sucre' => 'nullable|string',
            'TA' => 'nullable|string',
            'pouls' => 'nullable|integer',
            'EG' => 'nullable|string',
            'muqueuse' => 'nullable|string',
            'mollet' => 'nullable|string',
            'OMI' => 'nullable|string',
            'examen_seins' => 'nullable|string',
            'hu' => 'nullable|string',
            'speculum' => 'nullable|string',
            'tv' => 'nullable|string',
            'fer_ac_folique' => 'nullable|string',
            'milda' => 'nullable|string',
            'autre_traitement' => 'nullable|string',
            'maf' => 'nullable|string',
            'bdcf' => 'nullable|string',
            'alb' => 'nullable|string',
            'vat' => 'nullable|string',
            'tpi' => 'nullable|string',
            'palpation' => 'nullable|string',
            'bdc' => 'nullable|string',
            'presentation' => 'nullable|string',
            'bassin' => 'nullable|string',
            'pelvimetre_externe' => 'nullable|string',
            'pelvimetre_interne' => 'nullable|string',
            'biischiatique' => 'nullable|numeric',
            'trillat' => 'nullable|numeric',
            'lign_innominees' => 'nullable|string',
            'autre_examen' => 'nullable|string',
            'resultat' => 'nullable|string',
            'lieu_accouchement_apre_consentement' => 'nullable|string',
            'sage_femme_id' => 'required|exists:sage_femmes,id',
            'rendez_vous_id' => 'required|exists:rendez_vouses,id',
        ];
    }
}
