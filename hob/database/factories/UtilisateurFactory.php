<?php

namespace Database\Factories;

use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UtilisateurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Utilisateur::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom_uti' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email_uti' => $this->faker->unique()->safeEmail,
            'mot_de_passe_uti' => bcrypt('password'),
            'role_uti' => $this->faker->randomElement(['locataire', 'colocataire', 'proprietaire', 'admin']),
            'photodeprofil_uti' => $this->faker->imageUrl(400, 400, 'people', true),
            'tel_uti' => $this->faker->phoneNumber,
            'date_inscription_uti' => $this->faker->date(),
            'ville' => $this->faker->city,
            'date_naissance' => $this->faker->date(),
        ];
    }
}
