<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'sender_id' => 1, // You may want to randomize or relate to a user factory
            'receiver_id' => 2, // You may want to randomize or relate to a user factory
            'message' => $this->faker->sentence(),
            'is_read' => $this->faker->boolean(70),
            'read_at' => null,
            'message_type' => 'text',
            'attachments' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
