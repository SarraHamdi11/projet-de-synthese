<?php

namespace Database\Factories;

use App\Models\Administrateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdministrateurFactory extends Factory
{
    protected $model = Administrateur::class;

    public function definition(): array
    {
        return [
            'nom_ad' => $this->faker->lastName(),
            'email_ad' => $this->faker->unique()->safeEmail(),
            'mot_de_passe_ad' => bcrypt('password'), // Mot de passe par défaut
            'role_ad' => $this->faker->randomElement(['super_admin', 'moderateur', 'support']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
