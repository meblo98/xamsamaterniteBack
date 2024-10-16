<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrossesseRequest extends FormRequest
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
            // 'patiente_id' => ['nullable','exists:patientes,id'],
            // 'date_debut' => ['nullable','date'],
            // 'date_prevue_accouchement' => ['nullable','date','after:date_debut'],
        ];
    }
}
