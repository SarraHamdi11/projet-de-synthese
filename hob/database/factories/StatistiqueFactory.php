<?php

namespace Database\Factories;

use App\Models\Statistique;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatistiqueFactory extends Factory
{
    protected $model = Statistique::class;

    public function definition(): array
    {
        return [
            'nombre_utilisateur' => $this->faker->numberBetween(0, 1000),
            'nombre_annonce' => $this->faker->numberBetween(0, 500),
            'note_moyenne_annonce' => $this->faker->optional()->randomFloat(2, 0, 5),
            'nombre_reservation' => $this->faker->numberBetween(0, 1000),
            'nombre_reservation_annule' => $this->faker->numberBetween(0, 100),
            'nombre_reservation_accepter' => $this->faker->numberBetween(0, 1000),
            'nombre_reservation_en_attente' => $this->faker->numberBetween(0, 100),
            'note_moyenne_utilisateur' => $this->faker->optional()->randomFloat(2, 0, 5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
