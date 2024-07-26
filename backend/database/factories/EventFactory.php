<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 6),
            'client_id' => $this->faker->numberBetween(1, 10),
            'reserve_at' => $this->faker->dateTimeThisYear(),
            'type' => $this->faker->randomElement(['Matrimonio','Cumpleaños','Reuniones','Bautizo']),
            'event_date' => $this->faker->date(),
            'guests' => $this->faker->numberBetween(1, 100),
            'cost' => $this->faker->randomFloat(2, 100, 1000),
            'status' => $this->faker->randomElement(['Completado','Cancelado','Pagando']),
        ];
    }
}
