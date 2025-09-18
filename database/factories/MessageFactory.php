<?php

namespace Database\Factories;

use App\Models\User;
use App\Support\Enum\MessageStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'content' => $this->faker->text(160),
            'status' => $this->faker->randomElement(MessageStatus::cases()),
        ];
    }
}
