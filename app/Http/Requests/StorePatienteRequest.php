<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;

class StorePatienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'adresse' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            // 'telephone' => ['required', 'digits_between:9,15', 'unique:users,telephone'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'lieu_de_naissance' => ['required', 'string', 'max:255'],
            'date_de_naissance' => ['required', 'date'],
            'profession' => ['required', 'string', 'max:255'],
            'badien_gox_id' => ['required', 'exists:badien_goxes,id'],
        ];
    }
    
}

