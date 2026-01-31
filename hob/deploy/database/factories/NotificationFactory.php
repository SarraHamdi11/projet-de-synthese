<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'data' => ['message' => $this->faker->text()],
            'type' => $this->faker->randomElement(['reservation', 'message', 'systeme']),
            'read_at' => null,
            'notifiable_type' => 'App\\Models\\Utilisateur',
            'notifiable' => Utilisateur::factory(),
        ];
    }
}
