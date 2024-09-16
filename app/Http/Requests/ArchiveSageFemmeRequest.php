<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArchiveSageFemmeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autoriser toutes les requêtes pour cet exemple, adapte-le si nécessaire
    }

    public function rules()
    {
        return [
            'archived' => 'required|boolean',
        ];
    }
}
