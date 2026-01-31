<?php

namespace Database\Factories;

use App\Models\Favori;
use App\Models\Utilisateur;
use App\Models\Annonce;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Favori::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'locataire_id' => Utilisateur::inRandomOrder()->first()->id,  // Utilisateur random
            'annonce_id' => Annonce::inRandomOrder()->first()->id,  // Annonce random
            'date_d_ajout_fav' => $this->faker->date(),
        ];
    }
}
