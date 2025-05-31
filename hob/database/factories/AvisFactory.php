<?php

namespace Database\Factories;

use App\Models\Avis;
use App\Models\Annonce;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvisFactory extends Factory
{
    protected $model = Avis::class;

    public function definition(): array
    {
        return [
            'contenu' => $this->faker->text(),
            'note' => $this->faker->numberBetween(1, 5),
            'annonce_id' => Annonce::factory(),
            'locataire_id' => Utilisateur::factory(),
        ];
    }
}
