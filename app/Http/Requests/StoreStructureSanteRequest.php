<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStructureSanteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'name' => 'required|string|max:255',
            // 'lieu' => 'required|string|max:255',
            // 'district_sanitaire_id' => 'required|integer|exists:district_sanitaires,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nom.required' => 'Le nom de la structure de santé est obligatoire.',
            'nom.string' => 'Le nom de la structure de santé doit être une chaîne de caractères.',
            'nom.max' => 'Le nom de la structure de santé ne peut pas dépasser 255 caractères.',
            'lieu.required' => 'L\'adresse de la structure de santé est obligatoire.',
            'lieu.string' => 'L\'adresse de la structure de santé doit être une chaîne de caractères.',
            'lieu.max' => 'L\'adresse de la structure de santé ne peut pas dépasser 255 caractères.',
            'district_sanitaire_id.required' => 'Le district sanitaire est obligatoire.',
            'district_sanitaire_id.integer' => 'Le district sanitaire doit être un entier.',
            'district_sanitaire_id.exists' => 'Le district sanitaire doit exister dans la base de données.',
        ];
    }
}