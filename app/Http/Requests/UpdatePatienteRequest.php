<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatienteRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Mettre à jour selon vos besoins de sécurité
    }

    public function rules()
    {
        return [
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'adresse' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255',
            'telephone' => 'sometimes|numeric',
            'lieu_de_naissance' => 'sometimes|string',
            'date_de_naissance' => 'sometimes|string',
            'profession' => 'sometimes|string',
            'type' => 'sometimes|in:Enceinte,En planning,Allaitente',
            'sage_femme_id' => 'sometimes|exists:sage_femmes,id',
        ];
    }
}
