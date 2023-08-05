<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'nom_expediteur',
        'prenom_expediteur',
        'telephone_expediteur',
        'ville_origine',
        'ville_destinataire',
        'nom_beneficiaire',
        'prenom_beneficiaire',
        'telephone_beneficiaire',
        'code_retrait',
        'montant',
        'etat',
        'date_retrait',
        'date_transfert',
        'user_id'
    ];



    public function user () {
        return $this->belongsTo(\App\Models\User::class);
    }
}
