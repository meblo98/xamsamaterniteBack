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
            // 'prenom' => 'nullable|string|max:255',
            // 'nom' => 'nullable|string|max:255',
            // 'adresse' => 'nullable|string|max:255',
            // 'email' => 'nullable|email|unique:users,email,' . $userId . ',id',
            // 'telephone' => 'nullable|string|unique:users,telephone,' . $userId . ',id',
            // 'lieu_de_naissance' => 'nullable|string',
            // 'date_de_naissance' => 'nullable|string',
            // 'profession' => 'nullable|string',
        ];
    }
}
