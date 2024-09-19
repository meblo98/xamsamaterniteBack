<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccouchementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patiente_id' => 'required|exists:patientes,id',
             'lieu' => 'required|in:maternité,domicile',
             'mode' => 'required|in:naturel,instrumental,césarienne',
             'date' => 'required|date',
             'heure' => 'required|date_format:H:i',
             'terme' => 'required|string',
             'mois_grossesse' => 'required|integer|min:1|max:9',
             'debut_travail' => 'required|date_format:H:i',
             'perinee' => 'required|in:intact,episiotomie,dechirure',
             'pathologie' => 'nullable|string',
             'evolution_reanimation' => 'required|in:favorable,transfert,décès',
        ];
    }
}
