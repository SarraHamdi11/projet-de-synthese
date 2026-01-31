<?php

namespace Database\Factories;

use App\Models\Logement;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogementFactory extends Factory
{
    protected $model = Logement::class;

    public function definition(): array
    {
        return [
            'prix_log' => $this->faker->randomFloat(2, 100, 1500),
            'localisation_log' => $this->faker->address,
            'date_creation_log' => $this->faker->date(),
            'type_log' => $this->faker->randomElement(['studio', 'appartement', 'maison']),
            'equipements' => $this->faker->randomElement([json_encode(['Wi-Fi', 'Climatisation']), json_encode(['TV', 'Four'])]),
            'photos' => $this->faker->randomElement([json_encode(['photo1.jpg', 'photo2.jpg']), json_encode(['photo3.jpg'])]),
            'etage' => $this->faker->numberBetween(1, 10),
            'nombre_colocataire_log' => $this->faker->numberBetween(1, 5),
            'ville' => $this->faker->city,
            'views' => $this->faker->numberBetween(0, 500),
        ];
    }
}
