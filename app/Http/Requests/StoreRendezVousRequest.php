<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRendezVousRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'patiente_id' => 'required|exists:patientes,id',
            'visite_id' => 'nullable|exists:visites,id',
            'vaccination_id' => 'nullable|exists:vaccinations,id',
            'date_rv' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'patiente_id.required' => 'La patiente est obligatoire.',
            'patiente_id.exists' => 'La patiente sélectionnée est invalide.',
            'sage_femme_id.required' => 'La sage-femme est obligatoire.',
            'sage_femme_id.exists' => 'La sage-femme sélectionnée est invalide.',
            'visite_id.exists' => 'La visite sélectionnée est invalide.',
            'vaccination_id.exists' => 'La vaccination sélectionnée est invalide.',
            'date_rv.required' => 'La date du rendez-vous est obligatoire.',
            'date_rv.date' => 'La date du rendez-vous doit être une date valide.',
        ];
    }
}
