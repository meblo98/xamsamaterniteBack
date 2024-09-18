<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCampagneRequest extends FormRequest
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
            'nom' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'sometimes|string',
            'date_debut' => 'sometimes|date',
            'date_fin' => 'sometimes|date|after_or_equal:date_debut',
            'badien_gox_id' => 'sometimes|exists:badien_goxes,id',
        ];
    }
}
