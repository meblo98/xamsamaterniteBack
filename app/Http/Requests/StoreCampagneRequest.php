<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampagneRequest extends FormRequest
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
            // 'nom' => 'required|string|max:255',
            // 'description' => 'required|string',
            // 'image' => 'required|string',
            // 'date_debut' => 'required|date',
            // 'date_fin' => 'required|date|after_or_equal:date_debut',
            // 'badien_gox_id' => 'required|exists:badien_goxes,id',
        ];
    }
}
