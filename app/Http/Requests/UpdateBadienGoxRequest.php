<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBadienGoxRequest extends FormRequest
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
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $this->route('badienGox'),
            'adresse' => 'sometimes|string|max:255',
            'telephone' => 'sometimes|string|max:20',
        ];
    }
}
