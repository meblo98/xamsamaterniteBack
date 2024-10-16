<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatienteRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Mettre à jour selon vos besoins de sécurité
    }

    public function rules()
    {
        return [
            // 'prenom' => 'required|string|max:255',
            // 'nom' => 'required|string|max:255',
            // 'adresse' => 'required|string|max:255',
            // 'email' => 'nullable|string|email|max:255|unique:users',
            // 'telephone' => 'required|numeric|unique:users',
            // 'password' => 'required|string|min:8',
            // 'lieu_de_naissance' => 'required|string',
            // 'date_de_naissance' => 'required|string',
            // 'profession' => 'required|string',
            // 'type' => 'required|in:Enceinte,En planning,Allaitente',
        ];
    }
}
