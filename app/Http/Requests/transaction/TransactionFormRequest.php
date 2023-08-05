<?php

namespace App\Http\Requests\transaction;

use Illuminate\Foundation\Http\FormRequest;

class TransactionFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nom_beneficiaire' => ['required', 'string'],
            'prenom_beneficiaire' => ['required', 'string'],
            'telephone_beneficiaire' => ['required', 'string'],
            'ville_origine' => ['required', 'string'],
            'ville_destinataire' => ['required', 'string'],
            'nom_expediteur' => ['required', 'string'],
            'prenom_expediteur' => ['required', 'string'],
            'telephone_expediteur' => ['required', 'string'],
            'montant' => ['required', 'string'],
            'user_id' => ['required', 'string'],
        ];
    }
}
