<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    protected $model = Conversation::class;

    public function definition(): array
    {
        return [
            'date_debut_conv' => $this->faker->date(),
            'expediteur_id' => Utilisateur::factory(), // Crée un utilisateur pour l'expéditeur
            'destinataire_id' => Utilisateur::factory(), // Crée un utilisateur pour le destinataire
        ];
    }
}
