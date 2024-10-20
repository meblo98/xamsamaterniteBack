<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnfantRequest extends FormRequest
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
            'nom' => 'sometimes|string',
            'prenom' => 'sometimes|string',
            'lieu_naissance' => 'required|string',
            'date_naissance' => 'required|date|before_or_equal:today',
            'sexe' => 'required|string',
            'accouchement_id' => 'required|exists:accouchements,id'
        ];
    }
}
