<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBadienGoxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Autoriser la requête
    }

    public function rules()
    {
        return [
            // 'nom' => 'required|string|max:255',
            // 'prenom' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users',
            // 'telephone' => 'required|numeric|unique:users',
            // 'sage_femme_id' => 'required|exists:sage_femmes,id',
            // 'adresse' => 'required|string|max:255',
        ];
    }
}
