<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Utilisateur;
use App\Models\Logement;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        return [
            'date_debut_res' => $this->faker->date(),
            'date_fin_res' => $this->faker->date(),
            'statut_res' => $this->faker->randomElement(['en_attente', 'acceptee', 'annulee', 'terminee']),
            'locataire_id' => Utilisateur::factory(),
            'proprietaire_id' => Utilisateur::factory(),
            'logements_id' => Logement::factory(),
        ];
    }
}
