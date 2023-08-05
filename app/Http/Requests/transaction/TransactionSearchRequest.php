<?php

namespace App\Http\Requests\transaction;

use Illuminate\Foundation\Http\FormRequest;

class TransactionSearchRequest extends FormRequest
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
            'nom_beneficiaire' => ['nullable', 'string'],
            'prenom_beneficiaire' => ['nullable', 'string'],
            'telephone_beneficiaire' => ['nullable', 'string'],
            'ville_origine' => ['nullable', 'string'],
            'ville_destinataire' => ['nullable', 'string'],
            'nom_expediteur' => ['nullable', 'string'],
            'prenom_expediteur' => ['nullable', 'string'],
            'telephone_expediteur' => ['nullable', 'string'],
            'montant' => ['nullable', 'string'],
            'code_retrait' => ['nullable', 'string'],
            'etat' => ['nullable', 'integer'],
            'date_retrait' => ['nullable', 'date'],
            'date_transfert' => ['nullable', 'date'],
            //'user_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
