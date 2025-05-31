<?php

namespace Database\Factories;

use App\Models\Annonce;
use App\Models\Logement;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnonceFactory extends Factory
{
    protected $model = Annonce::class;

    public function definition(): array
    {
        return [
            'titre_anno' => $this->faker->word(),
            'description_anno' => $this->faker->text(),
            'statut_anno' => $this->faker->randomElement(['active', 'inactive']),
            'date_publication_anno' => $this->faker->date(),
            'logement_id' => Logement::factory(),
            'proprietaire_id' => Utilisateur::factory(),
        ];
    }
}
