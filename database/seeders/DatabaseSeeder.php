<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'nom' => 'Ouedraogo',
            'prenom' => 'Abdoul Aziz',
            'telephone' => fake()->randomNumber($nbDigits = 8, $strict = true),
            'email' => 'ao627515@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'administrateur',
            'localisation' => 'Ouagadougou',
        ]);

        \App\Models\User::factory()->create([
            'nom' => 'Tapsoba',
            'prenom' => 'Farida',
            'telephone' => fake()->randomNumber($nbDigits = 8, $strict = true),
            'email' => fake()->unique(true, 100)->freeEmail(),
            'password' => Hash::make('12345678'),
            'role' => 'administrateur',
            'localisation' => 'Ouagadougou',
        ]);

        \App\Models\User::factory()->create([
            'nom' => 'So',
            'prenom' => 'Kevin',
            'telephone' => fake()->randomNumber($nbDigits = 8, $strict = true),
            'email' => fake()->unique(true, 100)->freeEmail(),
            'password' => Hash::make('12345678'),
            'role' => 'administrateur',
            'localisation' => 'Ouagadougou',
        ]);

        \App\Models\User::factory()->create([
            'nom' => 'Simporé',
            'prenom' => 'Elie',
            'telephone' => fake()->randomNumber($nbDigits = 8, $strict = true),
            'email' => 'operateur@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'opérateur',
            'localisation' => 'Ouagadougou',
        ]);

        \App\Models\User::factory()->create([
            'nom' => 'Sanfo',
            'prenom' => 'Mahamadi',
            'telephone' => fake()->randomNumber($nbDigits = 8, $strict = true),
            'email' => fake()->unique(true, 100)->freeEmail(),
            'password' => Hash::make('12345678'),
            'role' => 'opérateur',
            'localisation' => 'Ouagadougou',
        ]);

        \App\Models\User::factory()->create([
            'nom' => 'Pr',
            'prenom' => 'Ibrahim',
            'telephone' => fake()->randomNumber($nbDigits = 8, $strict = true),
            'email' => fake()->unique(true, 100)->freeEmail(),
            'password' => Hash::make('12345678'),
            'role' => 'administrateur',
            'localisation' => 'Ouagadougou',
        ]);

        User::factory(300)->create([
            'role'=> 'administrateur'
        ]);

        User::factory(700)->create([
            'role'=> 'opérateur'
        ]);

        Transaction::factory(10000)->create();
    }
}
