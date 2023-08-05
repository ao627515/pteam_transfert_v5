<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Unique;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = ['administrateur', 'opérateur'];
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
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'telephone' => fake()->randomNumber($nbDigits = 8, $strict = true),
            'email' => fake()->unique(true, 1000)->freeEmail(),
            'password' => Hash::make('12345678'),
            'role' => Arr::random($roles),
            'localisation' => Arr::random($villes),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
