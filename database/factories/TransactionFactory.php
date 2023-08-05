<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $villes = [
            "Aribinda",
            "Bagré",
            "Banfora",
            "Batié",
            "Bobo-Dioulasso",
            "Bogandé",
            "Bondigui",
            "Boromo",
            "Boulsa",
            "Boussé",
            "Dano",
            "Dédougou",
            "Diapaga",
            "Diébougou",
            "Djibo",
            "Dori",
            "Fada N'gourma",
            "Gaoua",
            "Garango",
            "Gayéri",
            "Gorom-Gorom",
            "Gourcy",
            "Houndé",
            "Kampti",
            "Kantchari",
            "Kaya",
            "Kindi",
            "Kokologo",
            "Kombissiri",
            "Kongoussi",
            "Kordié",
            "Koudougou",
            "Kouka",
            "Bam",
            "Kouka",
            "Banwa",
            "Koupéla",
            "Léo",
            "Loropeni",
            "Manga",
            "Méguet",
            "Mogtedo",
            "Niangoloko",
            "Nouna",
            "Orodara",
            "Ouagadougou",
            "Ouahigouya",
            "Ouargaye",
            "Pama",
            "Pissila",
            "Pô",
            "Pouytenga",
            "Réo",
            "Saponé",
            "Sapouy",
            "Sebba",
            "Séguénéga",
            "Sindou",
            "Solenzo",
            "Tangin Dassouri",
            "Tenkodogo",
            "Tikaré",
            "Titao",
            "Toma",
            "Tougan",
            "Villy",
            "Yako",
            "Ziniaré",
            "Zorgo"
        ];

        $etat = fake()->numberBetween(1, 3);
        $date_transfert = fake()->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null);
        if ($etat == 1) {
            $date_retrait = null;
        } elseif ($etat == 2) {
            $date_retrait = fake()->dateTimeBetween($date_transfert, 'now');
        } else {
            $date_retrait = null;
        }

        do {
            $code_retrait = Str::random(6);
        } while (Transaction::where('code_retrait', $code_retrait)->exists());

        return [
            'nom_expediteur' => fake()->lastName(),
            'prenom_expediteur' => fake()->firstName(),
            'telephone_expediteur' => fake()->randomNumber($nbDigits = 8, $strict = true),
            'ville_origine' => Arr::random($villes),
            'ville_destinataire' => Arr::random($villes),
            'nom_beneficiaire' => fake()->lastName(),
            'prenom_beneficiaire' => fake()->firstName(),
            'telephone_beneficiaire' => fake()->randomNumber($nbDigits = 8, $strict = true),
            'code_retrait' => $code_retrait,
            'montant' => fake()->numberBetween($min = 1000, $max = 1000000),
            'etat' => $etat,
            'date_retrait' => $date_retrait,
            'date_transfert' => $date_transfert,
            'user_id' => User::inRandomOrder()->first()->id,
        ];

    }
}
