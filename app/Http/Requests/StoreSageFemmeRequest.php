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
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Vérifie l'unicité de l'email
            'telephone' => 'required|unique:users,telephone', // Vérifie l'unicité du téléphone
            'adresse' => 'required|string|max:255',
            'matricule' => 'required|string|max:255|unique:sage_femmes,matricule', // Unicité du matricule
        ];
    }
}
