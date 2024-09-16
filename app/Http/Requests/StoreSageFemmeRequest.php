<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSageFemmeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autoriser toutes les requêtes pour cet exemple, adapte-le si nécessaire
    }

    public function rules()
    {
        return [
            // 'prenom' => 'required|string|max:255',
            // 'nom' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email',
            // 'telephone' => 'required|integer|unique:users,telephone',
            // 'adresse' => 'nullable|string',
            // 'photo' => 'nullable|string',
            // 'matricule' => 'required|string',
            // 'structure_sante_id' => 'required|exists:structure_santes,id',
        ];
    }
}
