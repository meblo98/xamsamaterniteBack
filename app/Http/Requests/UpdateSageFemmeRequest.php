<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSageFemmeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autoriser toutes les requêtes pour cet exemple, adapte-le si nécessaire
    }

    public function rules()
    {
        $sageFemmeId = $this->route('sage_femme'); // Récupérer l'ID de la sage-femme en cours de mise à jour

        return [
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $sageFemmeId,
            'telephone' => 'sometimes|integer|unique:users,telephone,' . $sageFemmeId,
            'adresse' => 'nullable|string',
            'photo' => 'nullable|string',
            'matricule' => 'sometimes|string',
            'structure_sante_id' => 'sometimes|exists:structure_santes,id',
        ];
    }
}
